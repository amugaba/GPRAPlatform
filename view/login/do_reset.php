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
            <h4 style="text-align: center">Enter a new password</h4>

            <p>Password must be at least 8 characters long.</p>
            <form action="/login/changePassword" method="post">
                <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                <input type="hidden" name="id" value="<?= input('id'); ?>">
                <input type="hidden" name="code" value="<?= input('code'); ?>">

                <label>Password</label>
                <input autofocus="autofocus" class="form-control input-block" id="password" name="password" value="" type="password">
                <label>Confirm password</label>
                <input class="form-control input-block" id="password_confirmation" name="password_confirmation" value="" type="password">
                <input class="btn btn-primary btn-block" name="commit" tabindex="3" value="Change password" type="submit">
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