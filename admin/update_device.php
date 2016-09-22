<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

include '_header.php';
include '_menu.php';

?>

<?php
    require '../function/database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
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
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE devices  set name = ?, active = ?, type =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$active,$type,$id));
            Database::disconnect();
            header("Location: index_device.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM devices where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['name'];
        $active = $data['active'];
        $type = $data['type'];
        Database::disconnect();
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
                          <a class="btn" href="index_device.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
?>
