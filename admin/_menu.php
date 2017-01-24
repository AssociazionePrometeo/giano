<?php

if (session_status() == PHP_SESSION_NONE) {session_start();}

require_once '../function/database.php';
require_once '../function/Auth.php';
require_once '../function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

if (!$auth->isLogged()) {
  header('Location: ../login.php');
  exit();
}

try {
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // SELECT insert_users, permissions, insert_devices,insert_tags FROM permissions WHERE id=?
  $row = $dbh->prepare('SELECT insert_users, permissions, insert_devices,insert_tags FROM permissions WHERE id=?');
  $row->execute(array($_SESSION['user_level']));
  $data = $row->fetch(PDO::FETCH_ASSOC);
  #error_log("aa". implode("|",$data));
}
catch(Exception $e) {
  echo 'Exception -> ';
  var_dump($e->getMessage());
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
            <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home"></span>Giano</a>
        </div>
<!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbar">
             <ul class="nav navbar-nav">
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Utenti<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop1">
                        <li><a href="list_user.php">Lista Utenti</a></li>
                        <?php
                          if($data['insert_users'] == 1)  echo '<li><a href="manage_user.php">Aggiungi Utente</a></li>';
                          echo '<li role="separator" class="divider"></li>';
                          if($data['permissions'] == 1)  echo '<li><a href="list_profile.php">Gestione Profili</a></li>';
                        ?>
                        <li><a href="#"></a></li>
                    </ul>
                </li>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Devices<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop2">
                        <li><a href="list_device.php">Lista Devices</a></li>
                        <?php
                    if($data['insert_devices'] == 1)  echo '<li><a href="create_device.php">Aggiungi Devices</a></li>';
                  ?>
                     </ul>
                </li>
                <li class="dropdown"> <a href="#" class="dropdown-toggle" id="drop3" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Tags<span class="caret"></span> </a>
                    <ul class="dropdown-menu" aria-labelledby="drop3">
                        <li><a href="list_tag.php">Lista Tags</a></li>

                        <?php
                    if($data['insert_tags'] == 1)  echo '<li><a href="create_tag.php">Aggiungi Tags</a></li>';
                  ?>
                    </ul>
                </li>
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
