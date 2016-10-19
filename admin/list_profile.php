<?php
session_start();
if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

//include '_header.php';
include '_menu.php';
//include '../function/database.php';

$valid = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT permissions FROM permissions WHERE id=?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['permissions'] == 1){
    $valid = true;
}else{
    header('Location: index.php');
}
Database::disconnect();

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
           $pdo = Database::connect();
           $sql = 'SELECT * FROM permissions ORDER BY id DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#'. $row['id'] . '</td>';
                  $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = 'SELECT level FROM type_user WHERE id=?';
            $q = $pdo->prepare($sql1);
            $q->execute(array($row['type_user']));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            echo '<td>'. $data['level'] . '</td>';
            Database::disconnect();
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
           Database::disconnect();
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
