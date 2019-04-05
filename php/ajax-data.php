<?php
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/DataService.php';
require_once dirname(__FILE__).'/Result.php';

try {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    //check_login();

    $ds = DataService::getInstance();

    //TBD - Need to verify that assessment ID
    if($request->function === 'saveAssessment') {
        $assessment = $request->params[0];

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
catch (Exception $ex) {
    //can't use globalExceptionHandler because we can't echo or redirect to error page within ajax call
    //instead return failure result so that Javascript can print error message or redirect
    $msg = '<b>' . get_class($ex) . ' (' .  $ex->getCode() .')</b> thrown in <b>' . $ex->getFile() . '</b> on line <b>'
        . $ex->getLine(). '</b><br>' . $ex->getMessage()
        . str_replace('#','<br>#', $ex->getTraceAsString()).'<br>';

    echo json_encode(new Result(false, $msg));
}

