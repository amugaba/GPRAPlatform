<?php
require_once "model/config.php";
require_once "model/DataService.php";

check_login();
check_admin();

$ds = DataService::getInstance();
$gpras = $ds->getGPRAs();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export GPRAs - HIV Prevention Portal</title>
    <?php include_styles(); ?>
    <script type="application/javascript">
        $(function() {
            $('#gprasTable').DataTable();
        });
    </script>
</head>
<body>
    <?php include_header(); ?>

    <div class="pageTitle">GPRA Export</div>
    <div style="margin: 20px auto; text-align: center;">
        <input type="button" value="Export New (SPARS)" @click="exportNew(0)" class="btn btn-primary">
        <input type="button" value="Export All (SPARS)" @click="exportAll(0)" class="btn btn-primary"><br><br>
        <input type="button" value="Export New (Eval)" @click="exportNew(1)" class="btn btn-primary">
        <input type="button" value="Export All (Eval)" @click="exportAll(1)" class="btn btn-primary">
    </div>

    <div class="pageTitle">Or select one or more GPRA records to export</div>
    <table v-if="gpras.length" id="gprasTable" class="tablesorter">
        <thead>
        <tr>
            <th>Select</th>
            <th>Auto ID</th>
            <th>Participant ID</th>
            <!--<th>Date Completed</th>-->
            <th>Date Export SPARS</th>
            <th>Date Export Eval</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(gpra, index) in gpras">
            <td width="10%"><input type="checkbox" v-model="selectedGPRAs" :value="index"></td>
            <td width="10%">{{gpra.id}}</td>
            <td width="20%">{{gpra.participant_id}}</td>
            <!--<td width="20%">{{gpra.date | date}}</td>-->
            <td width="20%">{{gpra.date_exported_spars | date}}</td>
            <td width="20%">{{gpra.date_exported_eval | date}}</td>
        </tr>
        </tbody>
    </table>
    <p v-if="!gpras.length">There are no GPRA records.</p><br>
    <input type="button" value="Export Selected (SPARS)" @click="exportSelected(0)" class="btn btn-primary">
    <input type="button" value="Export Selected (Eval)" @click="exportSelected(1)" class="btn btn-primary">

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
    vue = new Vue({
        el: '#main',
        data: {
            gpras: <?php echo json_encode($gpras); ?>,
            selectedGPRAs: [],
            userID: <?php echo json_encode(getUserID()); ?>
        },
        methods: {
            exportAll: function(method) {
                let ids = [];
                for(let i=0; i< this.gpras.length; i++)
                    ids.push(i);
                if(method===0)
                    this.exportSpars(ids);
                else
                    this.exportEval(ids);
            },
            exportNew: function(method) {
                let ids = [];
                if(method===0) {
                    for (let i = 0; i < this.gpras.length; i++)
                        if (this.gpras[i].date_exported_spars == null)
                            ids.push(i);
                    this.exportSpars(ids);
                }
                else {
                    for (let i = 0; i < this.gpras.length; i++)
                        if (this.gpras[i].date_exported_eval == null)
                            ids.push(i);
                    this.exportEval(ids);
                }
            },
            exportSelected: function(method){
                if(method===0)
                    this.exportSpars(this.selectedGPRAs);
                else
                    this.exportEval(this.selectedGPRAs);
            },
            exportEval: function(ids) {
                if(ids.length === 0) {
                    alert("No GPRAs exported.");
                    return;
                }

                let csv = "id, participant_id, gender, birth_year, not_hispanic, mexican, puerto_rican, cuban, other_hispanic, " +
                    "white, black, american_indian, asian_indian, chinese, filipino, japanese, korean, vietnamese, other_asian, hawaiian," +
                    "guamanian, samoan, other_pacific_islander, sex_orientation, english, language, education, " +
                    "college, employment, disability, jail, veteran, active_duty, deployed, family_veteran, family_relation1, family_relation2, " +
                    "family_relation3, family_relation4, family_relation5, family_relation6, know_testing, harm_condom, harm_drugs, harm_needles, " +
                    "comfort, housing, truthful, know_for_life, talk_friends, date_exported_spars, date_exported_eval\r\n";

                let exportedIDs = [];
                for(let i=0; i< ids.length; i++) {
                    let gpra = this.gpras[ids[i]];
                    csv += gpra.id + "," + gpra.participant_id + ",";
                    csv += selectCode(gpra.gender) + textCode(gpra.birth_year);

                    if(gpra.ethnicity === '00000')
                        csv += "98,98,98,98,98,";
                    else if(gpra.ethnicity[0] === '1')
                        csv += "1,0,0,0,0,";
                    else
                        csv += separateString(gpra.ethnicity);

                    if(gpra.race === '00000000000000')
                        csv += "98,98,98,98,98,98,98,98,98,98,98,98,98,98,";
                    else {
                        csv += separateString(gpra.race);
                    }

                    csv += selectCode(gpra.sex_orientation) + selectCode(gpra.english) + selectCode(gpra.language) + selectCode(gpra.education);
                    csv +=  selectCodeZero(gpra.college) + selectCode(gpra.employment) + yesNo(gpra.disability) + selectCodeZero(gpra.jail);


                }
            },
            exportSpars: function(ids) {
                if(ids.length === 0) {
                    alert("No GPRAs exported.");
                    return;
                }

                let csv = "INSTRMNT_LANG,LANG_OTHER,GRANT_ID,DESIGNGRP,PARTID,MONTH,DAY,YEAR,INTTYPE,INTDUR,INTERVENTION_A,INTERVENTION_B," +
                    "INTERVENTION_C,GENDER,YOB,E_NONHISPAN,E_MEXICAN,E_PUERTRICAN,E_CUBAN,E_OTHERHISPAN,R_WHITE_N,R_BLACK_N,R_AMERINALSK_N," +
                    "R_ASIAIN_N,R_CHINESE_N,R_FILIP_N,R_JAPAN_N,R_KOR_N,R_VIETNAM_N,R_OTHERASIA_N,R_HAW_N,R_GUAM_N,R_SAMO_N,R_OTHERPI_N,SEX_PR," +
                    "SPEAK_ENG,LANG,EDLEVEL_N,COLLEGE,EMPLOY_N,PMECONDITION,JAILTIME_N,MILSERVENO,MILSERVEARM,MILSERVERES,MILSERVENG,ACTIVE," +
                    "DEPLOYEDNO,DEPLOYEDIRAQ,DEPLOYEDPERS,DEPLOYEDASIA,DEPLOYEDKOR,DEPLOYEDWWII,DEPLOYEDOTH,OTHACTIVE,SERVREL1,SERVREL1_OTHER," +
                    "SERVREL2,SERVREL2_OTHER,SERVREL3,SERVREL3_OTHER,SERVREL4,SERVREL4_OTHER,SERVREL5,SERVREL5_OTHER,SERVREL6,SERVREL6_OTHER," +
                    "RSKCIG,RSKMJ,RSKALC,PEERBINGE_A,WRGBINGE_A,WRGSEX_UNP_A,RSKANYSEX_UNP,RSKSEX_ALCDRG,RSKNDL_SHR,CNTRL_REFUSEMOOD," +
                    "CNTRL_WAITCNDM,CNTRL_TREAT,CNTRL_SEXPRAC,CNTRL_ASKCNDM,CNTRL_REFUSECNDM,HIV_SICK_N,HIV_GAYSEX_N,HIV_BCPILL_N,HIV_DRGS_N," +
                    "HIV_CURE_N,KNOW_HIV,KNOW_SA,GET_MEDHLP,LIFE_RESP_SERV,RESPECT_RACE,RESPECT_REL,RESPECT_GENDER,RESPECT_AGE,RESPECT_SEXPR," +
                    "RESPECT_DISABLE,RESPECT_MH,RESPECT_HIV,RESPECT_NONE,HIV_RESULTS_N,TALK_ALLPERS_N,REL_IMP,CIG30D,TOB30D,VAP30D,ALC30D," +
                    "BINGE530D,MJ30D,ILL30D,RX30D,SPICE30D,INJECT30D,CUT_ALC,ANNOY_ALC,GUILT_ALC,MORN_ALC,EMO_AFT,MENTLH30D,SEX_HAD,SEX_ANY30D," +
                    "LASTSEX_UNP,SEX_MALEEVER,SEX_FEMALEEVER,SEX_MNY_3MOS,WHENSEX4STFF_UNP,WHENSEXHIVSTD_UNP,WHENSEXDRUG_UNP,WHENSEXALCDRG," +
                    "ANYABUSE_3M,SEXUNWANT_12M,MSTATUS_N,LIVE_N,HOMETYPE_N,PARSUPB,HINCOMEO_N,HC_HAVE_N,DRGTST,SVY_TRUTH\r\n";

                let exportedIDs = [];
                for(let i=0; i< ids.length; i++) {
                    let gpra = this.gpras[ids[i]];
                    csv += "1,,21706,1,";//language through group type
                    csv += gpra.participant_id+",";
                    //csv += gpra.date.substr(5,2) + "," + gpra.date.substr(8,2) + "," + gpra.date.substr(0,4) + ",";
                    csv += (moment().format('M')-1) + ",1," + moment().format('Y') + ","; //for date just use 1st of the current month
                    csv += "2,1,RAPID HIV TESTING,98,98,";//or maybe code is IPN078
                    csv += selectCode(gpra.gender) + textCode(gpra.birth_year);

                    if(gpra.ethnicity === '00000')
                        csv += "98,98,98,98,98,";
                    else if(gpra.ethnicity[0] === '1')
                        csv += "1,0,0,0,0,";
                    else
                        csv += separateString(gpra.ethnicity);

                    if(gpra.race === '00000000000000')
                        csv += "98,98,98,98,98,98,98,98,98,98,98,98,98,98,";
                    else {
                        csv += separateString(gpra.race);
                    }

                    csv += selectCode(gpra.sex_orientation) + selectCode(gpra.english) + selectCode(gpra.language);
                    csv += selectCode(gpra.education) + selectCodeZero(gpra.college) + selectCode(gpra.employment) + yesNo(gpra.disability);

                    if(gpra.jail === '0')
                        csv += "99,";
                    else
                        csv += selectCodeZero(gpra.jail);

                    if(gpra.veteran === '0000')
                        csv += "98,98,98,98,98,98,98,98,98,98,98,98,";
                    else if(gpra.veteran[0] === '1')
                            csv += "1,0,0,0,0,98,98,98,98,98,98,98,";
                    else {
                        csv += separateString(gpra.veteran);
                        if(gpra.active_duty === '3')
                            csv += "0,";
                        else
                            csv += selectCode(gpra.active_duty);
                        if(gpra.deployed === '0000000')
                            csv += "98,98,98,98,98,98,98,";
                        else if (gpra.deployed[0] === '1')
                                csv += "1,0,0,0,0,0,0,";
                        else
                            csv += separateString(gpra.deployed);
                    }

                    csv += selectCodeZero(gpra.family_veteran);
                    let numFamily = gpra.family_veteran == null ? 0 : gpra.family_veteran;
                    let familyValues = [gpra.family_relation1, gpra.family_relation2, gpra.family_relation3, gpra.family_relation4, gpra.family_relation5,gpra.family_relation6];
                    for(let j=0; j<numFamily; j++)
                        csv += selectCode(familyValues[j]) + ","; //for each question that should be answered set relation and blank for Other, specify
                    for(let j=0; j<(6-numFamily); j++)
                        csv += "98,,";

                    csv += "98,98,98,98,98,98,";//drug questions not asked
                    csv += gpra.harm_condom === 4 ? "97," : selectCode(gpra.harm_condom);
                    csv += gpra.harm_drugs === 4 ? "97," : selectCode(gpra.harm_drugs);
                    csv += gpra.harm_needles === 4 ? "97," : selectCode(gpra.harm_needles);
                    csv += "98,98,98,98,98,98,";//relationship questions not asked
                    csv += "98,98,98,98,98,";//HIV knowledge questions not asked
                    csv += yesNo(gpra.know_testing);
                    csv += "98,98,98,98,98,98,98,98,98,98,98,98,98,";//healthcare services questions not asked
                    csv += "98,98,";//relation and religion questions not asked
                    csv += "98,98,98,98,98,98,98,98,98,98,";//past 30 days questions not asked
                    csv += "98,98,98,98,98,";//alcohol questions not asked
                    csv += "98,98,98,98,98,98,98,98,98,98,98,";//mental and sex questions not asked
                    csv += "98,98,98,98,";//abuse and family questions not asked
                    csv += selectCode(gpra.housing);
                    csv += "98,98,98,98,";//74-77
                    if(gpra.truthful == null)
                        csv += "98";
                    else if(gpra.truthful == '0')
                        csv += "4";
                    else if(gpra.truthful == '1')
                        csv += "3";
                    else if(gpra.truthful == '2')
                        csv += "2";
                    else if(gpra.truthful == '3')
                        csv += "1";
                    csv += "\r\n";

                    gpra.date_exported_spars = moment();
                    exportedIDs.push(gpra.id);
                }
                saveCSV(csv, "hiv_gpra_data.csv");
                ajax('updateGPRAExportDate', [exportedIDs, 0], function () { });
            }
        }
    })
</script>
</body>
</html>