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
        <template slot="episode_date" slot-scope="data">
            {{data.item.episode_date | date}}
        </template>
        <template slot="intake" slot-scope="data">
            <a v-if="data.item.intake_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=1'">Add</a>
            <a v-else :href="'/gpra/index?id='+data.item.intake_id">{{data.item.intake_status | assessmentStatus}}</a>
        </template>
        <template slot="followup3mo" slot-scope="data">
            <a v-if="data.item.followup_3mo_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=3'">Add</a>
            <a v-else :href="'/gpra/index?id='+data.item.followup_3mo_id">{{data.item.followup_3mo_status | assessmentStatus}}</a>
        </template>
        <template slot="followup6mo" slot-scope="data">
            <a v-if="data.item.followup_6mo_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=4'">Add</a>
            <a v-else :href="'/gpra/index?id='+data.item.followup_6mo_id">{{data.item.followup_6mo_status | assessmentStatus}}</a>
        </template>
        <template slot="discharge" slot-scope="data">
            <a v-if="data.item.discharge_id == null" :href="'/gpra/add?episode='+data.item.episode_id+'&type=2'">Add</a>
            <a v-else :href="'/gpra/index?id='+data.item.discharge_id">{{data.item.discharge_status | assessmentStatus}}</a>
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
            tableFields: [
                {key: 'episode_number', label: 'Episode', sortable: true},
                {key: 'episode_date', label: 'Intake Date', sortable: true},
                {key: 'intake', label: 'Intake'},
                {key: 'followup3mo', label: '3 Month'},
                {key: 'followup6mo', label: '6 Month'},
                {key: 'discharge', label: 'Discharge'},
            ],
            currentPage: 1
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
    })
</script>
</body>
</html>