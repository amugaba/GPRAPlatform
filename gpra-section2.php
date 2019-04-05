<?php
require_once "php/config.php";
require_once "php/DataService.php";

//check_login();
$ds = DataService::getInstance();
$assessment = $ds->getAssessment(1);
$current_section = GPRASections::RECORDS;

//$gpra = new GPRA();
$optionSets = $ds->getOptionSets();
$answers = $ds->getAnswersBySection($assessment->id,$current_section);
$questions = $ds->getQuestionsBySection(AssessmentTypes::GPRAIntake, $current_section);
$errors_container = new stdClass();
foreach ($questions as $question) {
    $code = $question->code;
    $assessment->$code = null;
    $errors_container->$code = null;
}
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

    <div style="margin: 30px auto 20px; text-align: center">
        <h3>Section A: Record Management</h3>
    </div>

    <question-text title="Interview Date" reminder="MM-DD-YYYY" id="InterviewDate" v-model="gpra.InterviewDate"></question-text>

    <h4>BEHAVIORAL HEALTH DIAGNOSES</h4>
    <div class="explanationBox">
        Please indicate the client’s current behavioral health diagnoses using the International Classification of Diseases,
        10th revision, Clinical Modification (ICD-10-CM) codes listed below. Please note that some substance use disorder ICD-10-CM
        codes have been crosswalked to the Diagnostic and Statistical Manual of Mental Disorders, Fifth Edition (DSM-5), descriptors.
        You may specify a primary, secondary, and/or tertiary diagnosis.
    </div>

    <question-combobox title="Primary" id="ICD10CodeOne" v-model="gpra.ICD10CodeOne" :options="optionSets.ICDCode"></question-combobox>
    <question-combobox title="Secondary" id="ICD10CodeTwo" v-model="gpra.ICD10CodeTwo" :options="optionSets.ICDCode"></question-combobox>
    <question-combobox title="Tertiary" id="ICD10CodeThree" v-model="gpra.ICD10CodeThree" :options="optionSets.ICDCode"></question-combobox>

    <question-radio title="In the past 30 days, was this client diagnosed with an opioid use disorder?"
                     id="OpioidDisorder" v-model="gpra.OpioidDisorder" :options="optionSets.YesNoD"></question-radio>

    <div v-show="gpra.OpioidDisorder == 1">
        <div class="question">
            <div class="header">
                <span class="title">In the past 30 days, for how many days did the client receive the following medications for treatment of opioid use disorder?</span><br>
                <span class="reminderText">(Leave blank if medication not received)</span>
            </div>
            <div style="padding-left: 40px" class="small-label small-input">
                <question-text title="Methadone" id="MethadoneMedicationDays" v-model="gpra.MethadoneMedicationDays"></question-text>
                <question-text title="Buprenorphine" id="BuprenorphineMedicationDays" v-model="gpra.BuprenorphineMedicationDays"></question-text>
                <question-text title="Naltrexone" id="NaltrexoneMedicationDays" v-model="gpra.NaltrexoneMedicationDays"></question-text>
                <question-text title="Extended-release naltrexone" id="NaltrexoneXRMedicationDays" v-model="gpra.NaltrexoneXRMedicationDays"></question-text>
            </div>
        </div>
    </div>

    <question-radio title="In the past 30 days, was this client diagnosed with an alcohol use disorder?"
                    id="AlcoholDisorder" v-model="gpra.AlcoholDisorder" :options="optionSets.YesNoD"></question-radio>

    <div v-show="gpra.AlcoholDisorder == 1">
        <div class="question">
            <div class="header">
                <span class="title">In the past 30 days, for how many days did the client receive the following medications for treatment of alcohol use disorder?</span><br>
                <span class="reminderText">(Leave blank if medication not received)</span>
            </div>
            <div style="padding-left: 40px" class="small-label small-input">
                <question-text title="Naltrexone" id="NaltrexoneAlcMedicationDays" v-model="gpra.NaltrexoneAlcMedicationDays"></question-text>
                <question-text title="Extended-release naltrexone" id="NaltrexoneXRAlcMedicationDays" v-model="gpra.NaltrexoneXRAlcMedicationDays"></question-text>
                <question-text title="Disulfiram" id="DisulfiramMedicationDays" v-model="gpra.DisulfiramMedicationDays"></question-text>
                <question-text title="Acamprosate" id="AcamprosateMedicationDays" v-model="gpra.AcamprosateMedicationDays"></question-text>
            </div>
        </div>
    </div>

    <br>
    <div style="text-align: center; font-size: 14pt">
        <h4>When you are finished, please click Finished below.</h4>
        <input type="button" value="Finished" @click="saveGPRA()" class="btn btn-primary" style="font-size: 18px"><br>
    </div>

    <?php include_footer(); ?>

<script src="js/option-sets.js"></script>
    <script src="https://unpkg.com/vue-select@2.6.0/dist/vue-select.js"></script>
    <script src="js/validate-gpra.js"></script>
<script type="application/javascript">
    Vue.component('v-select',VueSelect.VueSelect);
    vue = new Vue({
        el: '#main',
        data: {
            gpra: <?php echo json_encode($assessment); ?>,
            userID: 1,
            client: {},
            errors: <?php echo json_encode($errors_container); ?>,
            optionSets: <?php echo json_encode($optionSets); ?>
        },
        methods: {
            saveGPRA: function(){
                this.clearErrors();
                ajax('saveGPRAPage1', [this.gpra], function (result) {
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