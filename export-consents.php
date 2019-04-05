<?php
require_once "php/config.php";
require_once "php/DataService.php";

check_login();
check_admin();

$ds = DataService::getInstance();
$consents = $ds->getDataConsents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Consents - HIV Prevention Portal</title>
    <?php include_styles(); ?>
    <script type="application/javascript">
        $(function() {
            $('#consentsTable').DataTable({
                "order": [[3, "desc"]]
            });
        });
    </script>
</head>
<body>
    <?php include_header(); ?>

    <h3>Data Consent Export</h3>

    <h4>Select a consent record to to display the signature.</h4>
    <table v-if="consents.length" id="consentsTable" class="tablesorter">
        <thead>
        <tr>
            <th>Select</th>
            <th>UUID</th>
            <th>Participant Name</th>
            <!--<th>Date</th>-->
            <th>Witness</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(consent, index) in consents">
            <td width="10%"><input type="radio" v-model="selectedConsent" :value="consent"></td>
            <td width="15%">{{consent.uuid}}</td>
            <td width="30%">{{consent.name}}</td>
            <!--<td width="15%">{{consent.date | date}}</td>-->
            <td width="30%">{{consent.witness}}</td>
        </tr>
        </tbody>
    </table>
    <p v-if="!consents.length">There are no consent records.</p><br>

    <img v-if="selectedConsent" :src="selectedConsent.signature" style="max-width:100%">

    <?php include_footer(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            consents: <?php echo json_encode($consents); ?>,
            selectedConsent: null,
            userID: <?php echo json_encode(getUserID()); ?>,
        }
    })
</script>
</body>
</html>