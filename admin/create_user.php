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
        $firstnameError = null;
        $emailError = null;
        $lastnameError = null;
         
        // keep track post values
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $lastname = $_POST['lastname'];
         
        // validate input
        $valid = true;
        if (empty($firstname)) {
            $firstnameError = 'Please enter first name';
            $valid = false;
        }
         
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        if (empty($lastname)) {
            $lastnameError = 'Please enter last name';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (first_name,email_address,last_name) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($firstname,$email,$lastname));
            Database::disconnect();
            header("Location: index_user.php");
        }
    }
?>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Crea Utente</h3>
                    </div>
             
                    <form class="form-horizontal" action="create_user.php" method="post">
                      <div class="control-group <?php echo !empty($firstnameError)?'error':'';?>">
                        <label class="control-label">First Name</label>
                        <div class="controls">
                            <input name="firstname" type="text"  placeholder="firstname" value="<?php echo !empty($firstname)?$firstname:'';?>">
                            <?php if (!empty($firstnameError)): ?>
                                <span class="help-inline"><?php echo $firstnameError;?></span>
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
                      <div class="control-group <?php echo !empty($lastnameError)?'error':'';?>">
                        <label class="control-label">Last Name</label>
                        <div class="controls">
                            <input name="lastname" type="text"  placeholder="lastname Number" value="<?php echo !empty($lastname)?$lastname:'';?>">
                            <?php if (!empty($lastnameError)): ?>
                                <span class="help-inline"><?php echo $lastnameError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index_user.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
?>
