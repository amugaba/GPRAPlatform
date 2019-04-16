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
                    <result :field="result"></result>

                    <form action="/login/login" method="post">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control input-block" autofocus="autofocus">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control input-block">
                        <input type="submit" value="Log In" class="btn btn-primary btn-block" style="margin-top: 10px">
                    </form>

                    <div style="text-align: center; margin: 10px 0 0">
                        <a href="/login/requestReset" target="_blank">Forgot Password</a>
                    </div>
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
            result: <?php echo json_encode($this->result); ?>
        }
    })
</script>
</body>
</html>