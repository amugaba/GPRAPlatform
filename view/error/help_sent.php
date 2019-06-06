<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Feedback/Issues</div>
    <p>Thank you! Your feedback/issue has been received.</p>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main'
        });
    </script>
</body>
</html>