<?php
require_once "model/config.php";
require_once "model/DataService.php";
require_once "model/MailService.php";

$displayForm = 0;
$loginResult = null;

if(isset($_POST['sendmail'])) {
    //check if username is valid
    $ds = DataService::getInstance();
    $user = $ds->getUserByEmail($_POST['email']);

    if ($user != null) {
        $ms = new MailService();
        $ms->sendPasswordReset($user);
        $displayForm = 1;
    }
    else {
        $loginResult = new Result(false, "Username was incorrect.");
    }
}

if(isset($_GET['code']) && isset($_GET['id'])){
    $ds = DataService::getInstance();
    $resetApproved = $ds->checkResetCode($_GET['id'], $_GET['resetcode']);
    $displayForm = 2;
}

if(isset($_POST['changepass'])) {
    //check if password is valid
    if(strlen($_POST['password']) < 8)
        $loginResult = new Result(false, "Password must be at least 8 characters.");
    else if($_POST['password'] != $_POST['password_confirmation'])
        $loginResult = new Result(false, "The confirmation password must be the same.");
    else {
        $ds = DataService::getInstance();
        $ds->updatePassword($_POST['password'], $_GET['id']);
        header("Location: login.php?passchange=1");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - HIV Data Portal</title>
    <?php include_styles(); ?>
</head>
<body>

<div class="wrapper">
    <div class="container" id="main">
        <div class="row">

            <div style="width: 340px; margin: 200px auto 0;" class="panel panel-default">
                <div class="panel-body">
                    <img src="img/kfl100.png" style="height: 70px; margin: 0 auto; display: block"><br>
                    <h4 style="text-align: center">Reset your password</h4>

                    <div v-if="displayForm==0">
                        <p>Enter your email address and we will send you a link to reset your password.</p>
                        <form action="<?php echo_self(); ?>" method="post">
                            <input type="hidden" name="sendmail" value="1">
                            <input type="text" class="form-control input-block" autofocus="autofocus" name="email" placeholder="Enter your email address">
                            <input type="submit" class="btn btn-primary btn-block" value="Send password reset email">
                        </form>
                        <result :field="loginResult"></result>
                    </div>

                    <div v-if="displayForm==1">
                        Check your email for a link to reset your password. If it doesn't appear within a few minutes, check your spam folder.
                    </div>

                    <div v-if="displayForm==2">
                        <p>Password must be at least 8 characters long.</p>
                        <form action="<?php echo_self(); ?>" method="post">
                            <input type="hidden" name="changepass" value="1">
                            <label>Password</label>
                            <input autofocus="autofocus" class="form-control input-block" id="password" name="password" value="" type="password">
                            <label>Confirm password</label>
                            <input class="form-control input-block" id="password_confirmation" name="password_confirmation" value="" type="password">
                            <input class="btn btn-primary btn-block" name="commit" tabindex="3" value="Change password" type="submit">
                        </form>
                        <result :field="loginResult"></result>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="application/javascript">
    new Vue({
        el: '#main',
        data: {
            loginResult: <?php echo json_encode($loginResult); ?>,
            displayForm: <?php echo json_encode($displayForm); ?>
        }
    })
</script>
</body>
</html>