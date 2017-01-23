<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}

$loader = require __DIR__ . '/vendor/autoload.php';
require 'function/database.php';
require 'function/Auth.php';
require 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

if (isset($_COOKIE['ID']) && $auth->logout($_COOKIE['ID'])) {
  $_SESSION["message"] = '<p class="bg-success">Logout eseguito</p>';
  include 'login.php';
  session_destroy();
}
$dbh = Database::disconnect();
?>
