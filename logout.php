<?
if (session_status() == PHP_SESSION_NONE) {session_start();}
$_SESSION = array();
//session_destroy;
 $_SESSION["message"] = '<p class="bg-success">Logout eseguito</p>';
include 'index.php';
?>
