<?php
/**
 * Provide service function to access data from database
 */
require_once dirname(__FILE__).'/ConnectionManager.php';
require_once dirname(__FILE__).'/Question.php';
require_once dirname(__FILE__).'/QuestionOption.php';
require_once dirname(__FILE__).'/Answer.php';
require_once dirname(__FILE__).'/Assessment.php';
require_once dirname(__FILE__).'/AssessmentTypes.php';
require_once dirname(__FILE__).'/User.php';

class DataService {
    public $connection;
    protected static $instance = null;
    protected $last_raw_statement;
    protected $last_params;
    protected $last_full_statement;

    /**
     * DataService constructor.
     * @throws Exception
     */
    protected function __construct ()
    {
        $cm = new ConnectionManager();
        $this->connection = mysqli_connect($cm->server, $cm->username, $cm->password, $cm->databasename, $cm->port);
        $this->throwExceptionOnError();
    }

    /**
     * @return DataService
     * @throws Exception
     */
    public static function getInstance() {
        if(DataService::$instance === null)
            DataService::$instance = new DataService();
        return DataService::$instance;
    }

    /** @param int $id
     * @return Assessment
     * @throws Exception
     */
    public function getAssessment($id)
    {
        $result = $this->query("SELECT * FROM assessments WHERE id=?", [$id]);
        return $this->fetchObject($result, Assessment::class);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOptionSets() {
        $result = $this->query("SELECT os.description AS set_name, o.label, o.value FROM question_option_sets os 
          JOIN question_options o ON os.id=o.option_set_id ORDER BY o.option_set_id, o.sequence");
        $options = $this->fetchAllObjects($result, QuestionOption::class);

        //create an associative array (where key is set name) of arrays of options
        //e.g. $sets['YesNo'] = [OptionYes, OptionNo]
        $sets = [];
        foreach($options as $option) {
            if(!array_key_exists($option->set_name, $sets)) {
                $sets[$option->set_name] = [];
            }
            $sets[$option->set_name][] = $option;
        }

        return $sets;
    }

    /**
     * @param $assessment_type int
     * @return Question[]
     * @throws Exception
     */
    public function getQuestionsByAssessment($assessment_type) {
        $result = $this->query("SELECT * FROM questions q JOIN assessment_questions aq ON q.id=aq.question_id
          WHERE aq.assessment_type=?", [$assessment_type]);
        return $this->fetchAllObjects($result, Question::class);
    }

    /**
     * @param $assessment_type int
     * @param $section int
     * @return Question[]
     * @throws Exception
     */
    public function getQuestionsBySection($assessment_type, $section) {
        $result = $this->query("SELECT * FROM questions q JOIN assessment_questions aq ON q.id=aq.question_id
          WHERE aq.assessment_type=? AND aq.section=?", [$assessment_type, $section]);
        return $this->fetchAllObjects($result, Question::class);
    }

    /**
     * @param $questions Question[]
     * @param $answers
     * @param $assessment_id int
     * @throws Exception
     */
    public function saveQuestionAnswers($questions, $answers, $assessment_id) {
        $values = [];
        foreach($questions as $question) {
            $code = $question->code;
            $values[] = "(".$assessment_id.",".$question->id.",'".$answers->$code."')";
        }
        $this->query("INSERT INTO answers (assessment_id, question_id, value) VALUES ".join(',',$values)."
            ON DUPLICATE KEY UPDATE value = VALUES(value)");
    }

    /**
     * @param $assessment_id int
     * @return Answer[]
     * @throws Exception
     */
    public function getAnswersByAssessment($assessment_id) {
        $result = $this->query("SELECT * FROM answers a JOIN questions q ON a.question_id=q.id
          JOIN assessment_questions aq ON aq.question_id=q.id 
          WHERE a.assessment_id=?", [$assessment_id]);
        return $this->fetchAllObjects($result, Answer::class);
    }

    /**
     * @param $assessment_id int
     * @param $section int
     * @return Answer[]
     * @throws Exception
     */
    public function getAnswersBySection($assessment_id, $section) {
        $result = $this->query("SELECT * FROM answers a JOIN questions q ON a.question_id=q.id
          JOIN assessment_questions aq ON aq.question_id=q.id 
          WHERE a.assessment_id=? AND aq.section=?", [$assessment_id, $section]);
        return $this->fetchAllObjects($result, Answer::class);
    }

    /**
     * @param $username string
     * @param $password string
     * @return User|null
     * @throws Exception
     */
    public function loginUser ($username, $password)
    {
        $result = $this->query("SELECT id, username, email, password, reset_code, admin, facility 
                      FROM users WHERE username='?' OR email='?'",[$username, $username]);

        if($row = $result->fetch_object()) {
            if(password_verify($password, $row->password)) {
                $user = new User();
                $user->fill($row);
                return $user;
            }
        }
        return null;
    }

    /**
     * @param $user_id int
     * @param $code string
     * @throws Exception
     */
    public function setResetCode ($user_id, $code)
    {
        $this->query("UPDATE users SET reset_code='?' WHERE id=?",[$code, $user_id]);
    }

    /**
     * @param $user_id int
     * @param $code string
     * @return bool
     * @throws Exception
     */
    public function checkResetCode ($user_id, $code)
    {
        $result = $this->query("SELECT reset_code FROM users WHERE id=?",[$user_id]);

        if($row = $result->fetch_object()) {
            return $code == $row->reset_code;
        }
        return false;
    }

    /**
     * @param $password string
     * @param $user_id int
     * @return bool
     * @throws Exception
     */
    public function updatePassword($password, $user_id)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->query("UPDATE users SET password='?' WHERE id=?",[$hash,$user_id]);

        return $result != null;
    }

    /**
     * @param $email string
     * @return User|null
     * @throws Exception
     */
    public function getUserByEmail ($email)
    {
        $result = $this->query("SELECT id, username, email FROM users WHERE email='?'",[$email]);
        return $this->fetchObject($result, User::class);
    }

    /**
     * @return User[]
     * @throws Exception
     */
    public function getUsers()
    {
        $result = $this->query("SELECT id, username, email FROM users");
        return $this->fetchAllObjects($result, User::class);
    }

    /**Run mysql query after escaping input
     * @param $stmt string
     * @param $params array
     * @return bool|mysqli_result
     * @throws Exception     */
    public function query($stmt, $params = null) {
        $this->last_raw_statement = $stmt;
        $this->last_params = $params;
        $this->last_full_statement = 'Unassigned';

        if($params != null) {
            for($i=0; $i<count($params); $i++) {
                $val = $params[$i];
                if($val === null) {
                    $val = 'NULL';
                }
                if($val === true)
                    $val = 1;
                if($val === false)
                    $val = 0;
                $params[$i] = $this->connection->real_escape_string($val);
            }
            $this->last_params = $params;
            $positions = array();
            $lastPos = 0;

            while (($lastPos = strpos($stmt, '?', $lastPos))!== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + 1;
            }
            if(count($positions) != count($params))
                throw new Exception("Unequal number of paramaters in Query: $stmt ||| ".count($positions)." expected, ".count($params)." received");

            //replace all ? marks starting from the end of the string
            for($i=count($positions)-1; $i>=0; $i--) {
                //if ? surrounded by single quotes, it should be a string. But if val is NULL, remove single quotes so it's actually NULL (not a string)
                if($params[$i] == 'NULL' && substr($stmt, $positions[$i] - 1, 3) == "'?'")
                    $stmt = substr($stmt, 0, $positions[$i]-1) . 'NULL' . substr($stmt, $positions[$i] + 2);
                //if ? is not in quotes, it's an integer. Convert empty string to NULL
                else if($params[$i] == '' && substr($stmt, $positions[$i] - 1, 3) != "'?'")
                    $stmt = substr($stmt, 0, $positions[$i]) . 'NULL' . substr($stmt, $positions[$i] + 1);
                //for all other cases, simply use the parameter
                else
                    $stmt = substr($stmt, 0, $positions[$i]) . $params[$i] . substr($stmt, $positions[$i] + 1);
            }
        }

        $this->last_full_statement = $stmt;
        $result = $this->connection->query($stmt);
        $this->throwExceptionOnError();

        return $result;
    }
    /**@param $result mysqli_result
     * @param $class
     * @return array     */
    public function fetchAllObjects($result, $class) {
        $objs = [];
        while($row = $result->fetch_object()) {
            $obj = new $class;
            $obj->fill($row);
            $objs[] = $obj;
        }

        $result->free_result();
        return $objs;
    }
    /**@param $result mysqli_result
     * @param $class
     * @return mixed|null Returns null if no rows in result set. */
    public function fetchObject($result, $class) {
        if($row = $result->fetch_object()) {
            $obj = new $class;
            $obj->fill($row);
            $result->free_result();
            return $obj;
        }

        $result->free_result();
        return null;
    }

    /** Utility function to throw an exception if an error occurs while running a mysql command.
     * @throws Exception*/
    protected function throwExceptionOnError ()
    {
        if (mysqli_error($this->connection)) {
            $msg = '<b>MySQL Error ' . mysqli_errno($this->connection) . ":</b> " . mysqli_error($this->connection) . '<br>';
            if(isset($this->last_full_statement)) {
                $msg .= '<b>Full statement:</b> ' . $this->last_full_statement . '<br>'
                    . '<b>Raw statement:</b> ' . $this->last_raw_statement . '<br>'
                    . '<b>Parameters:</b> [' . ($this->last_params==null ? '' : implode(', ', $this->last_params)) . ']';
            }
            throw new Exception($msg);
        }
    }
}