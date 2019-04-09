<?php
require_once "model/config.php";
require_once "model/DataService.php";
require_once "model/Result.php";

if(isset($_GET['logout'])) {
    session_unset();
    session_destroy();
}

$loginResult = null;
if(isset($_POST['login'])) {
    //check if username and password are valid
    $ds = DataService::getInstance();
    $user = $ds->loginUser($_POST['username'], $_POST['password']);

    if ($user != null) {
        session_unset();
        session_destroy();
        session_cache_expire(300);
        session_start();
        Session::setUser($user);

        header("Location: index.php");
    }
    else
        $loginResult = new Result(false, "Username or password was incorrect.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - HIV Data Portal</title>
    <?php include_styles(); ?>
</head>
<body>

<div class="wrapper">
    <div class="container" id="main">
        <div class="row">

            <div style="width: 340px; margin: 200px auto 0;" class="panel panel-default">
                <div class="panel-body">
                    <img src="img/kfl100.png" style="height: 70px; margin: 0 auto; display: block"><br>
                    <h4 style="text-align: center">Sign-in to HIV/Hep-C Portal</h4>
                    <p v-if="passwordReset" style="color:#2aabd2">New password set successfully.</p>
                    <form action="login.php" method="post">
                        <input type="hidden" name="login" value="1">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control input-block" autofocus="autofocus">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control input-block">
                        <input type="submit" value="Log In" class="btn btn-primary btn-block">
                        <result :field="loginResult"></result>
                        <div style="text-align: center; margin: 10px 0 0">
                            <a href="password_reset.php" target="_blank">Forgot Password</a>
                        </div>

                    </form>

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
            loginResult: <?php echo json_encode($loginResult); ?>,
            passwordReset: <?php echo json_encode(isset($_GET['passchange'])); ?>,
            requestReset: false,
            doReset: false
        }
    })
</script>
</body>
</html>