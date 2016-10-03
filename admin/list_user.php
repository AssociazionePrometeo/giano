<?php
session_start();
if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
    exit;
}
//include '_header.php';
include '_menu.php';
// require '../function/database.php';
$ins_users = false;
$del_users = false;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM users a INNER JOIN type_user b on a.userid = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.userid = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['ID']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_users'] == 1)  $ins_users = true;
if($data['delete_users'] == 1)  $del_users = true;
Database::disconnect();
?>

<div class="container">
    <div class="row">
        <h3>Gestione Utenti</h3>
    </div>
    <?php
      echo'<p><a href="create_user.php" class="btn btn-success';
      if (!$ins_users) echo ' disabled' ;
      echo '">Crea nuovo</a></p>';
    ?>
    <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Name</th>
              <th>Info</th>
              <th>Username</th>
              <th>Email Address</th>
              <th>User Level</th>
              <th>Numero Telefono</th>
              <th>Data Iscrizione</th>
              <th>Data Scadenza</th>
              <th>Ultimo accesso (WEB)</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
           $pdo = Database::connect();
           $sql = 'SELECT * FROM users join type_user where users.user_level=type_user.id ORDER BY userid DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['userid']. '</td>';
                    echo '<td>'. $row['first_name'] . '</td>';
                    echo '<td>'. $row['info'] . '</td>';
                    echo '<td>'. $row['username'] . '</td>';
                    echo '<td>'. $row['email_address'] . '</td>';
                    echo '<td>'. $row['level'].'</td>';
                    echo '<td>'. $row['mobile_number'] . '</td>';
                    echo '<td>'. $row['signup_date'] . '</td>';
                    echo '<td>'. $row['end_date'] . '</td>';
                    echo '<td>'. $row['last_login'] . '</td>';
                    echo '<td><a class="btn btn-success';
                    if (!$ins_users) {echo ' disabled';}
                    echo '" href="update_user.php?id='.$row['userid'].'">Update</a>';
                    echo '&nbsp;';
                    echo '<a class="btn btn-danger';
                    if (!$del_users) echo ' disabled';
                    echo '" href="delete_user.php?id='.$row['userid'].'">Delete</a></td>';
                    echo '</tr>';
           }
           Database::disconnect();
          ?>
          </tbody>
    </table>
    </div>
</div> <!-- /container -->

<?php
    include('_footer.php');
?>
