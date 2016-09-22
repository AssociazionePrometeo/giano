<?php

if ( !isset($_SESSION) || !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
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
        <!--li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utenti<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1"-->
                <li class="active"><a href="index_user.php?op=">Gestisci Utenti</a></li>
                <!--li><a href="index_user.php?op=add">Aggiungi Utente</a></li>
            </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Devices<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1"!-->
                <li><a href="index_device.php?op=">Gestisci Devices</a></li>
                <!--li><a href="index_device.php?op=add">Gestisci Device</a></li>
            </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TAG<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1"!-->
                <li><a href="index_tag.php?op=">Gestisci Tags</a></li>
                <!--li><a href="index_tag.php?op=add">Aggiungi Tag</a></li>
            </ul>
        </li>
        <li>
            <a href="?a=log">Log accessi</a>
        </li !-->
    </ul>
    <!-- Search -->

            <div class="navbar-form navbar-right" >
					 <ul class="nav navbar-nav">
                         <?

                         if($_SESSION['user_level'] ==0) {
                           echo'<a href="/admin"><button type="button" class="btn btn-warning btn-sm">Admin</button></a>';
                         }
                         if($_SESSION['user_level'] ==0) {
                           echo'<a href="/profile.php"> <button type="button" class="btn btn-primary btn-sm">Profilo</button></a>';
                                                }
                         ?>
                  <a href="/logout.php"> <button type="button" class="btn btn-primary btn-sm">Logout</button></a>
                </ul>

				</div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
