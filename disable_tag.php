<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: login.php');
}

include '_header.php';
include '_menu.php';

?>

<?php
    require 'function/database.php';
      
    if ( !empty($_GET)) {
        // keep track validation errors
        $idError = null;
        $useridError = null;
        
        // keep track post values
        $id = $_GET['id'];
        $userid = $_SESSION["ID"];
        $status = "0"; 
        
        // validate input
        $valid = true;
        if (empty($id)) {
            $idError = 'Please enter ID';
            $valid = false;
        }
         
        if (empty($userid)) {
            $useridError = 'Please enter UserID';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tags  set status =? WHERE id = ? AND userid = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($status,$id,$userid));
            Database::disconnect();
            header("Location: user_tag.php");
        }
    } else {
      header('Location: index.php');
    }
?>

<?php
    include('_footer.php');
?>
