<?php
/* Check User Script */
if (session_status() == PHP_SESSION_NONE) {session_start();}

$loader = require __DIR__ . '/vendor/autoload.php';
require 'function/database.php';
require 'function/Auth.php';
require 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

try {
  // Convert to simple variables
  $username = $_POST['username'];
  $password = $_POST['password'];

  if((!$username) || (!$password)){
    $_SESSION["message"] = '<p class="bg-danger">Compila entrambi i campi! </p>';
    include 'index.php';
    exit();
  }

  $return = $auth->login($username,$password);

  if ($return['error']) {
    $_SESSION["message"] = '<p class="bg-danger">' . $return['message'] . '</p>';
    header("Location: login.php");
    exit();
  }
  $dbh = Database::disconnect();

  setcookie($config->cookie_name,$return['hash'],$return['expire']);
  $_SESSION["email"] = $username;
  $_SESSION['user_level'] = $auth->getSessionUserLevel($return['hash']);
  header("Location: index.php");
}
catch(Exception $e) {
    echo 'Exception -> ';
    var_dump($e->getMessage());
}


?>
