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

$ins_tags = false;
$del_tags = false;
$dbh = Database::connect();
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM users a INNER JOIN type_user b on a.id = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.id = ?';
$q = $dbh->prepare($sql);
$q->execute(array($uid));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_tags'] == 1)  $ins_tags_permission = true;
if($data['delete_tags'] == 1)  $del_tags_permission = true;

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
           $sql = 'SELECT * FROM tags ORDER BY id DESC';
           foreach ($dbh->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['cardcode'] . '</td>';
            $sql1 = 'SELECT first_name FROM users WHERE id=?';
            $q = $dbh->prepare($sql1);
            $q->execute(array($row['id']));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            echo '<td>'.$data['first_name'].'</td>';
               if ($row['status'] == 1){
                    echo '<td>Abilitato</td>';
               }else{
                   echo '<td>Disabilitato</td>';
               }
                    echo '<td><a class="btn btn-success';
                    if (!$ins_tags_permission) {echo ' disabled';}
                    echo '" href="update_tag.php?id='.$row['id'].'">Update</a>';
                    echo '&nbsp;';
                    echo '<button type="button" class="btn btn-danger"';
                    if (!$del_tags_permission) echo ' disabled';
                    echo ' data-toggle="modal" data-target="#confirm-delete" data-href="delete_tag.php?id=' . $row['id'];
                    echo '">Delete</button></td>';
                    echo '</tr>';
           }
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
