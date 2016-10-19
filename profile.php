<?php
session_start();
if (!isset($_SESSION["ID"])) {
    header('Location: ../login.php');
    exit;
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
              <th>Nome</th>
              <th>Email</th>
              <th>Username</th>
              <th>Profilo</th>
            </tr>
          </thead>
          <tbody>
              <?php
                echo '<tr>';
                echo '<td>' .$_SESSION['first_name']. '</td>';
                echo '<td>'. $_SESSION['email'] . '</td>';
                echo '<td>'. $_SESSION['username'] . '</td>';
                echo '<td>'. $_SESSION['user_level'] . '</td>';
                echo '</tr>';
              ?>
          </tbody>
        </table>
        </div> </div> </div>
</div>

<?php include '_footer.php'; ?>
