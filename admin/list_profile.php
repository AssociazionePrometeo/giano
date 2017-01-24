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

$uid = $auth->getSessionUID($_COOKIE['ID']);

include '_header.php';
include '_menu.php';

$valid = null;
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT permissions FROM permissions WHERE id=?';
$q = $dbh->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['permissions'] == 1){
    $valid = true;
}else{
    header('Location: ../login.php');
}

if($valid){
?>
    <div class="container">
        <div class="row">
            <h3>Gestione Profili utente</h3>
        </div>


        <div class="table-responsive row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID #</th>
                        <th>Livello</th>
                        <th>Gestione Profili</th>
                        <th>Aggiungere Utenti</th>
                        <th>Rimuovere Utenti</th>
                        <th>Aggiungere Tag</th>
                        <th>Rimuovere Tag</th>
                        <th>Aggiungere Device</th>
                        <th>Rimuovere Device</th>
                        <th>Aggiungere Prenotazioni</th>
                        <th>Rimuovere Prenotazioni</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

           $sql = 'SELECT * FROM permissions ORDER BY id DESC';
           foreach ($dbh->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#'. $row['id'] . '</td>';
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = 'SELECT level FROM type_user WHERE id=?';
            $q = $dbh->prepare($sql1);
            $q->execute(array($row['type_user']));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            echo '<td>'. $data['level'] . '</td>';
                    echo '<td>'. $row['permissions'] . '</td>';
                    echo '<td>'. $row['insert_users'] . '</td>';
                    echo '<td>'. $row['delete_users'] . '</td>';
                    echo '<td>'. $row['insert_tags'] . '</td>';
                    echo '<td>'. $row['delete_tags'] . '</td>';
                    echo '<td>'. $row['insert_devices'] . '</td>';
                    echo '<td>'. $row['delete_devices'] . '</td>';
                    echo '<td>'. $row['insert_reservation'] . '</td>';
                    echo '<td>'. $row['delete_reservation'] . '</td>';
                    echo '<td>action</td>';
                    echo '</tr>';
           }
          ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /container -->

    <?php
    include('_footer.php');
}
?>
