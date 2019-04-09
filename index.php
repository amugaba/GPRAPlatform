<?php
require_once "model/config.php";
require_once "model/DataService.php";
require_once "model/Result.php";

check_login();

$ds = DataService::getInstance();
$error = null;

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
    <title>Home - GPRA Portal</title>
    <?php include_styles(); ?>
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

    <div v-if="isAdmin" style="text-align: center">
        <a href="admin.php"><input type="button" value="Go to Admin Section" class="btn btn-primary"></a>
    </div>

    <?php include_footer(); ?>
    <?php include_js(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            addClientError: <?php echo json_encode($error); ?>,
            askVerification: false,
            participantID: null,
            isAdmin: <?php echo json_encode(isAdmin()); ?>
        },
        methods: {
            addClient: function () {
                if(this.participantID == null || this.participantID.length !== 5) {
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