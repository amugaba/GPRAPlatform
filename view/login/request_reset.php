<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeaderNoNav(); ?>

    <div class="panel float-center">
        <div class="pageTitle" style="margin-top: 0">Reset your password</div>
        <p>Enter your email address and we will send you a link to reset your password.</p>
        <form action="/login/sendReset" method="post">
            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
            <input type="text" class="form-control input-block" autofocus="autofocus" name="email" placeholder="Enter your email address">
            <input type="submit" class="btn btn-primary btn-block" value="Send password reset email">
        </form>
        <result :field="result"></result>
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