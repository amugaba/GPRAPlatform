<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeaderNoNav(); ?>

    <div class="panel float-center">
        <div class="pageTitle" style="margin-top: 0">Enter a new password</div>

        <p>Password must be at least 8 characters long and have an uppercase letter, a lowercase letter, a number, and a symbol.</p>
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