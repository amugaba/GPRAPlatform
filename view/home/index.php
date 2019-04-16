<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - GPRA Portal</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header(); ?>

    <div class="pageTitle">Add New Client</div>
    <div style="text-align: center">
        <form method="post" action="/home/addClient">
            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
            <input type="text" name="uid" placeholder="Client ID">
            <input type="submit" value="Create Client" class="btn btn-primary">
        </form>
        <result :field="result"></result>
    </div>


    <div class="pageTitle">Search Existing Client</div>
    <div style="text-align: center">
        <input type="text" v-model="searchID" placeholder="Client ID">
        <input type="button" value="Search Clients" @click="searchClients" class="btn btn-primary">
    </div>

    <div style="width: 250px; margin: 10px auto">
        <b-table :fields="tableFields" :items="clients" :per-page="15" :current-page="currentPage" striped>
            <template slot="id" slot-scope="data">
                <a :href="'home/client?id='+data.value"><img src="/img/edit.png"></a>
            </template>
        </b-table>
        <b-pagination v-show="clients.length>15" :total-rows="clients.length" :per-page="15" v-model="currentPage" style="float: right; margin-top: 0"></b-pagination>
    </div>


    <?php include_footer(); ?>
    <?php include_js(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            clients: [],
            searchID: null,
            tableFields: [
                {key: 'id', label: 'Open', sortable: false},
                {key: 'uid', label: 'Client ID', sortable: true}
                ],
            currentPage: 1,
            result: <?php echo json_encode($this->result); ?>
        },
        methods: {
            searchClients: function () {
                ajax('/home/searchClients',[this.searchID], function (result) {
                    vue.clients = result.data;
                });
            }
        }
    })
</script>
</body>
</html>