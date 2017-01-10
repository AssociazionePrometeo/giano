<?php
session_start();
if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}
//include '_header.php';
include '_menu.php';
//include '../function/database.php';
$ins_tags = false;
$del_tags = false;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM users a INNER JOIN type_user b on a.userid = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.userid = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['ID']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_tags'] == 1)  $ins_tags = true;
if($data['delete_tags'] == 1)  $del_tags = true;
Database::disconnect();
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
           $pdo = Database::connect();
           $sql = 'SELECT * FROM tags ORDER BY id DESC';
           foreach ($pdo->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['cardcode'] . '</td>';
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = 'SELECT first_name FROM users WHERE userid=?';
            $q = $pdo->prepare($sql1);
            $q->execute(array($row['userid']));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            echo '<td>'.$data['first_name'].'</td>';
            Database::disconnect();
               if ($row['status'] == 1){
                    echo '<td>Abilitato</td>';
               }else{
                   echo '<td>Disabilitato</td>';
               }
                    echo '<td><a class="btn btn-success';
                    if (!$ins_tags) {echo ' disabled';}
                    echo '" href="update_tag.php?id='.$row['userid'].'">Update</a>';
                    echo '&nbsp;';
                    echo '<button type="button" class="btn btn-danger"';
                    if (!$del_tags) echo ' disabled';
                    echo ' data-toggle="modal" data-target="#confirm-delete" data-href="delete_tag.php?id=' . $row['userid'];
                    echo '">Delete</button></td>';
                    echo '</tr>';
           }
           Database::disconnect();
          ?>
                      <div class="modal fade" id="confirm-delete" role="dialog" aria-labelledby="mydeleteModal" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          Eliminazione tag
                      </div>
                          <div class="modal-footer">
                          <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                          <a class="btn btn-danger btn-ok">Delete</a>
                      </div>
                  </div>
              </div>
          </div>
                </tbody>
            </table>
        </div>
    </div><!-- /container -->

    <script type="text/javascript">// <![CDATA[
        $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });// ]]>
    </script>

    <?php
    include('_footer.php');
?>
