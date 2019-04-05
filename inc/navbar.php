<div class="wrapper">
<nav class="navbar navbar-default" id="topbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo HTTP_ROOT; ?>index.php" style="padding: 0 10px"><img src="<?php echo HTTP_ROOT; ?>img/kfl100.png" style="height: 50px; margin-top: 5px"></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo HTTP_ROOT; ?>index.php">HIV/Hep-C Data Collection Portal</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" onclick="$('#topbar').hide()">Hide</a></li>
                <li><a href="<?php echo HTTP_ROOT; ?>login.php?logout">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container" id="main">
    <div class="row">
        <div id="errorlog"></div>