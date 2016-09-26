<?php
session_start();

if ( !isset($_SESSION) || !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['user_level'] >= 3) {
    error_log("user_level ". $_SESSION['user_level'],0);
    session_destroy();
    header('Location: ../login.php');
}
header('Location: index_user.php');
?>
