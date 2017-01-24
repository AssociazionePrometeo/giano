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

include '_header.php';
include '_menu.php';

$valid = null;
$dbh = Database::connect();
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT delete_devices FROM permissions WHERE id=?';
$q = $dbh->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['delete_devices'] == 1){
    $valid = true;
}else{
    header('Location: ../login.php');
}

if($valid){
    $id = 0;

    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];

        // delete data
        $sql = "DELETE FROM devices  WHERE id = ?";
        $q = $dbh->prepare($sql);
        $q->execute(array($id));
        header("Location: list_device.php");
    }
?>


    <div class="container">

                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete Utente</h3>
                    </div>

                    <form class="form-horizontal" action="delete_device.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Are you sure to delete ?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="list_device.php">No</a>
                        </div>
                    </form>
                </div>

    </div> <!-- /container -->

<?php
    include('_footer.php');
}
?>
