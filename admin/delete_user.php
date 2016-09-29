<?php
session_start();

if ( !isset($_SESSION["ID"]) ) {
    header('Location: ../login.php');
}

//include '_header.php';
include '_menu.php';
//require '../function/database.php';

$valid = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT delete_users FROM permissions WHERE id=?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['user_level']));
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['delete_users'] == 1){
    $valid = true;
}else{
    header('Location: index.php');
}
Database::disconnect();

if($valid){
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM users  WHERE userid = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: list_user.php");
         
    }
?>
 

    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Delete Utente</h3>
                    </div>
                     
                    <form class="form-horizontal" action="delete_user.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-error">Are you sure to delete ?</p>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-danger">Yes</button>
                          <a class="btn" href="list_user.php">No</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->

<?php
    include('_footer.php');
}
?>

