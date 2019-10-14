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


    <div class="pageTitle">Filter Client Records</div>
    <form @submit.prevent="searchClients" class="panel mx-auto">
        <div class="form-group">
            <input type="text" v-model="filter.clientID" placeholder="Client ID" class="form-control">
        </div>
        <div class="form-group">
            <select v-model="filter.status" class="form-control">
                <option :value="null">Filter by status...</option>
                <option value="1">Show followups that are due</option>
                <option value="2">Show incomplete GPRAs</option>
            </select>
        </div>
        <div class="form-group">
            <select v-model="filter.userID" class="form-control">
                <option :value="null">Filter by clinician...</option>
                <option v-for="user in users" :value="user.id">{{user.name}}</option>
            </select>
        </div>
        <label><input type="checkbox" v-model="filter.latestOnly"> Show most recent episode only</label>
    </form>

    <b-table :fields="tableFields" :items="clients" :per-page="10" :current-page="currentPage" hover bordered sort-by="episode_date"
             :sort-desc="true" :filter-function="myFilter" :filter="filter" @filtered="onFiltered" ref="clientsTable">
        <template v-slot:cell(uid)="data">
            <a :href="'/home/client?id='+data.item.id">{{data.item.uid}}</a>
        </template>
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
    <b-pagination v-show="totalRows>10" :total-rows="totalRows" :per-page="10" v-model="currentPage" style="float: right; margin-top: 0"></b-pagination>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            clients: <?= json_encode($this->clients) ?>,
            users: <?= json_encode($this->users) ?>,
            filter: {
                searchID: null,
                status: null,
                userID: null,
                latestOnly: true
            },
            searchID: null,
            searchStatus: null,
            searchUser: null,
            findRecentOnly: true,
            dueClasses: ['not-due', 'due', 'past-due'],
            tableFields: [
                {key: 'uid', label: 'Client', sortable: true},
                {key: 'episode_number', label: 'Episode', sortable: true},
                {key: 'intake_date', label: 'Intake Date', sortable: true},
                {key: 'intake', label: 'Intake'},
                {key: 'followup3mo', label: '3 Month'},
                {key: 'followup6mo', label: '6 Month'},
                {key: 'discharge', label: 'Discharge'},
                ],
            currentPage: 1,
            totalRows: null,
            result: <?php echo json_encode($this->result); ?>
        },
        mounted() {
            // Set the initial number of items
            this.totalRows = this.$refs.clientsTable.filteredItems.length;
            for(let i = 0; i < this.clients.length; i++) {
                let client = this.clients[i];
                client.due3MO = getDueStatus(client.intake_date, 2, 5);
                client.due6MO = getDueStatus(client.intake_date, 5, 8);
            }
        },
        methods: {
            myFilter: function(item, filter) {
                let match = true;
                if(filter.clientID != null)
                    match = item.uid.indexOf(filter.clientID) !== -1;
                if(match && filter.status == 1) { //followups due
                    match = item.due3MO === 1 || item.due6MO === 1;
                }
                if(match && filter.status == 2) { //incomplete GPRAs
                    match = item.intake_status === 0 || item.followup_3mo_status === 0 || item.followup_6mo_status === 0 || item.discharge_status === 0;
                }
                if(match && filter.userID != null) {
                    match = item.user_intake === filter.userID || item.user_3mo === filter.userID
                        ||item.user_6mo === filter.userID ||item.user_discharge === filter.userID;
                }
                if(match && filter.latestOnly === true) {
                    match = item.episode_number === item.latest_episode;
                }
                return match;
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
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