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
        $cardcodeError = null;
        $useridError = null;
        $statusError = null;
         
        // keep track post values
        $cardcode = $_POST['cardcode'];
        $userid = $_POST['userid'];
        $status = $_POST['status'];
         
        // validate input
        $valid = true;
        if (empty($cardcode)) {
            $nameError = 'Please enter Card Code';
            $valid = false;
        }
         
        if (empty($userid)) {
            $useridError = 'Please enter UserID';
            $valid = false;
        }
         
        if (empty($status)) {
            $statusError = 'Please enter Status';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO tags (cardcode,userid,status) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($cardcode,$userid,$status));
            Database::disconnect();
            header("Location: index_tag.php");
        }
    }
?>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Crea Tag</h3>
                    </div>
             
                    <form class="form-horizontal" action="create_tag.php" method="post">
                      <div class="control-group <?php echo !empty($cardcodeError)?'error':'';?>">
                        <label class="control-label">Card Code</label>
                        <div class="controls">
                            <input name="cardcode" type="text"  placeholder="Card Code" value="<?php echo !empty($cardcode)?$cardcode:'';?>">
                            <?php if (!empty($cardcodeError)): ?>
                                <span class="help-inline"><?php echo $cardcodeError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($useridError)?'error':'';?>">
                        <label class="control-label">User ID</label>
                        <div class="controls">
                            <input name="userid" type="text" placeholder="UserID" value="<?php echo !empty($userid)?$userid:'';?>">
                            <?php if (!empty($useridError)): ?>
                                <span class="help-inline"><?php echo $useridError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($statusError)?'error':'';?>">
                        <label class="control-label">Status</label>
                        <div class="controls">
                            <input name="status" type="text"  placeholder="Status" value="<?php echo !empty($status)?$status:'';?>">
                            <?php if (!empty($statusError)): ?>
                                <span class="help-inline"><?php echo $statusError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index_tag.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
?>
