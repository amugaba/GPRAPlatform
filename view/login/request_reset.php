<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - GPRA Portal</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header_no_nav(); ?>

    <div style="width: 340px; margin: 200px auto 0;" class="panel panel-default">
        <div class="panel-body">
            <img src="/img/kfl100.png" style="height: 70px; margin: 0 auto; display: block"><br>
            <h4 style="text-align: center">Reset your password</h4>

            <p>Enter your email address and we will send you a link to reset your password.</p>
            <form action="/login/sendReset" method="post">
                <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                <input type="text" class="form-control input-block" autofocus="autofocus" name="email" placeholder="Enter your email address">
                <input type="submit" class="btn btn-primary btn-block" value="Send password reset email">
            </form>
            <result :field="result"></result>
        </div>
    </div>

    <?php include_footer(); ?>
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