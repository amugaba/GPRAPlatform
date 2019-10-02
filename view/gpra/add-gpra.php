<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Section A: Record Management</div>

    <div class="details">
        <label>Client ID:</label>{{client.uid}}<br>
        <label>Interview Type:</label>{{gpra.gpra_type | gpraType}}<br>
    </div>

    <section v-if="gpra.assessment_type == 1">
        <question-radio title="Client Type" id="ClientType" v-model="gpra.ClientType" :options="optionSets.ClientType"></question-radio>
    </section>

    <section v-if="gpra.assessment_type != 1">
        <question-radio title="Did you conduct an interview?" id="ConductedInterview" v-model="gpra.ConductedInterview" :options="optionSets.YesNo"></question-radio>
    </section>
    <section v-if="gpra.assessment_type == 1 || gpra.ConductedInterview != 0">
        <question-text title="Interview Date" reminder="MM-DD-YYYY" id="InterviewDate" v-model="gpra.InterviewDate"></question-text>
        <p class="reminderText">(This date will be randomized +/- 3 days to de-identify the data.)</p>
    </section>

    <div style="text-align: center; margin-top: 30px">
        <input type="button" value="Create GPRA" @click="createGPRA()" class="btn btn-primary" style="font-size: 18px"><br>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

    <script type="application/javascript">
        vue = new Vue({
            el: '#main',
            data: {
                gpra: <?php echo json_encode($this->assessment); ?>,
                errors: <?php echo json_encode($this->errors_container); ?>,
                optionSets: <?php echo json_encode($this->optionSets); ?>,
                client: <?php echo json_encode($this->client); ?>
            },
            methods: {
                createGPRA: function(){
                    this.clearErrors();
                    ajax('/gpra/add', [this.gpra], function (result) {
                        if(result.success) {
                            location.href = '/gpra?id='+result.data;
                        }
                        else {
                            vue.displayErrors(result.data);
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