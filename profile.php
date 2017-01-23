<?php
session_start();
$loader = require __DIR__ . '/vendor/autoload.php';
require 'function/database.php';
require 'function/Auth.php';
require 'function/Config.php';

$dbh = Database::connect();
$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config, "it_IT");

if (!$auth->isLogged()) {
  header('Location: ../login.php');
  exit();
}

include '_header.php';
include '_menu.php';
?>

<div class="container" >
   <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profilo</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Profilo Utente</th>
            </tr>
          </thead>
          <tbody>
              <?php
              $uid = $auth->getSessionUID($_COOKIE[$config->cookie_name]);
              $sql = '
              SELECT users.id,first_name,email,user_level,level FROM users
              LEFT JOIN type_user on users.user_level = type_user.id
              WHERE users.id =' . $uid . ' ORDER BY id DESC';
              foreach ($dbh->query($sql) as $row) {
                echo '<tr>';
                echo '<td>' .$row['id'] . '</td>';
                echo '<td>' .$row['first_name']. '</td>';
                echo '<td>' .$row['email'] . '</td>';
                echo '<td>' .$row['level'] . '</td>';
                echo '</tr>';
              }
              ?>
          </tbody>
        </table>
        </div> </div> </div>
</div>

<?php include '_footer.php'; ?>
