<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header(); ?>

    <?php
        if($this->assessment->assessment_type == AssessmentTypes::GPRAIntake || $this->assessment->assessment_type == AssessmentTypes::GPRADischarge
            || $this->assessment->assessment_type == AssessmentTypes::GPRAFollowup) {
            include dirname(__FILE__)."/gpra-sections/section".$this->section.".html";
        }
    ?>
    <br>
    <div style="text-align: center; font-size: 14pt">
        <h4>When you are finished, please click Finished below.</h4>
        <input type="button" value="Finished" @click="saveAssessment()" class="btn btn-primary" style="font-size: 18px"><br>
    </div>

    <?php include_footer(); ?>
    <?php include_js(); ?>

    <script src="https://unpkg.com/vue-select@2.6.0/dist/vue-select.js"></script>
    <script type="application/javascript">
        Vue.component('v-select',VueSelect.VueSelect);
        vue = new Vue({
            el: '#main',
            data: {
                gpra: <?php echo json_encode($this->assessment); ?>,
                section: <?php echo json_encode($this->section); ?>,
                errors: <?php echo json_encode($this->errors_container); ?>,
                optionSets: <?php echo json_encode($this->optionSets); ?>
            },
            methods: {
                saveAssessment: function(){
                    this.clearErrors();
                    ajax('gpra/save', [this.gpra, this.section], function (result) {
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