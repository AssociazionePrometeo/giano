<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}

require_once 'function/database.php';
require_once 'function/Auth.php';
require_once 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

if (!$auth->isLogged()) {
  header('Location: login.php');
  exit();
}

include '_header.php';
include '_menu.php';

if ( !empty($_GET)) {
    // keep track validation errors
    $idError = null;
    $useridError = null;
    $actionError = null;

    // keep track post values
    $id = $_GET['id'];
    $userid = $auth->getSessionUID($_COOKIE[$config->cookie_name]);
    $action = $_GET['a'];

    // validate input
    $valid = TRUE;

    if (empty($id)) {
        $idError = 'Please enter ID';
        $valid = FALSE;
    }

    if (empty($userid)) {
        $useridError = 'Please enter UserID';
        $valid = FALSE;
    }

    if ($action != "1" && $action != "0") {
        $actionError = 'Please enter Tag Action';
        $valid = FALSE;
    }

    $status = ($action == "1") ? "1" : "0";

    // update data
    if ($valid) {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '';
        if ($_SESSION['user_level'] > 3) {
            $sql = "UPDATE tags  set status =? WHERE id = ? AND userid = ?";
            $q = $dbh->prepare($sql);
            $q->execute(array($status,$id,$userid));
        }
        else {
          $sql = "UPDATE tags  set status =? WHERE id = ?";
          $q = $dbh->prepare($sql);
          $q->execute(array($status,$id));
        }
        header("Location: user_tag.php");
    }
    $dbh=Database::disconnect();
}
header('Location: user_tag.php');
?>
