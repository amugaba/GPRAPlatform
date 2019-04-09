<?php
require_once "model/config.php";
require_once "model/DataService.php";

check_login();
check_admin();

$ds = DataService::getInstance();
$dosages = $ds->getDosages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export Dosages - HIV Prevention Portal</title>
    <?php include_styles(); ?>
    <script type="application/javascript">
        $(function() {
            $('#dataTable').DataTable();
        });
    </script>
</head>
<body>
    <?php include_header(); ?>

    <div class="pageTitle">Dosage Export</div>
    <div style="margin: 20px auto; text-align: center;">
        <input type="button" value="Export New Dosages" @click="exportNew()" class="btn btn-primary"><br><br>
        <input type="button" value="Export All Dosages" @click="exportAll()" class="btn btn-primary">
    </div>

    <div class="pageTitle">Or select one or more dosage records to export</div>
    <table v-if="dosages.length" id="dataTable" class="tablesorter">
        <thead>
        <tr>
            <th>Select</th>
            <th>Auto ID</th>
            <th>Participant ID</th>
            <!--<th>Date</th>-->
            <th>Exported?</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(dosage, index) in dosages">
            <td width="10%"><input type="checkbox" v-model="selectedDosages" :value="index"></td>
            <td width="15%">{{dosage.id}}</td>
            <td width="25%">{{dosage.participant_id}}</td>
            <!--<td width="25%">{{dosage.date | date}}</td>-->
            <td width="25%">{{dosage.exported | yn}}</td>
        </tr>
        </tbody>
    </table>
    <p v-if="!dosages.length">There are no dosage records.</p><br>
    <input type="button" value="Export Selected Dosages" @click="exportSelected()" class="btn btn-primary">

    <?php include_footer(); ?>

<script type="application/javascript">
    function selectCode(val) {
        if(val == null)
            return "98,";
        else
            return (parseInt(val)+1) + ",";
    }
    function selectCodeZero(val) {
        if(val == null)
            return "98,";
        else
            return val + ",";
    }
    function textCode(val) {
        if(val == null || val == '')
            return "98,";
        else
            return val + ",";
    }
    function yesNo(val) {
        if(val == null || val == 1)
            return "0,";
        else
            return "1,";
    }
    //convert each character into a code
    function separateString(string) {
        let result = "";
        for(let i=0; i<string.length; i++) {
            if(string[i])
            result += string[i] + ",";
        }
        return result;
    }
    function isNonzero(val) {
        if(parseInt(val) > 0)
            return 1;
        return 0;
    }
    vue = new Vue({
        el: '#main',
        data: {
            dosages: <?php echo json_encode($dosages); ?>,
            selectedDosages: [],
            userID: <?php echo json_encode(getUserID()); ?>
        },
        methods: {
            exportAll: function() {
                let ids = [];
                for(let i=0; i< this.dosages.length; i++)
                    ids.push(i);
                this.exportDosages(ids);
            },
            exportNew: function() {
                let ids = [];
                for(let i=0; i< this.dosages.length; i++)
                    if(this.dosages[i].exported==0)
                        ids.push(i);
                this.exportDosages(ids);
            },
            exportSelected: function(){
                this.exportDosages(this.selectedDosages);
            },
            exportDosages: function(ids) {
                if(ids.length == 0) {
                    alert("No dosages exported.");
                    return;
                }

                let csv = "MONTH,DAY,YEAR,GRANT_ID,DESIGNGRP,ADMIN_FRMT,PARTID,NUM_INTERV,INTERV_TYP1,DURATION1,INTERV_TYP2,DURATION2," +
                    "INTERV_TYP3,DURATION3,INTERV_TYP4,DURATION4\r\n";

                let exportedIDs = [];
                for(let j=0; j< ids.length; j++) {
                    let dosage = this.dosages[ids[j]];

                    //collect all nonzero services into an array of pairs [service ID, minutes]
                    let services = [];
                    if (isNonzero(dosage.hiv_testing))
                        services.push(['11', parseInt(dosage.hiv_testing)]);
                    if (isNonzero(dosage.hiv_counselling))
                        services.push(['3', parseInt(dosage.hiv_counselling)]);
                    if (isNonzero(dosage.risk_reduction))
                        services.push(['2', parseInt(dosage.risk_reduction)]);
                    if (isNonzero(dosage.hep_testing))
                        services.push(['11a', parseInt(dosage.hep_testing)]);
                    if (isNonzero(dosage.hep_counselling))
                        services.push(['3a',  parseInt(dosage.hep_counselling)]);
                    if (isNonzero(dosage.other_testing))
                        services.push(['11b', parseInt(dosage.other_testing)]);
                    if (isNonzero(dosage.hiv_education))
                        services.push(['6',  parseInt(dosage.hiv_education)]);
                    if (isNonzero(dosage.std_education))
                        services.push(['6a', parseInt(dosage.std_education)]);
                    if (isNonzero(dosage.hep_education))
                        services.push(['7', parseInt(dosage.hep_education)]);
                    if (isNonzero(dosage.drug_education))
                        services.push(['5', parseInt(dosage.drug_education)]);
                    if (isNonzero(dosage.drug_counselling))
                        services.push(['4a', parseInt(dosage.drug_counselling)]);
                    if (isNonzero(dosage.other_services))
                        services.push(['10', parseInt(dosage.other_services)]);

                    for(let i=0; i<services.length; i++) {
                        //begin new row every four services
                        if (i % 4 == 0) {
                            //csv += dosage.date.substr(5, 2) + "," + dosage.date.substr(8, 2) + "," + dosage.date.substr(0, 4) + ",";
                            csv += (moment().format('M')-1) + ",1," + moment().format('Y') + ","; //for date just use 1st of the current month
                            csv += "21706,1,1," + dosage.participant_id + "," + Math.min(services.length-i,4);
                        }
                        //add service
                        csv += "," + services[i][0] + "," + services[i][1];
                        //add line break after fourth service
                        if(i % 4 == 3 && i+1 != services.length)
                            csv += "\r\n";
                    }
                    //add line break between clients
                    csv += "\r\n";

                    if(dosage.exported == 0) {
                        exportedIDs.push(dosage.id);
                        dosage.exported = 1;
                    }
                }

                saveCSV(csv, "hiv_dosage_data.csv");
                if(exportedIDs.length > 0)
                    ajax('setDosagesExported', [exportedIDs], function () { });
            }
        }
    })
</script>
</body>
</html>