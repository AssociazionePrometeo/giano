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

try {
  include '_header.php';
  include '_menu.php';

  $ins_users_permission = false;
  $del_users_permission = false;

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT * FROM users a INNER JOIN type_user b on a.id = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.id = ?';
  $q = $dbh->prepare($sql);
  $q->execute(array($uid));
  $data = $q->fetch(PDO::FETCH_ASSOC);
  if($data['insert_users'] == 1)  $ins_users_permission = true;
  if($data['delete_users'] == 1)  $del_users_permission = true;
}
catch (Exception $e) {
  echo 'Exception -> ';
  var_dump($e->getMessage());
}

?>

<div class="container">
    <div class="row">
        <h3>Gestione Utenti</h3>
    </div>
    <?php
      echo'<p><a href="manage_user.php" class="btn btn-success';
      if (!$ins_users_permission) echo ' disabled' ;
      echo '">Crea nuovo</a></p>';
    ?>
    <div class="table-responsive row">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Nome</th>
              <th>Email</th>
              <th>User Level</th>
              <th>Numero Telefono</th>
              <th>Data Iscrizione</th>
              <th>Data Scadenza</th>
              <th>Ultimo accesso (WEB)</th>
              <th>Stato</th>
              <th>Info</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
           $sql = 'SELECT u.id, u.first_name, u.email, u.info, u.mobile_number, u.signup_date, u.end_date, u.last_login, u.isactive, t.level, u.isactive
           FROM users u join type_user t where u.user_level=t.id ORDER BY u.id DESC';
           foreach ($dbh->query($sql) as $row) {
                    echo '<tr>';
                    echo '<td>#' .$row['id']. '</td>';
                    echo '<td>'. $row['first_name'] . '</td>';
                    echo '<td>'. $row['email'] . '</td>';
                    echo '<td>'. $row['level'].'</td>';
                    echo '<td>'. $row['mobile_number'] . '</td>';
                    echo '<td>'. $row['signup_date'] . '</td>';
                    echo '<td>'. $row['end_date'] . '</td>';
                    echo '<td>'. $row['last_login'] . '</td>';
                    if ($row['isactive']=='1') {
                        echo '<td>attivo</td>';
                    }else{echo '<td>disattivato</td>';}
                    echo '<td>'. $row['info'] . '</td>';
                    echo '<td><a class="btn btn-success';
                    if (!$ins_users_permission) {echo ' disabled';}
                    echo '" href="manage_user.php?a=update&amp;id='.$row['id'].'">Update</a>';
                    echo '&nbsp;';
                    echo '<button type="button" class="btn btn-danger"';
                    if (!$del_users_permission) echo ' disabled';
                    echo ' data-toggle="modal" data-target="#confirm-delete" data-href="remove_user.php?id=' . $row['id'];
                    echo '">Delete</button></td>';
                    echo '</tr>';
           }
          ?>
          <div class="modal fade" id="confirm-delete" role="dialog" aria-labelledby="mydeleteModal" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          Delete Utente
                      </div>
                      <!--div class="modal-body">
                          Are you sure?
                      </div-->
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
</div> <!-- /container -->

<script type="text/javascript">// <![CDATA[
$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});// ]]>
</script>

<?php
    include('_footer.php');
?>
