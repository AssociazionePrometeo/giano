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
  $valid = null;
  $del_users_permission = '';
  $dbh = Database::connect();
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT * FROM users a INNER JOIN type_user b on a.id = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.id = ?';
  $q = $dbh->prepare($sql);
  $uid = $auth->getSessionUID($_COOKIE['ID']);
  $q->execute(array($uid));
  $data = $q->fetch(PDO::FETCH_ASSOC);

  if($data['delete_users'] == 1)  {
    $del_users_permission = true;
    $valid = true;
  }
  else{
      header('Location: list_user.php');
  }

  if ( !empty($_GET)) {
      // keep track post values
      $id = $_GET['id'];
      if ($del_users_permission) {
        // delete data
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM users  WHERE id = ?";
        $q = $dbh->prepare($sql);
        $q->execute(array($id));
      }
  }
  header("Location: list_user.php");
}
catch (Exception $e) {
  echo 'Exception -> ';
  var_dump($e->getMessage());
}
?>
