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
else {
    include ("_header.php");
    include ("_menu.php");
}
$dbh = Database::disconnect();

if ($_SESSION['user_level'] >= 3) {
    error_log("user_level ". $_SESSION['user_level'],0);
    session_destroy();
    header('Location: ../login.php');
    exit;
}

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
