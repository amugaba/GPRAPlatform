<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Assessment Completed</div>
    <div style="text-align: center; font-size: 14pt; margin-top: 30px">
        <a href="/">Return Home</a> or <a href="/home/client?id=<?=$this->client->id?>">Return to Client</a>
    </div>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main',
            data: {
            }
        });
    </script>
</body>
</html>