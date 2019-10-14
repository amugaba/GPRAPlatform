<!DOCTYPE html>
<html lang="en">
<head>
    <title>Client - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Client Profile</div>
    <div class="details">
        <label>Unique ID:</label> {{client.uid}}<br>
    </div>

    <div class="pageTitle">Episodes</div>
    <b-table :fields="tableFields" :items="episodes" sort-by="episode_number" per-page="10" :current-page="currentPage" hover bordered>
        <template v-slot:cell(intake_date)="data">
            {{data.item.intake_date | date}}
        </template>
        <template v-slot:cell(intake)="data">
            <a v-if="data.item.intake_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=1'">Add</a>
            <a v-else :href="'/gpra/index?id='+data.item.intake_id">{{data.item.intake_status | assessmentStatus}}</a>
        </template>
        <template v-slot:cell(followup3mo)="data">
            <div v-if="data.item.intake_id == null">-</div>
            <div v-else-if="data.item.followup_3mo_id == null" :class="dueClasses[data.item.due3MO]">
                <a :href="'/gpra/add?episode='+data.item.episode_id+'&type=3'">{{data.item.due3MO | dueStatus}}</a>
            </div>
            <a v-else :href="'/gpra/index?id='+data.item.followup_3mo_id">{{data.item.followup_3mo_status | assessmentStatus}}</a>
        </template>
        <template v-slot:cell(followup6mo)="data">
            <div v-if="data.item.intake_id == null">-</div>
            <div v-else-if="data.item.followup_6mo_id == null" :class="dueClasses[data.item.due6MO]">
                <a :href="'/gpra/add?episode='+data.item.episode_id+'&type=4'">{{data.item.due6MO | dueStatus}}</a>
            </div>
            <a v-else :href="'/gpra/index?id='+data.item.followup_6mo_id">{{data.item.followup_6mo_status | assessmentStatus}}</a>
        </template>
        <template v-slot:cell(discharge)="data">
            <div v-if="data.item.intake_id == null">-</div>
            <div v-else>
                <a v-if="data.item.discharge_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=2'">Add</a>
                <a v-else :href="'/gpra/index?id='+data.item.discharge_id">{{data.item.discharge_status | assessmentStatus}}</a>
            </div>
        </template>
    </b-table>
    <b-pagination v-show="episodes.length>10" :total-rows="episodes.length" per-page="10" v-model="currentPage"></b-pagination>

    <input type="button" value="Add New Episode" class="btn btn-primary" @click="addEpisode">

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            client: <?php echo json_encode($this->client); ?>,
            result: <?php echo json_encode($this->result); ?>,
            episodes: <?php echo json_encode($this->episodes); ?>,
            dueClasses: ['not-due', 'due', 'past-due'],
            tableFields: [
                {key: 'episode_number', label: 'Episode', sortable: true},
                {key: 'intake_date', label: 'Intake Date', sortable: true},
                {key: 'intake', label: 'Intake'},
                {key: 'followup3mo', label: '3 Month'},
                {key: 'followup6mo', label: '6 Month'},
                {key: 'discharge', label: 'Discharge'},
            ],
            currentPage: 1
        },
        mounted() {
            // Set the initial number of items
            for(let i = 0; i < this.episodes.length; i++) {
                let episode = this.episodes[i];
                episode.due3MO = getDueStatus(episode.intake_date, 2, 5);
                episode.due6MO = getDueStatus(episode.intake_date, 5, 8);
            }
        },
        methods: {
            addEpisode: function () {
                ajax('/home/addEpisode',[this.client.id], function (result) {
                    if(result.success) {
                        location.reload();
                    }
                    else
                        showOverlayMessage(result.data, false);
                });
            }
        }
    });
    function getDueStatus(intake_date, start_months, end_months) {
        if(intake_date == null)
            return null;
        let start = moment(intake_date).add(start_months, 'months');
        let end = moment(intake_date).add(end_months, 'months');
        let now = moment();
        if(now.isBefore(start))
            return 0;
        if(now.isAfter(end))
            return 2;
        return 1;
    }
</script>
</body>
</html>