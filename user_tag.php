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
        <h3>Disattivazione Tag</h3>
    </div>
    <p>
     <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Card Code</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
           include 'function/database.php';
           $pdo = Database::connect();
           $sql = 'SELECT * FROM tags WHERE userid = '.$_SESSION["ID"].' ORDER BY id DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['cardcode'] . '</td>';
                    //echo '<td>'. $row['userid'] . '</td>';
                if ($row['status'] == 1){
                  echo '<td>Attivato</td>';
                  echo '<td><a class="btn btn-danger" href="disable_tag.php?id='.$row['id'].'">Disattiva!</a></td>';
                }else{
                    echo '<td>Disattivato</td>';
                    echo '<td><p class="bg-danger">Il TAG disattivato può essere riattivato solo da un amministratore</p></td>';
                }


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
