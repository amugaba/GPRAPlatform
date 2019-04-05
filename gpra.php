<?php
require_once "php/config.php";
require_once "php/DataService.php";

//check_login();
if(!isset($_GET['id']))
    die("Assessment ID missing.");//this should route to a proper error page
if(!isset($_GET['section']))
    die("Section ID missing.");//this should route to a proper error page
$ds = DataService::getInstance();
$assessment = $ds->getAssessment($_GET['id']);
if($assessment == null)
    die("Assessment ID invalid.");

$current_section = intval($_GET['section']);
//there should be a check of progress whether this page can be accessed

$optionSets = $ds->getOptionSets();
$answers = $ds->getAnswersByAssessment($assessment->id); //get all answers because sometimes old answers are needed for skip patterns
$questions = $ds->getQuestionsBySection($assessment->assessment_type, $current_section);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPRA Platform</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header(); ?>

    <?php include_assessment_template($assessment->assessment_type, $current_section); ?>
    <br>
    <div style="text-align: center; font-size: 14pt">
        <h4>When you are finished, please click Finished below.</h4>
        <input type="button" value="Finished" @click="saveAssessment()" class="btn btn-primary" style="font-size: 18px"><br>
    </div>

    <?php include_footer(); ?>

    <script src="https://unpkg.com/vue-select@2.6.0/dist/vue-select.js"></script>
    <script type="application/javascript">
        Vue.component('v-select',VueSelect.VueSelect);
        vue = new Vue({
            el: '#main',
            data: {
                gpra: <?php echo json_encode($assessment); ?>,
                section: <?php echo json_encode($current_section); ?>,
                errors: <?php echo json_encode($errors_container); ?>,
                optionSets: <?php echo json_encode($optionSets); ?>
            },
            methods: {
                saveAssessment: function(){
                    this.clearErrors();
                    ajax('saveAssessment', [this.gpra, this.section], function (result) {
                        let errors = result.data;
                        if(errors != null) {
                            vue.displayErrors(errors);
                        }
                        console.log(result);
                    });
                },
                clearErrors: function() {
                    for (let prop in this.errors) {
                        if (this.errors.hasOwnProperty(prop)) {
                            this.errors[prop] = null;
                        }
                    }
                },
                displayErrors: function(newErrors) {
                    newErrors.forEach(function(error) {
                        vue.errors[error.item_id] = error.message;
                    });
                    if(newErrors.length > 0)
                        location.href = '#'+newErrors[0].item_id;
                }
            }
        });
    </script>
</body>
</html>