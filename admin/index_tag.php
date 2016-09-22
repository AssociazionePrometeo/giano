<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

include '_header.php';
include '_menu.php';

?>


<div class="container">
    <div class="row">
        <h3>Gestione Tag</h3>
    </div>
    <p>
        <a href="create_tag.php" class="btn btn-success">Crea nuovo</a>
    </p>

    <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Card Code</th>
              <th>Utente</th>
              <th>Status</th>
              <th>Action</th>    
            </tr>
          </thead>
          <tbody>
          <?php
           include '../function/database.php';
           $pdo = Database::connect();
           $sql = 'SELECT * FROM tags ORDER BY id DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['cardcode'] . '</td>';
                    echo '<td>'. $row['userid'] . '</td>';
                    echo '<td>'. $row['status'] . '</td>';
                    echo '<td><a class="btn btn-success" href="update_tag.php?id='.$row['id'].'">Update</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="delete_tag.php?id='.$row['id'].'">Delete</a></td>';
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
