<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>

    <?php $this->includeHeaderNoNav(); ?>

    <div class="panel float-center">
        <div class="pageTitle" style="margin-top: 0">Sign-in to GPRA Portal</div>
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
            <a href="/login/requestReset">Forgot Password</a>
        </div>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

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