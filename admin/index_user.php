<?php
session_start();
if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
    exit;
}

include '_header.php';
include '_menu.php';

?>

<div class="container">
    <div class="row">
        <h3>Gestione Utenti</h3>
    </div>
    <p>
        <a href="create_user.php" class="btn btn-success">Crea nuovo</a>
    </p>

    <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Name</th>
              <th>Info</th>
              <th>Username</th>
              <th>Email Address</th>
              <th>Level</th>
              <th>Numero Telefono</th>
              <th>Data Iscrizione</th>
              <th>Data Scadenza</th>
              <th>Ultimo accesso (WEB)</th>
              <th>Action</th>    
            </tr>
          </thead>
          <tbody>
          <?php
           include '../function/database.php';
           $pdo = Database::connect();
           $sql = 'SELECT * FROM users ORDER BY userid DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['userid']. '</td>';
                    echo '<td>'. $row['first_name'] . '</td>';
                    echo '<td>'. $row['info'] . '</td>';
                    echo '<td>'. $row['username'] . '</td>';
                    echo '<td>'. $row['email_address'] . '</td>';
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql2 = 'SELECT name FROM permissions WHERE id=?';
                    $q = $pdo->prepare($sql2);
                    $q->execute(array($row['user_level']));
                    $data = $q->fetch(PDO::FETCH_ASSOC);
                    echo '<td>'.$data['name'].'</td>';
                    Database::disconnect();
                    echo '<td>'. $row['mobile_number'] . '</td>';
                    echo '<td>'. $row['signup_date'] . '</td>';
                    echo '<td>'. $row['end_date'] . '</td>';
                    echo '<td>'. $row['last_login'] . '</td>';
                    echo '<td><a class="btn btn-success" href="update_user.php?id='.$row['userid'].'">Update</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="delete_user.php?id='.$row['userid'].'">Delete</a></td>';
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
