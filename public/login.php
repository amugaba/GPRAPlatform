<?php
require_once '../model/config.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - GPRA Portal</title>
    <?php include_styles(); ?>
</head>
<body>

<div class="wrapper">
    <div class="container" id="main">
        <div class="row">

            <div style="width: 340px; margin: 200px auto 0;" class="panel panel-default">
                <div class="panel-body">
                    <img src="/img/kfl100.png" style="height: 70px; margin: 0 auto; display: block"><br>
                    <h4 style="text-align: center">Sign-in to GPRA Portal</h4>
                    <p v-if="passwordReset" style="color:#2aabd2">New password set successfully.</p>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include_js(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            passwordReset: <?php echo json_encode(isset($_GET['passchange'])); ?>,
            requestReset: false,
            doReset: false,
            loginFailed: <?php echo json_encode(isset($_GET['incorrect'])); ?>
        }
    })
</script>
</body>
</html>