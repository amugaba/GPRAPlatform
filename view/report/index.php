<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Reports</div>
    <h4><a href="/report/export">Export GPRA for Upload to SPARS</a></h4>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main'
        });
    </script>
</body>
</html>