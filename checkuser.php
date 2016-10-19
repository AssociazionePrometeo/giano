<?php
/* Check User Script */
if (session_status() == PHP_SESSION_NONE) {session_start();}

include 'function/database.php';
// Convert to simple variables
$username = $_POST['username'];
$password = $_POST['password'];

if((!$username) || (!$password)){
 $_SESSION["message"] = '<p class="bg-danger">Compila entrambi i campi! </p>';
include 'index.php';
       exit();
}

// Convert password to md5
$password = md5($password);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$login_check = $pdo->prepare("SELECT * FROM users WHERE username= :username AND password= :password and activated = 1 and end_date > now()");
$login_check->bindParam(':username', $username); 
$login_check->bindParam(':password', $password); 
$login_check->execute();
$login_check = $login_check->fetch(PDO::FETCH_ASSOC);

if($login_check) {
    if ($login_check['activated']) {
        $sql = $pdo->prepare("UPDATE `users` SET last_login = NOW() WHERE userid= :userid");
        $sql->bindParam(':userid', $login_check['userid']); 
        $sql->execute();
        // Register some session variables! */
        $_SESSION["ID"] = $login_check['userid'];
        $_SESSION["first_name"] = $login_check['first_name'];
        $_SESSION["email"] = $login_check['email_address'];
        $_SESSION["username"] = $login_check['username'];
        $_SESSION['user_level'] = $login_check['user_level'];
        header("Location: index.php");
    }
} 
else {
    $_SESSION["message"] = '<p class="bg-danger">Username / Password errata</p>';
    header("Location: index.php");
}
?>
