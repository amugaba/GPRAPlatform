<?php
/**
 * Provide service function to access data from database
 */

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
        $this->connection->set_charset('utf8');
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
     * @return Grant
     * @throws Exception
     */
    public function getGrant($id)
    {
        $result = $this->query("SELECT * FROM grants WHERE id=?", [$id]);
        return $this->fetchObject($result, Grant::class);
    }

    /** @param $user_id $id
     * @return Grant[]
     * @throws Exception
     */
    public function getGrantsByUser($user_id)
    {
        $result = $this->query("SELECT g.* FROM grants g JOIN user_grants ug ON g.id=ug.grant_id WHERE ug.user_id=?", [$user_id]);
        return $this->fetchAllObjects($result, Grant::class);
    }

    /** @param Grant $item
     * @return int
     * @throws Exception
     */
    public function addGrant($item)
    {
        $this->query("INSERT INTO grants (name, grantee, grantno, target) VALUES ('?', '?', '?', ?)",
            [$item->name, $item->grantee, $item->grantno, $item->target]);
        return $this->connection->insert_id;
    }

    /** @param Grant $item
     * @throws Exception
     */
    public function updateGrant($item)
    {
        $this->query("UPDATE grants SET name='?', grantee='?', grantno='?', target=? WHERE id=?",
            [$item->name, $item->grantee, $item->grantno, $item->target, $item->id]);
    }

    /** @param int $id
     * @throws Exception
     */
    public function deleteGrant($id)
    {
        $this->query("DELETE FROM grants WHERE id=?", [$id]);
    }

    /**
     * @param $id int
     * @return Client
     * @throws Exception
     */
    public function getClient($id) {
        $result = $this->query("SELECT * FROM clients WHERE id=?", [$id]);
        return $this->fetchObject($result, Client::class);
    }

    /**
     * @param $uid string
     * @param $grant_id int
     * @return bool
     * @throws Exception
     */
    public function addClient($uid, $grant_id) {
        $success = $this->query("INSERT IGNORE INTO clients SET uid='?', grant_id=?", [$uid, $grant_id]);
        if($success) {
            $id = $this->connection->insert_id;
            $this->query("UPDATE clients SET gpra_id=? WHERE id=?", [$id, $id]);//GPRA ID mirrors DB ID for now
            return $id;
        }
        return null;
    }

    /**
     * @param $uid string
     * @param $grant_id int
     * @param $recent_only bool
     * @return Client[]
     * @throws Exception
     */
    public function searchClients($uid, $grant_id, $recent_only) {
        $recent_clause = $recent_only ? 'AND (e.client_id, e.number) IN (SELECT client_id, MAX(number) FROM episodes GROUP BY client_id)' : '';

        $result = $this->query("SELECT c.id, c.uid, e.id AS episode_id, e.number AS episode_number, e.start_date as episode_date,
            a1.id AS intake_id, a1.status AS intake_status, 
            a2.id AS discharge_id, a2.status AS discharge_status, 
            a3.id AS followup_3mo_id, a3.status AS followup_3mo_status,
            a4.id AS followup_6mo_id, a4.status AS followup_6mo_status
            FROM clients c 
            JOIN episodes e ON c.id=e.client_id
            LEFT JOIN assessments a1 ON a1.client_id = c.id AND a1.gpra_type=1 AND a1.episode_id=e.id
            LEFT JOIN assessments a2 ON a2.client_id = c.id AND a2.gpra_type=2 AND a2.episode_id=e.id
            LEFT JOIN assessments a3 ON a3.client_id = c.id AND a3.gpra_type=3 AND a3.episode_id=e.id
            LEFT JOIN assessments a4 ON a4.client_id = c.id AND a4.gpra_type=4 AND a4.episode_id=e.id
            WHERE c.uid LIKE '%?%' AND c.grant_id=? $recent_clause",
            [$uid, $grant_id]);

        return $this->fetchAllObjects($result, Client::class);
    }

    /**
     * @param $client_id int
     * @return Client[]
     * @throws Exception
     */
    public function getClientEpisodesWithGPRAs($client_id) {
        $result = $this->query("SELECT c.id, c.uid, e.id AS episode_id, e.number AS episode_number, e.start_date as episode_date,
            a1.id AS intake_id, a1.status AS intake_status, 
            a2.id AS discharge_id, a2.status AS discharge_status, 
            a3.id AS followup_3mo_id, a3.status AS followup_3mo_status,
            a4.id AS followup_6mo_id, a4.status AS followup_6mo_status
            FROM clients c 
            JOIN episodes e ON c.id=e.client_id
            LEFT JOIN assessments a1 ON a1.client_id = c.id AND a1.gpra_type=1 AND a1.episode_id=e.id
            LEFT JOIN assessments a2 ON a2.client_id = c.id AND a2.gpra_type=2 AND a2.episode_id=e.id
            LEFT JOIN assessments a3 ON a3.client_id = c.id AND a3.gpra_type=3 AND a3.episode_id=e.id
            LEFT JOIN assessments a4 ON a4.client_id = c.id AND a4.gpra_type=4 AND a4.episode_id=e.id
            WHERE c.id=?", [$client_id]);

        return $this->fetchAllObjects($result, Client::class);
    }

    /** @param Client $item
     * @throws Exception
     */
    public
    function updateClient($item)
    {
        $this->query("UPDATE clients SET uid=? WHERE id=?",
            [$item->uid, $item->id]);
    }

    /** @param int $id
     * @return Episode
     * @throws Exception
     */
    public function getEpisode($id)
    {
        $result = $this->query("SELECT * FROM episodes WHERE id=?", [$id]);
        return $this->fetchObject($result, Episode::class);
    }

    /** @param int $client_id
     * @return Episode[]
     * @throws Exception
     */
    public
    function getEpisodesByClient($client_id)
    {
        $result = $this->query("SELECT * FROM episodes WHERE client_id=?", [$client_id]);
        return $this->fetchAllObjects($result, Episode::class);
    }

    /** @param int $client_id
     * @return int
     * @throws Exception
     */
    public
    function addEpisode($client_id)
    {
        //get the current episode number
        $result = $this->query("SELECT MAX(number) FROM episodes WHERE client_id=?", [$client_id]);
        $current_number = $result->fetch_row()[0];

        $this->query("INSERT INTO episodes (client_id, number, start_date) VALUES (?, ?, '?')", [$client_id, $current_number+1, date('Y-m-d')]);
        return $this->connection->insert_id;
    }

    /** @param int $id
     * @throws Exception
     */
    public
    function deleteEpisode($id)
    {
        $this->query("DELETE FROM episodes WHERE id=?", [$id]);
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

    /** @param int $episode_id
     * @return Assessment[]
     * @throws Exception
     */
    public function getAssessmentsByEpisode($episode_id)
    {
        $result = $this->query("SELECT * FROM assessments WHERE episode_id=?", [$episode_id]);
        return $this->fetchAllObjects($result, Assessment::class);
    }

    /**
     * @param int $client_id
     * @return Assessment[]
     * @throws Exception
     */
    public function getAssessmentsByClient($client_id)
    {
        $result = $this->query("SELECT * FROM assessments WHERE client_id=?", [$client_id]);
        return $this->fetchAllObjects($result, Assessment::class);
    }

    /**
     * @param $assessment_type int
     * @param $episode_id int
     * @param $client_id int
     * @param $user_id int
     * @param $grant_id int
     * @param $gpra_type int
     * @param $interview_conducted bool
     * @return int
     * @throws Exception
     */
    public function addAssessment($assessment_type, $episode_id, $client_id, $user_id, $grant_id, $gpra_type = null, $interview_conducted = null) {
        $this->query("INSERT INTO assessments (assessment_type, client_id, user_id, grant_id, episode_id, created_date, gpra_type, interview_conducted) 
            VALUES (?,?,?,?,?,'?',?,?)", [$assessment_type, $client_id, $user_id, $grant_id, $episode_id, date('Y-m-d'), $gpra_type, $interview_conducted]);
        return $this->connection->insert_id;
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
     * Progress is equal to the furthest/greatest section completed.
     * @param $assessment_id int
     * @param $progress int
     * @param $completed bool
     * @throws Exception
     */
    public function updateAssessmentProgress($assessment_id, $progress, $completed = false) {
        $status = $completed ? 1 : 0;
        $this->query("UPDATE assessments SET progress=GREATEST(progress, ?), status=GREATEST(status, ?) WHERE id=?",
            [$progress, $status, $assessment_id]);
    }

    /**
     * @param $username string
     * @param $password string
     * @return User|null
     * @throws Exception
     */
    public function loginUser ($username, $password)
    {
        $result = $this->query("SELECT * FROM users WHERE username='?' OR email='?'",[$username, $username]);

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
        if($code == null)
            return false;

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
        $result = $this->query("UPDATE users SET password='?', reset_code=NULL WHERE id=?",[$hash,$user_id]);

        return $result != null;
    }

    /**
     * @param $email string
     * @return User|null
     * @throws Exception
     */
    public function getUserByEmail ($email)
    {
        $result = $this->query("SELECT * FROM users WHERE email='?'",[$email]);
        return $this->fetchObject($result, User::class);
    }

    /**
     * @return User[]
     * @throws Exception
     */
    public function getUsers()
    {
        $result = $this->query("SELECT * FROM users");
        return $this->fetchAllObjects($result, User::class);
    }

    /**
     * Run mysql query after escaping input
     * @param $stmt string
     * @param $params array
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function query($stmt, $params = null) {
        $this->last_raw_statement = $stmt;
        $this->last_params = $params;
        $this->last_full_statement = 'Unassigned';

        if($params != null) {
            for($i=0; $i<count($params); $i++) {
                $val = $params[$i];
                if($val === null)
                    $val = 'NULL';
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
                if($params[$i] === 'NULL')
                    $stmt = substr($stmt, 0, $positions[$i]) . 'NULL' . substr($stmt, $positions[$i] + 1);
                else
                    $stmt = substr($stmt, 0, $positions[$i]) ."'". $params[$i] ."'". substr($stmt, $positions[$i] + 1);
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
    protected function fetchAllObjects($result, $class) {
        $objs = [];
        $type_map = $this->getTypeMap($result);
        while($row = $result->fetch_object()) {
            $obj = new $class;
            foreach($row as $key => $value) {
                $obj->$key = $this->convertDataType($value, $type_map[$key]);
            }
            $objs[] = $obj;
        }
        $result->free_result();
        return $objs;
    }

    /**@param $result mysqli_result
     * @param $class
     * @return mixed|null Returns null if no rows in result set. */
    protected function fetchObject($result, $class) {
        $type_map = $this->getTypeMap($result);
        if($row = $result->fetch_object()) {
            $obj = new $class;
            foreach($row as $key => $value) {
                $obj->$key = $this->convertDataType($value, $type_map[$key]);
            }
            $result->free_result();
            return $obj;
        }
        $result->free_result();
        return null;
    }

    /**
     * @param $result mysqli_result
     * @return array
     */
    protected function getTypeMap($result) {
        $map = [];
        $fields = $result->fetch_fields();
        foreach($fields as $field) {
            $map[$field->name] = $field->type;
        }
        return $map;
    }

    /**
     * @param $val string
     * @param $type int
     * @return float|int|string
     */
    protected function convertDataType($val, $type) {
        if($val == null)
            return $val;
        if(in_array($type, [1,2,3,8,9,16])) //tinyint, smallint, int, bigint, mediumint
            return intval($val);
        if(in_array($type, [4,5,246])) //float, double, decimal
            return floatval($val);
        return $val;
    }

    /**
     * @param string $query Should be like INSERT INTO table (col1, col2, col3) VALUES (?, ?, ?)
     * @param array $rows Should be an array of arrays of values
     * @return bool|mysqli_result
     * @throws Exception
     */
    protected function multiInsert($query, $rows) {
        $pos1 = strrpos($query, '(');
        $pos2 = strrpos($query, ')');
        $base_query = substr($query, 0, $pos1);
        $value_block = substr($query, $pos1, $pos2-$pos1+1);
        $params = [];
        foreach ($rows as $index => $row) {
            $base_query .= $value_block.',';
            $params = array_merge($params, $row);
        }
        $base_query = substr($base_query,0,strlen($base_query)-1);//remove trailing comma
        return $this->query($base_query, $params);
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