<?
/* Check User Script */
session_start();  // Start Session

include 'include/config.inc.php';
// Convert to simple variables
$username = $_POST['username'];
$password = $_POST['password'];

if((!$username) || (!$password)){
 $_SESSION["message"] = '<p class="bg-danger">compila entrambi i campi! </p>';
include 'index.php';
       exit();
}

// Convert password to md5
$password = md5($password);

// check if the user info validates the db
$sql = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
$login_check = mysql_num_rows($sql);
$sql2 = mysql_query("UPDATE users SET last_login=now() WHERE username='$username' AND password='$password' AND activated='1'");

if($login_check > 0){

        while($row = mysql_fetch_array($sql)){
        foreach( $row AS $key => $val ){
                $$key = stripslashes( $val );
        }
                if($activated == 1){
                // Register some session variables! */
                $_SESSION["ID"] = $userid;
                $_SESSION['user_level'] = $user_level;
                header("Location: index.php");
                }else{
                    $_SESSION["message"] = '<p class="bg-danger">La tua utenza è stata disattivata</p>';
                    include 'index.php';
                     }

        }

} else {
  $_SESSION["message"] = '<p class="bg-danger">username o password errata</p>';
   include 'index.php';
}
mysql_close($sql);
mysql_close($sql2);
?>
