<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

//include '_header.php';
include '_menu.php';
// require '../function/database.php';

$valid = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT insert_users FROM permissions WHERE id=?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_users'] == 1){
    $valid = true;
}else{
    header('Location: index.php');
}
Database::disconnect();

if($valid){
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $infoError = null;
        $usernameError = null;
        $emailError = null;
        $levelError = null;
        $mobileError = null;
        $end_dateError = null;

        // keep track post values
        $name = $_POST['name'];
        $info = $_POST['info'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $level = $_POST['level'];
        $mobile = $_POST['mobile'];
        $end_date = $_POST['end_date'];

        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }

        /*  Is necessary?? boh

        if (empty($info)) {
            $nameError = 'Please enter Infos';
            $valid = false;
        }*/

        if (empty($username)) {
            $nameError = 'Please enter Username';
            $valid = false;
        }

        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }

        if (empty($level)) {
            $nameError = 'Please select userlevel!';
            $valid = false;
        }

        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        if (empty($end_date)) {
            $nameError = 'Please enter expiration date';
            $valid = false;
        }

        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (first_name,info,username,user_level,email_address,mobile_number,end_date) values(?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$info,$username,$level,$email,$mobile,$end_date));
            Database::disconnect();
            header("Location: list_user.php");
        }
    }
?>
<div class="container">

                <div class="span10 offset1">
                    <div class="row">
                        <h3>Aggiungi Utente</h3>
                    </div>

                    <form class="form-horizontal" action="create_user.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
                        <label class="control-label">Username</label>
                        <div class="controls">
                            <input name="username" type="text"  placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
                            <?php if (!empty($usernameError)): ?>
                                <span class="help-inline"><?php echo $usernameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                     <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Last Name</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($end_dateError)?'error':'';?>">
                        <label class="control-label">Expiration Date</label>
                        <div class="controls">
                            <!--input id="datetimepicker" type="text" name="end_date"-->
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="input-group">
                                <input id="_end_datetimepicker" class="form-control" type="text" name="end_date" value="<?php echo !empty($end_date)?$end_date:'';?>"/>
                              </div>
                            </div>
                          </div>
                          <script type="text/javascript">// <![CDATA[
                          jQuery(function(){
                          jQuery('#_end_datetimepicker').datetimepicker({
                            format:'Y-m-d',
                            timepicker: false,
                            lang:'it'
                          });
                          jQuery('#image_button').click(function(){
                            jQuery('#_end_datetimepicker').datetimepicker('show');
                          });
                          });
                          // ]]>
                          </script>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($levelError)?'error':'';?>">
                        <label class="control-label">Level</label>
                        <div class="controls">
                            <select class="selectpicker" placeholder="level" name="level" data-width="auto">
                                <option value=''></option>
                                <?php
            $pdo = Database::connect();
           $sql = 'SELECT id, name FROM permissions';
           foreach ($pdo->query($sql) as $row)
           {
            echo'<option value='.$row['id'].'>'.$row['name'].'</option>';
           }
           Database::disconnect();
                                ?>
                            <?php if (!empty($levelError)): ?>
                                <span class="help-inline"><?php echo $levelError;?></span>
                            <?php endif;?>
                            </select>
                          </div>
                      </div>
                        <div class="control-group">
                        <label class="control-label">Info</label>
                        <div class="controls">
                            <input name="info" type="text"  placeholder="Info" value="<?php echo !empty($info)?$info:'';?>">
                            </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="list_user.php">Back</a>
                        </div>
                    </form>
                </div>

    </div><!-- /container -->

<?php
    include('_footer.php');
}
?>
