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
        $section = input('section') ?? 0;
        $this->validateExistingGPRAParameters($id, $section, false);

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
        $view->addSidebarSection('gpra/sidebar.php');
        $view->section = $section;
        $view->assessment = $assessment;
        $view->optionSets = $optionSets;
        $view->errors_container = $errors_container;
        $view->sections = GPRA::getSections($assessment->assessment_type, $assessment->interview_conducted);
        $view->client = $ds->getClient($assessment->client_id);
        return $view->render();
    }

    /**
     * @throws Exception
     */
    public function getAdd()
    {
        $episode_id = input('episode');
        $gpra_type = input('type');
        $assessment_type = GPRA::getAssessmentType($gpra_type);
        $section = 0;
        $this->validateNewGPRAParameters($episode_id, $gpra_type);

        $ds = DataService::getInstance();
        $episode = $ds->getEpisode($episode_id);
        $client = $ds->getClient($episode->client_id);

        $assessment = new GPRA(); //use blank GPRA
        $optionSets = $ds->getOptionSets();
        $questions = $ds->getQuestionsBySection($assessment_type, $section);
        $errors_container = new stdClass();

        //all variables must be declared for Vue to set up 2-way binding
        foreach ($questions as $question) {
            $code = $question->code;
            $assessment->$code = null;
            $errors_container->$code = null;
        }

        //prepopulate
        $assessment->assessment_type = $assessment_type;
        $assessment->gpra_type = $gpra_type;
        $assessment->episode_id = $episode_id;
        $assessment->ConductedInterview = 1;
        $assessment->ClientType = 1;
        $assessment->InterviewDate = date('m-d-Y');

        $view = new View('gpra/add-gpra.php');
        $view->addSidebarSection('gpra/add-sidebar.php');
        $view->section = $section;
        $view->assessment = $assessment;
        $view->optionSets = $optionSets;
        $view->errors_container = $errors_container;
        $view->client = $client;
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
        $client = $ds->getClient($assessment->client_id);

        $view = new View('gpra/complete.php');
        $view->addSidebarSection('gpra/sidebar.php');
        $view->client = $client;
        $view->assessment = $assessment;
        $view->section = 99;
        return $view->render();
    }

    /**
     * Assessment ID must correspond to a valid GPRA assessment.
     * Section must correspond to a section that is valid for the type of GPRA and assessment progress.
     * @param $assessment_id int
     * @param $section int
     * @param $saving bool
     * @throws Exception
     */
    private function validateExistingGPRAParameters(int $assessment_id, int $section, bool $saving)
    {
        $ds = DataService::getInstance();
        $assessment = $ds->getAssessment($assessment_id);

        if ($assessment == null)
            throw new Exception("No assessment matches the input ID: ".$assessment_id);

        if (!in_array($assessment->assessment_type,GPRA::TYPES))
            throw new Exception("Non-GPRA assessment ID given: ".$assessment_id);

        if(!in_array($section,GPRA::getSections($assessment->assessment_type, $assessment->interview_conducted)) || ($saving && $section == 0))
            throw new Exception("Input section not in valid sections for assessment type: ".$section);

        if($assessment->grant_id != Session::getGrant()->id)
            throw new Exception("Assessment ($assessment_id) does not belong to this grant");
    }

    /**
     * Before creating a new assessment, check that the episode is valid and that an assessment of this type doesn't already exist.
     * @param $episode_id int
     * @param $gpra_type int
     * @throws Exception
     */
    private function validateNewGPRAParameters($episode_id, $gpra_type) {
        $ds = DataService::getInstance();
        $episode = $ds->getEpisode($episode_id);
        if($episode == null || $episode->closed == 1)
            throw new Exception("Episode ($episode_id) is invalid or closed.");

        $client = $ds->getClient($episode->client_id);
        if($client == null || $client->grant_id != Session::getGrant()->id)
            throw new Exception("Client from episode ($episode_id) is invalid or from another grant.");

        $assessments = $ds->getAssessmentsByEpisode($episode_id);
        foreach ($assessments as $assessment) {
            if($assessment->gpra_type == $gpra_type)
                throw new Exception("An assessment of this type ($gpra_type) already exist for this episode ($episode_id).");
        }
    }

    /**
     * @throws Exception
     */
    public function postAdd() {
        $data = ajax_input();
        $assessment = $data[0];
        $section = 0;
        $this->validateNewGPRAParameters($assessment->episode_id, $assessment->gpra_type);

        //check that section 0 doesn't have any errors before creating assessment
        $ds = DataService::getInstance();
        $questions = $ds->getQuestionsBySection($assessment->assessment_type, $section);
        $option_sets = $ds->getOptionSets();

        $validator = new GPRAValidator();
        $errors = $validator->validate($assessment, $questions, $option_sets, $section);
        $assessment = $validator->getProcessedGPRA();

        if (count($errors) > 0) {
            ajax_output(false, $errors);
        }
        else {
            $episode = $ds->getEpisode($assessment->episode_id);
            $assessment->id = $ds->addAssessment($assessment->assessment_type, $episode->id, $episode->client_id, Session::getUser()->id,
                Session::getGrant()->id, $assessment->gpra_type, $assessment->ConductedInterview, $assessment->InterviewDate);
            $real_assessment = $ds->getAssessment($assessment->id);
            $assessment->InterviewDate = date('m/d/Y', strtotime($real_assessment->interview_date)); //since the date has been randomized, save it in GPRA
            $ds->saveQuestionAnswers($questions, $assessment, $assessment->id);
            ajax_output(true, $assessment->id);
        }
    }

    /**
     * @throws Exception
     */
    public function postSave() {
        $data = ajax_input();
        $assessment = $data[0];
        $section = $data[1];
        $this->validateExistingGPRAParameters($assessment->id, $section, true);

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
            $completed = $section == end(GPRA::getSections($assessment->assessment_type, $assessment->interview_conducted));
            $ds->updateAssessmentProgress($assessment->id, $section, $completed);
            ajax_output(true);
        }
    }
}