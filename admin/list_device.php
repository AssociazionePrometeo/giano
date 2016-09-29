<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

//include '_header.php';
include '_menu.php';
//include '../function/database.php';
?>


<div class="container">
    <div class="row">
        <h3>Gestione Device</h3>
    </div>
    <p>
        <a href="create_device.php" class="btn btn-success">Crea nuovo</a>
    </p>

    <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Name</th>
              <th>Active</th>
              <th>Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
           $pdo = Database::connect();
           $sql = 'SELECT * FROM devices ORDER BY id DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['name'] . '</td>';
                    echo '<td>'. $row['active'] . '</td>';
                    echo '<td>'. $row['type'] . '</td>';
                    echo '<td><a class="btn btn-success" href="update_device.php?id='.$row['id'].'">Update</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="delete_device.php?id='.$row['id'].'">Delete</a></td>';
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
