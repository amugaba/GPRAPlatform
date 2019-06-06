<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">An error has occurred</div>
    <p>There is a problem with the page you are trying to use.</p>
    <p><a href="/error/help">Please click here to send a message to the application development team, describing your issue.</a></p>
    <p>Or <a href="/home">click here to return to the home page.</a></p>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main'
        });
    </script>
</body>
</html>