<?php
require_once 'Controller.php';

class GPRAController extends Controller {

    /**
     * @throws Exception
     */
    public function processRequest() {
        if($this->method === 'POST') {
            if($this->action === 'save') {
                $this->saveData();
            }
        }
        else if($this->method === 'GET') {
            if($this->action === 'view') {
                $this->loadSection();
            }
        }
    }

    /**
     * @throws Exception
     */
    private function loadSection()
    {
        $id = intval($this->parameters[0]) ?? die("Assessment ID missing.");
        $section = intval($this->parameters[1]) ?? die("Section ID missing.");
        if(!($section > 0 && $section < 14))
            throw new Exception('Section out of bounds');

        $ds = DataService::getInstance();
        $assessment = $ds->getAssessment($id);
        if ($assessment == null)
            throw new Exception("Assessment ID invalid.");

        $optionSets = $ds->getOptionSets();
        $answers = $ds->getAnswersByAssessment($assessment->id); //get all answers because sometimes old answers are needed for skip patterns
        $questions = $ds->getQuestionsBySection($assessment->assessment_type, $section);
        $errors_container = new stdClass();

        //all variables must be declared for Vue to set up 2-way binding
        foreach ($questions as $question) {
            $code = $question->code;
            $assessment->$code = null;
            $errors_container->$code = null;
        }
        //populate answers
        foreach ($answers as $answer) {
            $code = $answer->code;
            $assessment->$code = $answer->value;
        }

        $view = new View('gpra.php');
        $view->section = $section;
        $view->assessment = $assessment;
        $view->optionSets = $optionSets;
        $view->answers = $answers;
        $view->questions = $questions;
        $view->errors_container = $errors_container;
        $view->render();
    }

    /**
     * @throws Exception
     */
    private function saveData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $assessment = $request->params[0];
        $ds = DataService::getInstance();
        //verify that assessment exists
        //maybe check other things like it being open and editable by user
        $real_assessment = $ds->getAssessment($assessment->id);
        if($real_assessment == null) {
            echo json_encode(new Result(false, 'Assessment with ID ('.$assessment->id.') does not exist.'));
            exit;
        }

        $section = intval($request->params[1]);
        $type = $real_assessment->assessment_type;
        $questions = $ds->getQuestionsBySection($type, $section);
        $option_sets = $ds->getOptionSets();

        if ($type == AssessmentTypes::GPRAIntake || $type == AssessmentTypes::GPRADischarge || $type == AssessmentTypes::GPRAFollowup) {
            require_once dirname(__FILE__) . '/../validators/GPRAValidator.php';
            $validator = new GPRAValidator();
            $errors = $validator->validate($assessment, $questions, $option_sets, $section);
            $assessment = $validator->getProcessedGPRA();
        }

        if (count($errors) > 0)
            echo json_encode(new Result(true, 'Validation errors', $errors));
        else {
            $ds->saveQuestionAnswers($questions, $assessment, $assessment->id);
            echo json_encode(new Result(true, 'Method successful.'));
        }
    }
}