<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header(); ?>

    <?php include __DIR__ . "/sections/section" .$this->section.".html"; ?>

    <div style="text-align: center; font-size: 14pt; margin-top: 30px">
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
                optionSets: <?php echo json_encode($this->optionSets); ?>,
                sections: <?php echo json_encode($this->sections); ?>
            },
            methods: {
                saveAssessment: function(){
                    this.clearErrors();
                    ajax('/gpra/save', [this.gpra, this.section], function (result) {
                        let errors = result.data;
                        if(errors != null) {
                            vue.displayErrors(errors);
                        }
                        else {
                            let nextSectionIndex = vue.sections.indexOf(parseInt(vue.section)) + 1;
                            if(nextSectionIndex === vue.sections.length)
                                location.href = '/gpra/complete?id='+vue.gpra.id;
                            else
                                location.href = '/gpra?id='+vue.gpra.id+"&section="+vue.sections[nextSectionIndex];
                        }
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