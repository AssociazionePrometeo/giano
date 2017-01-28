<?php
/* Check User Script */
if (session_status() == PHP_SESSION_NONE) {session_start();}

require_once 'function/database.php';
require_once 'function/Auth.php';
require_once 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

if (!$auth->isLogged()) {
  header('Location: login.php');
  exit();
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
                            <th>User</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
          try {
            $uid = $auth->getSessionUID($_COOKIE[$config->cookie_name]);
            if ($_SESSION['user_level'] < 3) {
              $sql = 'SELECT t.id,t.cardcode, u.email as userid, t.status FROM tags t INNER JOIN users u ON t.userid = u.id ORDER BY t.id DESC';
            }
            else {
               $sql = 'SELECT t.id,t.cardcode, u.email as userid, t.status FROM tags t INNER JOIN users u ON t.userid = u.id WHERE u.id = ' . $uid . ' ORDER BY t.id DESC';
            }
            foreach ($dbh->query($sql) as $row) {
                     echo '<tr>';
                     echo '<td>#' .$row['id']. '</td>';
                     echo '<td>' .$row['cardcode']. '</td>';
                     echo '<td>' .$row['userid'] . '</td>';
                    if ($row['status'] == 1){
                   echo '<td><p class="text-success">Attivato</p></td>';
                   echo '<td><a class="btn btn-danger" href="disable_tag.php?a=0&id='.$row['id'].'">Disattiva!</a></td>';
                     }
                    else{
                     echo '<td><p class="text-danger">Disattivato</p></td>';
                     if ($_SESSION['user_level'] < 3) {
                       echo '<td><a class="btn btn-warning" href="disable_tag.php?a=1&id='.$row['id'].'">Attiva!</a>';
                        }
                         else {
                       echo '<td><p class="text-danger">Il TAG disattivato può essere riattivato solo da un amministratore</p></td></td>';
                            }
                        }
                     echo '</tr>';

            }
            $dbh = Database::disconnect();
          }
          catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
          }
           ?>
                    </tbody>
                </table>
            </div>
    </div>
    <!-- /container -->

    <?php
    include('_footer.php');
?>
