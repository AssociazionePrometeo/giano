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
            $nameError = 'Please enter Card Code';
            $valid = false;
        }
         
        if (empty($userid)) {
            $useridError = 'Please enter UserID';
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
            header("Location: list_tag.php");
        }
    }
?>
   <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create Tag</h3>
                    </div>
                     <form class="form-horizontal" action="create_tag.php" method="post">
                      <div class="control-group <?php echo !empty($cardcodeError)?'error':'';?>">
                        <label class="control-label">Card Code</label>
                        <div class="controls">
                            <input name="cardcode" type="text" placeholder="Card Code" value="<?php echo !empty($cardcode)?$cardcode:'';?>">
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
           $sql = 'SELECT first_name, id FROM users';
           foreach ($pdo->query($sql) as $row)
           {
            if ($userid == $row['id']){
            echo'<option value='.$row['id']. ' selected>'.$row['first_name'].'</option>';
            }else{
            echo'<option value='.$row['id'].'>'.$row['first_name'].'</option>';
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
                                echo'<option value="1">Abilitato</option>';
                                echo'<option value="0" selected>Disabilitato</option>';
                                ?>
                            </select>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="list_tag.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div>  <!-- /container -->

<?php
    include('_footer.php');
}
?>
