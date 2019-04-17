<!DOCTYPE html>
<html lang="en">
<head>
    <title>Client - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <h3>Client: {{client.uid}}</h3>

    <h3>Episodes</h3>
    <p class="reminderText">Open an existing episode or add a new episode.</p>
    <div class="row">
        <div class="col-md-6">
            <div style="width: 300px; margin: 10px">
                <table class="table table-striped">
                    <tr>
                        <th>Open</th>
                        <th>Episode #</th>
                        <th>Start Date</th>
                    </tr>
                    <tr v-for="episode in episodes" :class="{selected: currentEpisode==episode}">
                        <td><img src="/img/edit.png" @click="openEpisode(episode)"style="cursor: pointer"></td>
                        <td>{{episode.number}}</td>
                        <td>{{episode.start_date | date}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <input type="button" value="Add New Episode" class="btn btn-primary" @click="addEpisode">
        </div>
    </div>

    <div v-show="currentEpisode != null">
        <h3>Assessments</h3>
        <p class="reminderText">Open an existing assessment or add a new one.</p>
        <div class="row">
            <div class="col-md-6">
                <div style="width: 300px; margin: 10px">
                    <table class="table table-striped">
                        <tr>
                            <th>Open</th>
                            <th>Type</th>
                            <th>Creation Date</th>
                        </tr>
                        <tr v-for="assessment in assessments">
                            <td><a :href="'/gpra?id='+assessment.id"><img src="/img/edit.png"></a></td>
                            <td>{{assessment.assessment_type | assessmentType}}</td>
                            <td>{{assessment.created_date | date}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <input type="button" value="Add GPRA Intake" class="btn btn-primary input-block-fit">
                <input type="button" value="Add GPRA Discharge" class="btn btn-primary input-block-fit">
                <input type="button" value="Add GPRA Followup" class="btn btn-primary input-block-fit">
            </div>
        </div>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            client: <?php echo json_encode($this->client); ?>,
            result: <?php echo json_encode($this->result); ?>,
            episodes: <?php echo json_encode($this->episodes); ?>,
            assessmentGroups: <?php echo json_encode($this->assessment_groups); ?>,
            currentEpisode: null,
            assessments: []
        },
        methods: {
            addEpisode: function () {
                ajax('/home/addEpisode',null, function (result) {
                    if(result.success) {
                        vue.episodes.push(result.data);
                        vue.currentEpisode = result.data;
                    }
                    else
                        showOverlayMessage(result.data, false);
                });
            },
            openEpisode: function(episode) {
                this.currentEpisode = episode;
                this.assessments = this.assessmentGroups[episode.id];
            }

        }
    })
</script>
</body>
</html>