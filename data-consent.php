<?php
require_once "model/config.php";
require_once "model/DataService.php";

check_login();
$ds = DataService::getInstance();
$client = $ds->getClient(getClientID());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Consent - HIV Prevention Portal</title>
    <?php include_styles(); ?>
    <link rel="stylesheet" href="libs/signature-pad.css">
</head>
<body>
    <?php include_header(); ?>

    <br>
    <h4>Please read the following information and then sign at the bottom.</h4>
    <br>
    <div class="pageTitle">Informed Consent Form for Data Collection</div>
    <div style="font-size: 13pt">
        <?php if($_SESSION['hiv_facility'] == 'marram') { ?>
            <p>This HIV testing and counseling program is offered to you <u>free of charge</u> through support from the Northwest Indiana
                HIV Capacity-Building Initiative.</p>
        <?php } else if($_SESSION['hiv_facility'] == 'echd') { ?>
            <p>This hepatitis C testing and counseling program is offered to you <u>free of charge</u> by the East Chicago Health Department
                through support from the Knowledge for Life program.</p>
        <?php } ?>
        <p>In order to improve the program's service in the community, it is important for us to learn more about how the program is working.
        We also need to provide some basic information to the funding agency.</p>
        <p>To do this, we plan to ask you some questions before you leave. By answering these questions honestly, you will help us support
        the health of residents in Gary, East Chicago, Hammond, and Lake Station, Indiana. These questions are unrelated to your
        medical record and will not be linked to your identity.</p>
        <p><u>Completing the questionnaire is voluntary</u>. Once you begin the questionnaire, you may stop taking it at any time.
        If you do not answer the questions, it will not affect your relationship with staff at Marram Health Center.</p>
        <p>There are some potential risks to answering the questionnaire. It is possible that some of the questions may embarrass
        you or make you uncomfortable. In those cases, you may speak to a staff member or skip those questions.</p>
        <p>Every attempt will be make to keep your identity separate from your answers - answers will be linked to a Unique
        Identification (UID) on a card that will be given only to you. However, we cannot guarantee absolute confidentiality.</p>
        <p>Please type your name and sign below to indicate that you understand the benefits and risks of participating.</p>
        <p>If you have any questions or concerns, please contact Rosie King, Project Evaluator, at 812-855-1237.</p>
        <div style="text-align: center">
            <label for="clientName">Please enter your name:</label> <input id="clientName" type="text"><br><br>
            <b>Sign Below:</b>
        </div>
    </div>

    <div id="signature-pad" class="signature-pad" style="margin: 20px auto">
        <div class="signature-pad--body">
            <canvas></canvas>
        </div>

    </div>
    <div class="signature-pad--footer">
        <div class="signature-pad--actions">
            <div>
                <button type="button" class="button clear" data-action="clear">Clear</button>
                <button type="button" class="button" data-action="undo">Undo</button>
            </div>
        </div>
    </div>
    <div id="submitDiv" style="text-align: center; font-size: 14pt">
        <input type="button" value="I agree to participate" @click="addConsent()" class="btn btn-primary" style="font-size: 18px"><br>
        <result :field="consentResult"></result><br>
        <input type="button" value="I do NOT agree" @click="refuseConsent()" class="btn btn-primary" style="font-size: 14pt">
    </div>

    <?php include_footer(); ?>

    <script src="libs/signature_pad.js"></script>
    <script src="libs/signature-app.js"></script>

<script type="application/javascript">
    vue = new Vue({
        el: '#submitDiv',
        data: {
            consentResult: null,
            userName: <?php echo json_encode(getUsername()); ?>,
            client: <?php echo json_encode($client); ?>
        },
        methods: {
            addConsent: function(){
                let clientName = $("#clientName").val();
                if (signaturePad.isEmpty()) {
                    this.consentResult = {success: false, msg: "Please provide a signature."};
                } else if(clientName == null || clientName === "") {
                    this.consentResult = {success: false, msg: "Please enter your name."};
                }
                else {
                    ajax('addDataConsent',[clientName, signaturePad.toDataURL(), this.userName], function () {
                        vue.client.data_consent = 1;
                        vue.client.consented = 1;
                        ajax('updateClient',[vue.client], function () {
                            location.href = 'gpra.php';
                        });
                    });
                }
            },
            refuseConsent: function() {
                vue.client.data_consent = 1;
                vue.client.consented = 0;
                ajax('updateClient',[vue.client], function () {
                    location.href = 'demographics.php';
                });
            }
        }
    })
</script>
</body>
</html>