<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Add New Client</div>
    <div style="text-align: center">
        <form method="post" action="/home/addClient">
            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
            <input type="submit" value="Create Client" class="btn btn-primary">
        </form>
        <result :field="result"></result>
    </div>


    <div class="pageTitle">Search Client Records</div>
    <form @submit.prevent="searchClients" style="text-align: center">
        <input type="text" v-model="searchID" placeholder="Client ID">
        <input type="submit" value="Search Clients" class="btn btn-primary"><br>
        <label><input type="checkbox" v-model="findRecentOnly"> Find most recent episode only</label>
    </form>

    <b-table :fields="tableFields" :items="clients" :per-page="15" :current-page="currentPage" hover bordered>
        <template slot="client" slot-scope="data">
            <a :href="'/home/client?id='+data.item.id">{{data.item.uid}}</a>
        </template>
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
    <b-pagination v-show="clients.length>15" :total-rows="clients.length" :per-page="15" v-model="currentPage" style="float: right; margin-top: 0"></b-pagination>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            clients: [],
            searchID: null,
            findRecentOnly: true,
            tableFields: [
                {key: 'client', label: 'Client', sortable: true},
                {key: 'episode_number', label: 'Episode', sortable: true},
                {key: 'episode_date', label: 'Intake Date', sortable: true},
                {key: 'intake', label: 'Intake'},
                {key: 'followup3mo', label: '3 Month'},
                {key: 'followup6mo', label: '6 Month'},
                {key: 'discharge', label: 'Discharge'},
                ],
            currentPage: 1,
            result: <?php echo json_encode($this->result); ?>
        },
        methods: {
            searchClients: function () {
                ajax('/home/searchClients',[this.searchID, this.findRecentOnly], function (result) {
                    vue.clients = result.data;
                });
            }
        }
    })
</script>
</body>
</html>