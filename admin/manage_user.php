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
$action = null;

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM users a INNER JOIN type_user b on a.id = b.id LEFT JOIN permissions c on a.user_level = c.id WHERE a.id = ?';
$q = $dbh->prepare($sql);
$q->execute(array($uid));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['insert_users'] == 1){
    $insert_users_permission = true;
}else{
    header('Location: ../login.php');
}
if ( !empty($_REQUEST['a']) && $_REQUEST['a'] == 'update' && !empty($_REQUEST['id']) ) {
  $id = $_REQUEST['id'];
  $action = $_REQUEST['a']; // if a is not set default is insert user
  $sql = "SELECT * FROM users where id = ?";
  $q = $dbh->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);
  $name = $data['first_name'];
  $email = $data['email'];
  $mobile = $data['mobile_number'];
  $password = $data['password'];
  $info = $data['info'];
  $end_date = $data['end_date'];
  $level = $data['user_level'];
  $isactive = $data['isactive'];
}


if($insert_users_permission) {
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $passError = null;
        $emailError = null;
        $mobileError = null;
        $end_dateError = null;
        $levelError = null;
        $infoError = null;
        $isactiveError = null;

        // keep track post values
        $name = $_POST['name'];
        if (!empty($_POST['password'])){
        $password = ($_POST['password']);
        }
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $end_date = $_POST['end_date'];
        $level = $_POST['level'];
        $info = $_POST['info'];
        $isactive = $_POST['isactive'];

        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($password)) {
            //$passError = 'Please enter Password';
            $valid = true;
        }

        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }

        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }

        if (empty($end_date)) {
            $end_dateError = 'Please enter Exp. Date';
            $valid = false;
        }

        if (empty($level)) {
            $levelError = 'Please enter User Level';
            $valid = false;
        }

       //}
        // insert/update user data
      if ($valid) {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = '';
        if (isset($action) && $action=='update') {
              $sql = "UPDATE users  SET first_name = ?, info = ?, user_level = ?, email = ?, mobile_number =?, end_date = ?, isactive = ? WHERE id = ?";
              $q = $dbh->prepare($sql);
              $q->execute(array($name,$info,$level,$email,$mobile,$end_date,$isactive,$id));
        }
        else {
            date_default_timezone_set('Europe/Rome');
            echo date_default_timezone_get();
            $signup_date= date('Y-m-d');
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $return = $auth->register($email, $password, $password);
            $sql = "UPDATE users  SET first_name = ?, info = ?, user_level = ?, mobile_number =?, end_date = ?, isactive = ? WHERE email = ?";
            $q = $dbh->prepare($sql);
             $q->execute(array($name,$info,$level,$mobile,$end_date,$isactive,$email));
        }
        header("Location: list_user.php");
      } //end if valid
    } //end empty _POST
  }
?>
<div class="container">
          <div class="span10 offset1">
              <div class="row">
                  <h3>Manage Users</h3>
              </div>

              <?php echo '<form class="form-horizontal" action="manage_user.php';
              if (isset($action) || $action=='update') echo '?a=update';
              if (isset($id)) echo '&amp;id='. $id;
              echo '" method="post">';
              ?>

                <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                  <label class="control-label">Name</label>
                  <div class="controls">
                      <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                      <?php if (!empty($nameError)): ?>
                          <span class="help-inline"><?php echo $nameError;?></span>
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

              <div class="control-group <?php echo !empty($passError)?'error':'';?>">
                  <label class="control-label">Password</label>
                  <div class="controls">
                      <input name="password" type="password" placeholder="Leave empty to unchange" value="">
                      <?php if (!empty($passError)): ?>
                          <span class="help-inline"><?php echo $passError;?></span>
                      <?php endif;?>
                  </div>
                </div>

                <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                  <label class="control-label">Mobile Number</label>
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
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="input-group">
                          <input required id="_end_datetimepicker" class="form-control" type="text" placeholder="Expiration Date" name="end_date" value="<?php echo !empty($end_date)?$end_date:'';?>"/>
                          <?php
                              if (!empty($end_dateError))
                                echo '<span class="help-inline">' . $end_dateError . '</span>';
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="control-group <?php echo !empty($levelError)?'error':'';?>">
                  <label class="control-label">User Level</label>
                  <div class="controls">
                      <select required class="selectpicker" placeholder="Level" name="level" data-width="auto">
                          <option value=''></option>
                          <?php
                           $pdo = Database::connect();
                           $sql = 'SELECT * FROM type_user';
                           foreach ($pdo->query($sql) as $row)
                              echo '<option value="' . $row['id'] . "\"" . ((isset($level) && $level == $row['id'])? ' selected="selected"':'') . '>' . $row['level']  . '</option>'."\r\n";
                           Database::disconnect();
                          ?>
                      </select>
                      <?php
                        if (!empty($levelError))
                          echo '<span class="help-inline">' . $levelError . "</span>";
                      ?>
                    </div>
                </div>

                <div class="control-group">
                  <label class="control-label">Info</label>
                  <div class="controls">
                      <input name="info" type="text"  placeholder="Info" value="<?php echo !empty($info)?$info:'';?>">
                      </div>
                </div>

              <div class="control-group <?php echo !empty($isactiveError)?'error':'';?>">
                  <label class="control-label">Stato</label>
                  <div class="controls">
                      <select required class="selectpicker" placeholder="stato" name="isactive" data-width="auto">
                       <?php
                        if ($isactive == '0'){
                            echo"<option value='0' selected='selected'>disattivato</option>";
                        }else{
                            echo"<option value='0'>disattivato</option>";
                        }
                        if ($isactive == '1'){
                            echo"<option value='1' selected='selected'>attivato</option>";
                        }else{
                            echo"<option value='1'>attivato</option>";
                        }
                        ?>
                      </select>
                  </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a class="btn" href="list_user.php">Back</a>
                </div>
              </form>
          </div>

</div><!-- /container -->
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

<?php
    include('_footer.php');
?>
