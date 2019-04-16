<?php
require_once 'Controller.php';

class GPRAController extends Controller
{
    /**
     * @throws Exception
     */
    public function getIndex()
    {
        $id = input('id');
        $section = input('section') ?? 1;
        $this->validateParameters($id, $section);

        $ds = DataService::getInstance();
        $assessment = $ds->getAssessment($id);
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

        $view = new View('gpra/index.php');
        $view->section = $section;
        $view->assessment = $assessment;
        $view->optionSets = $optionSets;
        $view->errors_container = $errors_container;
        $view->sections = GPRA::SECTIONS[$assessment->assessment_type];
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getComplete()
    {
        $id = input('id');
        $ds = DataService::getInstance();
        $assessment = $ds->getAssessment($id);
        $view = new View('gpra/complete.php');
        $view->id = $assessment->client_id;
        return $view->render();
    }

    /**
     * Assessment ID must correspond to a valid GPRA assessment.
     * Section must correspond to a section that is valid for the type of GPRA and assessment progress.
     * @param $assessment_id int
     * @param $section int
     * @throws Exception
     */
    private function validateParameters(int $assessment_id, int $section) {
        $ds = DataService::getInstance();
        $assessment = $ds->getAssessment($assessment_id);

        if ($assessment == null)
            throw new Exception("No assessment matches the input ID: ".$assessment_id);

        if (!in_array($assessment->assessment_type,GPRA::TYPES))
            throw new Exception("Non-GPRA assessment ID given: ".$assessment_id);

        if(!in_array($section,GPRA::SECTIONS[$assessment->assessment_type]))
            throw new Exception("Input section not in valid sections for assessment type: ".$section);
    }

    /**
     * @throws Exception
     */
    public function postSave() {
        $data = ajax_input();
        $assessment = $data[0];
        $section = $data[1];
        $this->validateParameters($assessment->id, $section);

        //verify that assessment exists
        //maybe check other things like it being open and editable by user
        $ds = DataService::getInstance();
        $real_assessment = $ds->getAssessment($assessment->id);

        $type = $real_assessment->assessment_type;
        $questions = $ds->getQuestionsBySection($type, $section);
        $option_sets = $ds->getOptionSets();

        $validator = new GPRAValidator();
        $errors = $validator->validate($assessment, $questions, $option_sets, $section);
        $assessment = $validator->getProcessedGPRA();

        if (count($errors) > 0) {
            ajax_output(false, $errors);
        }
        else {
            $ds->saveQuestionAnswers($questions, $assessment, $assessment->id);
            ajax_output(true);
        }
    }
}