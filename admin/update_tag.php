<?php
session_start();
if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
    exit;
}

include '_menu.php';
//require '../function/database.php';

$valid = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT insert_tags FROM permissions WHERE id=?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_tags'] == 1){
    $valid = true;
}else{
    header('Location: index.php');
}
Database::disconnect();

if($valid){
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header('Location: list_tag.php');
        exit;
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $cardcodeError = null;
        $useridError = null;

         
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
            $useridError = 'Please select User';
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
            header('Location: list_tag.php');
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
                        <label class="control-label">User</label>
                       <div class="controls">
                            <select class="selectpicker" placeholder="userid" name="userid" data-width="auto">
                                <?php
                                 $pdo = Database::connect();
           $sql = 'SELECT first_name, userid FROM users';
           foreach ($pdo->query($sql) as $row) 
           {
            if ($userid == $row['userid']){
            echo'<option value='.$row['userid']. ' selected>'.$row['first_name'].'</option>';    
            }else{
            echo'<option value='.$row['userid'].'>'.$row['first_name'].'</option>';
            }
           }
            Database::disconnect();
                                ?>
                            <?php if (!empty($useridError)): ?>
                                <span class="help-inline"><?php echo $useridError;?></span>
                            <?php endif;?>
                            </select>
                          </div>
                      </div>
                      <div class="control-group <?php echo !empty($statusError)?'error':'';?>">
                        <label class="control-label">Status</label>
                        <div class="controls">
                           <select class="selectpicker" placeholder="status" name="status" data-width="auto">
                               <?php
                               if ($status == 1){
                                echo'<option value="1" selected>Abilitato</option>';
                                echo'<option value="0">Disabilitato</option>';
                               }else{
                                echo'<option value="1">Abilitato</option>';
                                echo'<option value="0" selected>Disabilitato</option>';
                               }
                               ?>
                              </select>
                              </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="list_tag.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
}
?>
