<?php
require_once "php/config.php";
require_once "php/DataService.php";
require_once "php/Result.php";

check_login();
check_admin();

$ds = DataService::getInstance();
$unfinishedClients = $ds->getUnfinishedClients();

if(isset($_GET['method']) && $_GET['method'] == 'resumeClient') {
    setClientID($_GET['clientID']);
    header("Location: " . $_GET['page']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - HIV Prevention Portal</title>
    <?php include_styles(); ?>
    <script type="application/javascript">
        $(function() {
            $('#clientsTable').DataTable();
        });
    </script>
</head>
<body>
    <?php include_header(); ?>

    <div class="pageTitle">All Unfinished Clients</div>
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
            <td width="15%"><img v-if="client.services==1" src="img/green-check.png">
                <a v-else href="#" @click="resumeClient(client.id,'services-dosage.php')"><img  src="img/red-x.png"></a></td>
            <td width="15%"><img v-if="client.testing==1" src="img/green-check.png">
                <a v-else href="#" @click="resumeClient(client.id,'testing-results.php')"><img  src="img/red-x.png"></a></td>
        </tr>
        </tbody>
    </table>
    <p v-if="!unfinishedClients.length">There are no incomplete clients.</p><br>

    <div style="text-align: center">
        <div class="pageTitle">Export Data</div>
        <a href="export-gpra.php"><input type="button" value="GPRA Data" class="btn btn-primary"></a><br><br>
        <a href="export-dosage.php"><input type="button" value="Services Dosage" class="btn btn-primary"></a><br><br>
        <a href="export-consents.php"><input type="button" value="Data Consents" class="btn btn-primary"></a><br><br>
        <input type="button" value="Demographics" class="btn btn-primary" @click="exportDemographics()"><br><br>
        <input type="button" value="Testing Results" class="btn btn-primary" @click="exportTestingResults()"><br><br>
    </div>

    <?php include_footer(); ?>

<script type="application/javascript">
    function selectCode(val) {
        if(val == null)
            return ",";
        else
            return (parseInt(val)) + ",";
    }
    vue = new Vue({
        el: '#main',
        data: {
            unfinishedClients: <?php echo json_encode($unfinishedClients); ?>
        },
        methods: {
            resumeClient: function (client_id, page) {
                location.href = 'index.php?method=resumeClient&clientID='+client_id+"&page="+page;
            },
            exportTestingResults: function() {
                ajax('getTestingResults',null, function (result) {
                    let tests = result.data;
                    let csv = "previous_test,hiv_result,hiv_result_received,hiv_referred,hep_b_result,hep_c_result," +
                        "hep_result_received,hep_referred,hep_vaccination\r\n";
                    for(let i=0; i<tests.length; i++) {
                        let test = tests[i];
                        csv += selectCode(test.previous_test) + selectCode(test.hiv_result) + selectCode(test.hiv_result_received) + selectCode(test.hiv_referred);
                        csv += selectCode(test.hep_b_result) + selectCode(test.hep_c_result) + selectCode(test.hep_result_received);
                        csv += selectCode(test.hep_referred) + selectCode(test.hep_vaccination) + "\r\n";
                    }
                    this.saveCSV(csv, 'hiv_testing_results.csv');
                });
            },
            exportServices: function() {
                ajax('getServices',null, function (result) {
                    let services = result.data;
                    let csv = "participant_id,date,hiv_testing,hiv_counselling,risk_reduction,hep_testing,hep_counselling,other_testing,hiv_education," +
                        "std_education,hep_education,drug_education,drug_counselling,other_services\r\n";
                    for(let i=0; i<services.length; i++) {
                        let service = services[i];
                        csv += service.participant_id + "," + service.date + ",";
                        csv += selectCode(service.hiv_testing) + selectCode(service.hiv_counselling) + selectCode(service.risk_reduction);
                        csv += selectCode(service.hep_testing) + selectCode(service.hep_counselling) + selectCode(service.other_testing);
                        csv += selectCode(service.hiv_education) + selectCode(service.std_education) + selectCode(service.hep_education);
                        csv += selectCode(service.drug_education) + selectCode(service.drug_counselling) +selectCode(service.other_services) + "\r\n";
                    }
                    this.saveCSV(csv, 'hiv_services_dosage.csv');
                });
            },
            exportDemographics: function() {
                ajax('getDemographics',null, function (result) {
                    let demographics = result.data;
                    let csv = "participant_id,date,gender,age,hispanic,homeless,black,american_indian,asian,hawaiian,white,other_race\r\n";
                    for(let i=0; i<demographics.length; i++) {
                        let demo = demographics[i];
                        csv += demo.participant_id + ",";
                        //csv += demo.date + ",";
                        csv += (moment().format('M')-1) + "-1-" + moment().format('Y') + ","; //for date just use 1st of the current month
                        csv += selectCode(demo.gender) + selectCode(demo.age) + selectCode(demo.hispanic);
                        csv += selectCode(demo.homeless) + selectCode(demo.black) + selectCode(demo.american_indian);
                        csv += selectCode(demo.asian) + selectCode(demo.hawaiian) + selectCode(demo.white);
                        csv += selectCode(demo.other_race) + "\r\n";
                    }
                    this.saveCSV(csv, 'hiv_demographics.csv');
                });
            },
            saveCSV: saveCSV
        }
    })
</script>
</body>
</html>