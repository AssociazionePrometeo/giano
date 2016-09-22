<?php
session_start();

if ( !isset($_SESSION) || !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

header('Location: index_user.php');
?>
