<div id="wrapper">
<nav class="navbar navbar-expand navbar-dark bg-dark" id="topbar">
    <a class="navbar-brand" href="<?php echo HTTP_ROOT; ?>">
        <?php echo Session::getGrant() == null ? 'GPRA Data Collection Portal' : Session::getGrant()->name . ' (' . Session::getGrant()->grantno .')'; ?>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="https://example.com" id="navdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    User: <?php echo Session::getUser()->name; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navdropdown">
                    <a class="dropdown-item" href="/login/logout">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div id="overlay-box" class="overlay-box">
    <div style="display: table-cell; vertical-align: middle">
        <img id="overlay-success" src="<?php echo HTTP_ROOT ?>/img/checkmark.png">
        <img id="overlay-error" src="<?php echo HTTP_ROOT ?>/img/redx.png">
        <span id="overlay-message"></span>
    </div>
</div>

    <?php
    $path = request()->getUrl()->getPath();
    if(substr($path, -strlen('index/')) == 'index/') {
        $path = substr($path, 0, -strlen('index/'));
    }

    $home_css = ($path == '/' || $path == '/home/') ? 'active' : '';
    $client_css = ($path == '/home/client/') ? 'active' : '';
    //$reports_css = ($path == '/reports/') ? 'active' : '';
    ?>

<div class="container-fluid">
    <div class="row" >
        <nav class="col-md-3 col-lg-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= $home_css ?>" href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            Dashboard

                        </a>
                    </li>
                    <?php if($this->client == null) { ?>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                Client
                            </a>
                        </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $client_css ?>" href="/home/client?id=<?= $this->client->id ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            Client: <?= $this->client->uid ?>
                        </a>
                    </li>
                    <?php }
                    if($this->assessment == null) { ?>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            Assessment
                        </a>
                    </li>
                    <?php } ?>

                    <?php $this->includeSidebarSections(); ?>

                    <?php if(Session::getUser()->admin == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/report">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            Reports
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>

        <div id="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" <?php if(!DEBUG) echo 'v-cloak'; ?>>
            <div id="errorlog"></div>