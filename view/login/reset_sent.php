<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeaderNoNav(); ?>

    <div class="panel float-center">
        <div class="pageTitle" style="margin-top: 0">Reset email sent</div>
        <p>Check your email for a link to reset your password. If it doesn't appear within a few minutes, check your spam folder.</p>
        <div style="text-align: center; margin: 10px 0 0">
            <a href="/login/">Return to Login</a>
        </div>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
</body>
</html>