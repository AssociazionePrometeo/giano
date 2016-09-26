<?php

if ( !isset($_SESSION["ID"] ) ) {
    header('Location: ../login.php');
    exit;
}
if ($_SESSION['user_level'] > 3) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Logo and responsive toggle -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <span class="glyphicon glyphicon-home"></span> Giano
            </a>
        </div>
<!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                        <li class="active"><a href="index_user.php?op=">Gestisci Utenti</a></li>
                        <li><a href="index_device.php?op=">Gestisci Devices</a></li>
                        <li><a href="index_tag.php?op=">Gestisci Tags</a></li>
            </ul>
    <!-- Menu right -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="index.php">
                    <button type="button" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-cog"></span> Admin
                    </button></a>
                </li>
                <li>
                    <a href="/profile.php">
                    <button type="button" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-user"></span> Profile
                    </button></a>
                </li>
                <li>
                    <a href="/logout.php">
                    <button type="button" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-log-in"></span> Logout
                        </button>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
