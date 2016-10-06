<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}
require '../function/database.php';
$valid = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM users a INNER JOIN type_user b on a.userid = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.userid = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['ID']));
$data = $q->fetch(PDO::FETCH_ASSOC);

if($data['delete_users'] == 1)  $del_users = true;

if($data['delete_users'] == 1){
    $valid = true;
}else{
    header('Location: index_user.php');
}
Database::disconnect();

if($valid){
    if ( !empty($_GET)) {
        // keep track post values
        $id = $_GET['id'];

        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM users  WHERE userid = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: list_user.php");
    }
}
else
  header("Location: list_user.php");
?>
