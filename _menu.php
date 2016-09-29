<?php

if ( !isset($_SESSION["ID"] ) ) {
    header('Location: ../login.php');
}

?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Logo and responsive toggle -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false"></button>
            <a class="navbar-brand" href="/">
                <span class="glyphicon glyphicon-home"></span> Giano
            </a>
        </div>
<!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                        <li class="active"><a href="user_tag.php">Gestione TAG</a></li>
                        <li><a href="index.php?a=log">Log</a></li>
            </ul>
    <!-- Menu right -->
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ( isset($_SESSION)  && $_SESSION['user_level'] < 3) {
                echo '
                <li>
                    <a href="admin/">
                    <button type="button" class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-cog"></span> Admin
                    </button></a>
                </li>
                
                ';    
                } ?>
                <li>
                    <a href="profile.php">
                        <button type="button" class="btn btn-primary btn-sm">
                            <span class="glyphicon glyphicon-user"></span> Profile
                        </button>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
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
