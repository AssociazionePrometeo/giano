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
            $nameError = 'Please enter Card Code';
            $valid = false;
        }
         
        if (empty($active)) {
            $activeError = 'Please enter active';
            $valid = false;
        }
         
        if (empty($type)) {
            $typeError = 'Please enter type';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO devices (name,active,type) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$active,$type));
            Database::disconnect();
            header("Location: index_device.php");
        }
    }
?>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Crea Device</h3>
                    </div>
             
                    <form class="form-horizontal" action="create_device.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Card Code</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($activeError)?'error':'';?>">
                        <label class="control-label">Active</label>
                        <div class="controls">
                            <input name="active" type="text" placeholder="active" value="<?php echo !empty($active)?$active:'';?>">
                            <?php if (!empty($activeError)): ?>
                                <span class="help-inline"><?php echo $activeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
                        <label class="control-label">Type</label>
                        <div class="controls">
                            <input name="type" type="text"  placeholder="type" value="<?php echo !empty($type)?$type:'';?>">
                            <?php if (!empty($typeError)): ?>
                                <span class="help-inline"><?php echo $typeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index_device.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
?>
