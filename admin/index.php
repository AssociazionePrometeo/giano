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
    exit;
}
//include '_header.php';
include '_menu.php';
?>
<div class="container">
   <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Riepilogo dell'admin</h1>
            <p>tabella riepilogativa con numero utenti, numero device, numero tag, ultimi accessi, e segnalazione tag bloccati da utenti (smarriti o altro)</p>
        </div>
    </div>
</div>

<?php
include('_footer.php');
?>
