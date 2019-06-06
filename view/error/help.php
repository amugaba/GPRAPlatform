<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Feedback/Issues</div>
    <p>Please use this form to provide feedback and/or report issues back to the application development team.</p>

    <form method="post" action="/error/sendFeedback">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <textarea id="message" name="message" rows="6" class="form-control" required placeholder="Enter message here..."></textarea>
        <br>
        <input type="submit" class="btn btn-primary" value="Send">
    </form>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>
    <script type="application/javascript">
        vue = new Vue({
            el: '#main'
        });
    </script>
</body>
</html>