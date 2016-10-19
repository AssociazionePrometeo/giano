<?php
if (session_status() == PHP_SESSION_NONE) {session_start();}
if (!isset($_SESSION["ID"]) ) {
    header('Location: login.php');
} 
else {
    include ("_header.php");
    include ("_menu.php");
}
?>

<div class="container">
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">titolone
                <small>titolino</small>
            </h1>
            <p>qui ci metto qualocosa </p>
        </div>
    </div>
</div>
<?
    include('_footer.php');
?>
