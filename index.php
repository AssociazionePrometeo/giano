<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}

$loader = require __DIR__ . '/vendor/autoload.php';
require 'function/database.php';
require 'function/Auth.php';
require 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");


if (!$auth->isLogged()) {
    header('Location: login.php');
}
else {
    include ("_header.php");
    include ("_menu.php");
}
$dbh = Database::disconnect();
?>

<div class="container">
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">titolone
                <small>titolino</small>
            </h1>
            <p>qui ci metto qualocosa </p>
        </div>
    </div>
</div>
<?
    include('_footer.php');
?>
