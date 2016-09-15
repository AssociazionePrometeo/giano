<?
include '../include/config.inc.php';
?>
<!DOCTYPE html>
<!-- Template by Quackit.com -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>OpenDoorman Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <link href="../css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Logo and responsive toggle -->
        <div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<a class="navbar-brand" href="/">
    <span class="glyphicon glyphicon-home"></span> Doorkeeper
</a>
</div>
<!-- Navbar links -->
<div class="collapse navbar-collapse" id="navbar">
    <ul class="nav navbar-nav">
        <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utenti<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1">
                <li><a href="?a=users">Gestisci Utenti</a></li>
                <li><a href="?a=users&u=add">Aggiungi Utente</a></li>
            </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Devices<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1">
                <li><a href="?a=devices">Gestisci Devices</a></li>
                <li><a href="?a=devices&u=add">Aggiungi Device</a></li>
            </ul>
        </li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TAG<span class="caret"></span> </a>
            <ul class="dropdown-menu" aria-labelledby="drop1">
                <li><a href="?a=tags">Gestisci Tags</a></li>
                <li><a href="?a=tags&u=add">Aggiungi Tag</a></li>
            </ul>
        </li>
        <li>
            <a href="?a=log">Log accessi</a>
        </li>
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
