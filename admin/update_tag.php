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
            $cardcodeError = 'Please enter Card Code';
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
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE tags  set cardcode = ?, userid = ?, status =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($cardcode,$userid,$status,$id));
            Database::disconnect();
            header("Location: index_tag.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM tags where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $cardcode = $data['cardcode'];
        $userid = $data['userid'];
        $status = $data['status'];
        Database::disconnect();
    }
?>
<div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update Tag</h3>
                    </div>
             
                    <form class="form-horizontal" action="update_tag.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($cardcodeError)?'error':'';?>">
                        <label class="control-label">Card Code</label>
                        <div class="controls">
                            <input name="cardcode" type="text" placeholder="Card Name" value="<?php echo !empty($cardcode)?$cardcode:'';?>">
                            <?php if (!empty($cardcodeError)): ?>
                                <span class="help-inline"><?php echo $cardcodeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($useridError)?'error':'';?>">
                        <label class="control-label">UserID</label>
                        <div class="controls">
                            <input name="userid" type="text"  placeholder="userid" value="<?php echo !empty($userid)?$userid:'';?>">
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
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index_tag.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
?>
