<!DOCTYPE html>
<html lang="en">
<head>
    <title>GPRA Platform</title>
    <?php include_styles(); ?>
</head>
<body>
    <?php include_header(); ?>

    <div style="text-align: center; font-size: 14pt; margin-top: 30px">
        <h4>The GPRA assessment is complete.</h4>
        <a href="/">Return Home</a> or <a href="/home/client?id=<?=$this->id?>">Return to Client</a>
    </div>

    <?php include_footer(); ?>
    <?php include_js(); ?>
</body>
</html>