<?php
require_once "php/config.php";
require_once "php/DataService.php";
require_once "php/Result.php";

check_login();

$ds = DataService::getInstance();
$unfinishedClients = $ds->getUnfinishedClientsByUser(getUserID());
$error = null;
$ask_verification = false;

if(isset($_GET['method'])) {
    if($_GET['method'] == 'addClient') {
        $client_id = $ds->addClient($_GET['participantID'], getUserID());
        setClientID($client_id);
        header("Location: data-consent.php");
    }
    else if($_GET['method'] == 'resumeClient') {
        setClientID($_GET['clientID']);
        header("Location: ".$_GET['page']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - GPRA Portal</title>
    <?php include_styles(); ?>
    <script type="application/javascript">
        $(function() {
            $('#clientsTable').DataTable();
        });
    </script>
</head>
<body>
    <?php include_header(); ?>

    <div style="text-align: center">
        <div class="pageTitle">Add New Client</div>
        <p>Enter 5-digit ID found on the client's business card</p>
        <input type="number" v-model="participantID" placeholder="Participant ID">
        <input type="button" value="Begin" @click="addClient" class="btn btn-primary">
        <result :field="addClientError"></result>
        <input v-if="askVerification" type="button" value="I am sure" @click="verifyAddClient" class="btn btn-primary">
    </div>

    <div class="pageTitle">Resume Unfinished Client</div>
    <p style="text-align: center">Click on an unfinished item to go to that page.</p>
    <table v-if="unfinishedClients.length" id="clientsTable" class="tablesorter">
        <thead>
        <tr>
            <th>Participant ID</th>
            <!--<th>Date</th>-->
            <th>Data Consent</th>
            <th>GPRA/ Demographics</th>
            <th>Dosage Form</th>
            <th>Testing Results</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="client in unfinishedClients">
            <td width="15%">{{client.participant_id}}</td>
            <!--<td width="15%">{{client.date | date}}</td>-->
            <td width="15%"><img v-if="client.data_consent==1" src="img/green-check.png">
                <a v-else href="#" @click="resumeClient(client.id,'data-consent.php')"><img  src="img/red-x.png"></a></td>
            <td width="15%"><img v-if="client.gpra==1 || client.demographics==1" src="img/green-check.png">
                <a v-else-if="client.consented==1" href="#" @click="resumeClient(client.id,'gpra.php')"><img  src="img/red-x.png"></a>
                <a v-else href="#" @click="resumeClient(client.id,'demographics.php')"><img  src="img/red-x.png"></a></td>
            <td width="15%"><img v-if="client.dosage==1" src="img/green-check.png">
                <a v-else href="#" @click="resumeClient(client.id,'services-dosage.php')"><img  src="img/red-x.png"></a></td>
            <td width="15%"><img v-if="client.testing==1" src="img/green-check.png">
                <a v-else href="#" @click="resumeClient(client.id,'testing-results.php')"><img  src="img/red-x.png"></a></td>
        </tr>
        </tbody>
    </table>
    <p v-if="!unfinishedClients.length">There are no incomplete clients.</p><br>

    <div v-if="isAdmin" style="text-align: center">
        <a href="admin.php"><input type="button" value="Go to Admin Section" class="btn btn-primary"></a>
    </div>

    <?php include_footer(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            unfinishedClients: <?php echo json_encode($unfinishedClients); ?>,
            addClientError: <?php echo json_encode($error); ?>,
            askVerification: false,
            participantID: null,
            isAdmin: <?php echo json_encode(isAdmin()); ?>
        },
        methods: {
            addClient: function () {
                if(this.participantID == null || this.participantID.length != 5) {
                    vue.addClientError = {success: false, msg: "Participant ID must be 5 digits."};
                    return;
                }
                ajax('checkParticipantID',[this.participantID], function (result) {
                    if(result.data) {
                        location.href = 'index.php?method=addClient&participantID='+vue.participantID;
                    }
                    else {
                        vue.addClientError = {success: false, msg: "This Participant ID has already been used. Are you sure?"};
                        vue.askVerification = true;
                    }
                });
            },
            verifyAddClient: function () {
                location.href = 'index.php?method=addClient&participantID='+vue.participantID;
            },
            resumeClient: function (client_id, page) {
                location.href = 'index.php?method=resumeClient&clientID='+client_id+"&page="+page;
            }
        }
    })
</script>
</body>
</html>