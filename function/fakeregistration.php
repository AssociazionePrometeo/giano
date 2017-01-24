<?php
/* Check User Script */
if (session_status() == PHP_SESSION_NONE) {session_start();}

$loader = require_once  '../vendor/autoload.php';
require_once 'database.php';
require_once 'Auth.php';
require_once 'Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

try {
  // TEST FAKE REGISTRATION
  $pass = "qazxsw@123!";
  $return = $auth->register("admin@test.net",$pass,$pass);
  print_r($return);

  $return = $auth->register("admin@test1.net",$pass,$pass);
  print_r($return);

  $return = $auth->register("admin@test2.net",$pass,$pass);
  print_r($return);


  $return = $auth->login("admin@test.net",$pass);
  print_r($return);
}
catch(Exception $e) {
  echo 'Exception -> ';
  var_dump($e->getMessage());
}
?>
