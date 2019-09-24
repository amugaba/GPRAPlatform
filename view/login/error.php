<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>

    <?php $this->includeHeaderNoNav(); ?>

    <div class="panel float-center">
        <div class="pageTitle" style="margin-top: 0">An error has occurred</div>

        <p>Please contact the system administrator for assistance. Thank you for your patience.</p>

        <div style="text-align: center; margin: 10px 0 0">
            <a href="/login">Return to Login</a>
        </div>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
        }
    })
</script>
</body>
</html>