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

$valid = null;
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT insert_devices FROM permissions WHERE id=?';
$q = $dbh->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_devices'] == 1){
    $valid = true;
}else{
    header('Location: ../login.php');
}


if($valid){
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    if ( null==$id ) {
        header("Location: ../login.php");
    }

    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $activeError = null;
        $typeError = null;

        // keep track post values
        $name = $_POST['name'];
        $active = $_POST['active'];
        $type = $_POST['type'];

        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($active)) {
            $emailError = 'Please enter Active';
            $valid = false;
        }

        if (empty($type)) {
            $mobileError = 'Please enter Type';
            $valid = false;
        }

        // update data
        if ($valid) {
            $sql = "UPDATE devices  set name = ?, active = ?, type =? WHERE id = ?";
            $q = $dbh->prepare($sql);
            $q->execute(array($name,$active,$type,$id));
            header("Location: list_device.php");
        }
    } else {
        $sql = "SELECT * FROM devices where id = ?";
        $q = $dbh->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $active = $data['active'];
        $type = $data['type'];
    }
?>
<div class="container">

                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update Device</h3>
                    </div>

                    <form class="form-horizontal" action="update_device.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($activeError)?'error':'';?>">
                        <label class="control-label">Active</label>
                        <div class="controls">
                            <input name="active" type="text"  placeholder="active" value="<?php echo !empty($active)?$active:'';?>">
                            <?php if (!empty($activeError)): ?>
                                <span class="help-inline"><?php echo $activeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
                        <label class="control-label">Type</label>
                        <div class="controls">
                            <input name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:'';?>">
                            <?php if (!empty($typeError)): ?>
                                <span class="help-inline"><?php echo $typeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="list_device.php">Back</a>
                        </div>
                    </form>
                </div>

    </div> <!-- /container -->

<?php
    include('_footer.php');
}
?>
