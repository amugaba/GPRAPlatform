<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Reports</div>
    <p>No reports have been configured for this project yet.</p>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main'
        });
    </script>
</body>
</html>