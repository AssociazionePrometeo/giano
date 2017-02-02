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
  $username = '';
  $password = '';
  $repeatpassword = '';

  if (isset($_POST['remail']) && $_POST['remail']!='') $username = trim($_POST['remail']);
  if (isset($_POST['rpass']) && $_POST['rpass']!='') $password = trim($_POST['rpass']);
  if (isset($_POST['rptpass']) && $_POST['rptpass']!='')  $repeatpassword = trim($_POST['rptpass']);
  error_log("1".$username . "|".$password . "|".$repeatpassword);

  if($repeatpassword=='' || $username=='' || $password=='') {
    $_SESSION["message"] = '<p class="bg-danger">Compila tutti i campi! </p>';
    header ('Location: register.php');
    return;
  }

  $return = $auth->register($username,$password,$repeatpassword);
  error_log("1_1 ".$username . "|".$password . "|".$repeatpassword);

  if ($return['error']) {
    error_log("1_1_2");
    $_SESSION["message"] = '<p class="bg-danger">' . $return['message'] . '</p>';
    header("Location: register.php");
    return;
  }

error_log("2");

  $return = '';
  $return = $auth->login($username,$password);
error_log("3");

  if ($return['error']) {
    $_SESSION["message"] = '<p class="bg-danger">' . $return['message'] . '</p>';
    header("Location: login.php");
    error_log("3_1");
  }
error_log("4");
  setcookie($config->cookie_name,$return['hash'],$return['expire']);
  $_SESSION["email"] = $username;
  $_SESSION['user_level'] = $auth->getSessionUserLevel($return['hash']);

  $dbh = Database::disconnect();

  header("Location: index.php");
}
catch(\Exception $e) {
    echo 'Exception -> ';
    var_dump($e->getMessage());
}


?>
