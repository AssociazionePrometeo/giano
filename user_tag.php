<?php
/* Check User Script */
if (session_status() == PHP_SESSION_NONE) {session_start();}

$loader = require __DIR__ . '/vendor/autoload.php';
require 'function/database.php';
require 'function/Auth.php';
require 'function/Config.php';

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
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          try {
            $uid = $auth->getSessionUID($_COOKIE[$config->cookie_name]);
            $sql = 'SELECT * FROM tags WHERE userid = '.$uid.' ORDER BY id DESC';
            foreach ($dbh->query($sql) as $row) {
                     echo '<tr>';
                     echo '<td>#' .$row['id']. '</td>';
                     echo '<td>' .$row['cardcode']. '</td>';
                 if ($row['status'] == 1){
                   echo '<td>Attivato</td>';
                   echo '<td><a class="btn btn-danger" href="disable_tag.php?id='.$row['id'].'">Disattiva!</a></td>';
                 }else{
                     echo '<td>Disattivato</td>';
                     echo '<td><p class="bg-danger">Il TAG disattivato può essere riattivato solo da un amministratore</p></td>';
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
</div> <!-- /container -->

<?php
    include('_footer.php');
?>
