<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <?php include __DIR__ . "/sections/section" .$this->section.".html"; ?>

    <div style="text-align: center; margin-top: 30px">
        <input type="button" :value="section==0 ? 'Continue' : 'Save & Continue'" @click="saveAssessment()" class="btn btn-primary" style="font-size: 18px"><br>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

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
                sections: <?php echo json_encode($this->sections); ?>,
                client: <?php echo json_encode($this->client); ?>
            },
            methods: {
                saveAssessment: function(){
                    this.clearErrors();
                    if(this.section == 0) { //section 0 cannot be changed
                        this.goToNextSection();
                    }
                    else {
                        ajax('/gpra/save', [this.gpra, this.section], function (result) {
                            if(result.success) {
                                vue.goToNextSection();
                            }
                            else {
                                vue.displayErrors(result.data);
                            }
                        });
                    }
                },
                goToNextSection: function() {
                    let nextSectionIndex = vue.sections.indexOf(parseInt(vue.section)) + 1;
                    if (nextSectionIndex === vue.sections.length)
                        location.href = '/gpra/complete?id=' + vue.gpra.id;
                    else
                        location.href = '/gpra?id=' + vue.gpra.id + "&section=" + vue.sections[nextSectionIndex];
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