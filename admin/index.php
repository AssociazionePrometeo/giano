<?
session_start();
include ("../include/config.inc.php");
$sql="SELECT user_level FROM users WHERE userid=".$_SESSION["ID"]."";
$result = mysql_query($sql) or die (mysql_error());;
$array = mysql_fetch_array($result);
$userlevel=$array['user_level'];
mysql_close($sql);

if ( !isset($_SESSION["ID"]) ) {
 header('Location: ../index.php');
}elseif ($userlevel=='0'){

    include ("_menu.php");

    ?>
    <!-- Modal -->
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <? echo $_SESSION["message_type"];?>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        <? echo $_SESSION["message"];    ?>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?
    if (isset($_SESSION["message"])){
    ?>
        <script type="text/javascript">
            function load() {
                $('#myModal').modal('show')
            };
            window.onload = load();
        </script>
        <?
         unset($_SESSION["message"]);
                                    };
$a=$_GET['a'];
switch($a)
{
case users:
$u=$_GET['u'];
switch($u)
{    case add:
  ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Aggiungi Utente</h1>
                        <form class="form-horizontal" method="post" action="?a=user&e=register">
                            <div class="row">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nome</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="inputEmail3" name="nome" placeholder="Nome">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Cognome</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="inputEmail3" name="cognome" placeholder="Cognome">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Username</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="inputEmail3" name="username" placeholder="Username">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-2">
                                        <input type="Password" class="form-control" id="inputEmail3" name="password">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Riscrivi Password</label>
                                    <div class="col-sm-2">
                                        <input type="password" class="form-control" id="inputEmail3" name="password2">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">E-mail</label>
                                    <div class="col-sm-2">
                                        <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="name@example.com">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Data Scadenza</label>
                                    <div class="col-sm-2">
                                        <input type="date" class="form-control" id="inputEmail3" name="end_date">
                                    </div>
                                    <label for="inputEmail3" class="col-sm-1 control-label">Livello</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="livello_utente"> <option value="1">Utente</option> <option value="0">Amministratore</option></select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Registra</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?
break;
case register:
$Nome = $_POST['nome'];
$Cognome = $_POST['cognome'];
$Indirizzo_email = $_POST['indirizzo_email'];
$Nick = $_POST['username'];
//$informazioni = $_POST['informazioni'];
$end_date = $_POST['end_date'];
$livello_utente = $_POST['livello_utente'];
$password=$_POST['password'];
$password2=$_POST['password2'];



$Nome = stripslashes($Nome);
$Cognome = stripslashes($Cognome);
$Indirizzo_email = stripslashes($Indirizzo_email);
$livello_utente = stripslashes($livello_utente);
$Nick = stripslashes($Nick);
//$informazioni = stripslashes($informazioni);
$password = stripslashes($password);




if((!$Nome) || (!$Cognome) || (!$Indirizzo_email) || (!$Nick) || (!$password) || (!$end_date)){
    $_SESSION['message_type']="ERRORE";
    $_SESSION['message']="Devi riempire tutti i campi!!";
        if(!$Nome){
                $_SESSION['message']="Devi inserire un nome";
        }
        if(!$Cognome){
            $_SESSION['message']="Devi inserire un cognome";
        }
        if(!$Indirizzo_email){
            $_SESSION['message']="Devi inserire un indirizzo e-mail";
        }
        if(!$Nick){
            $_SESSION['message']="Devi inserire un Username";
        }
        if(!$end_date){
            $_SESSION['message']="Devi inserire la data di scadenza";
        }
        if(!$password){
            $_SESSION['message']="Devi inserire una password";
        }
        exit();
}



 $sql_email_check = mysql_query("SELECT email_address FROM users WHERE email_address='$Indirizzo_email'");
 $sql_username_check = mysql_query("SELECT username FROM users WHERE username='$Nick'");

 $email_check = mysql_num_rows($sql_email_check);
 $username_check = mysql_num_rows($sql_username_check);


 if(($email_check > 0) || ($username_check > 0)){
         $_SESSION['message_type']="Dati già presenti";
         if($email_check > 0){
                 $_SESSION['message']="strong>Il tuo indirizzo e-mail è già presente nel database, per favore inseriscine un altro";
                 unset($email_address);
         }
         if($username_check > 0){
                 $_SESSION['message']="L'username che hai scelto è già utilizzato, per favore scegline un altro";
                 unset($username);
         }
         exit();
 }




$db_password = md5($password);

// Enter info into the Database.
$info2 = htmlspecialchars($informazioni);
$sql = mysql_query("INSERT INTO users (first_name, last_name, email_address, username, password, signup_date, end_date, user_level, decrypted_password)
                VALUES('$Nome', '$Cognome', '$Indirizzo_email', '$Nick', '$db_password', now(), '$end_date', '$livello_utente', '$password')") or die (mysql_error());

if(!$sql){
       $_SESSION['message']="Errore di creazione account.";
} else {
$userid = mysql_insert_id();
$_SESSION['message']="La tua registrazione cliccando qui <a href='?e=activate&id=$userid&code=$db_password'><b>Attiva!</b></a>";
}
    break;

default:
?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Gestione Utenti</h1>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>UserID</th>
                                        <th>Username</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>e-mail</th>
                                        <th>livello utente</th>
                                        <th>Data di iscrizione</th>
                                        <th>Data di scadenza</th>
                                        <th>Ultimo accesso</th>
                                        <th>Stato di attivazione</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <?
$sql = "SELECT userid, username, first_name, last_name, email_address, decrypted_password, user_level, signup_date, end_date, last_login, info, activated  FROM users";
$result = mysql_query($sql);
while ($array = mysql_fetch_array($result))
{
echo"<tbody>
<tr>
<td>".$array['userid']."</td><td>".$array['username']."</td><td>".$array['first_name']."</td><td>".$array['last_name']."</td><td>".$array['email_address']."</td><td>";
 if ($array['user_level'] == 0) echo "amministratore";  else echo "utente";
echo"</td><td>".$array['signup_date']."</td><td>".$array['end_date']."</td><td>".$array['last_login']."</td><td>".$array['activated']."</td><td></td></tr>";

/*print "<td><font size='0'><a href='admin.php?a=userblokked&id=$array[userid]'>B</a>  <a href='admin.php?a=userabilited&id=$array[userid]'>A</a>  <a href='admin.php?a=editusers&id=$array[userid]'><img src=Icon/edit.png title=Modifica border=0></a> <a href='admin.php?a=deleteuser&id=$array[userid]'><img src=Icon/cancel.gif title=Elimina  border=0></a> <a href='admin.php?a=downuser&nick=$array[username]'>C</a></font></td>";*/

}
    echo"</tbody></table>";
    mysql_close($sql);
echo "</div></div></div>";
}
break;

    case log:
        ?>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h1 class="page-header">Storico LOG
                                                    <small>I tuoi log</small>
                                                </h1>

                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Utente</th>
                                                                        <th>Cardcode</th>
                                                                        <th>Risorsa</th>
                                                                        <th>Data - Ora</th>
                                                                    </tr>
                                                                </thead>
                                                                <?
$sql = "SELECT * FROM log";
$result = mysql_query($sql);
while ($array = mysql_fetch_array($result))
{

 echo"<tbody><tr><td>";
$sql2 = "SELECT * FROM users WHERE userid=".$array['userid']."";
$result2 = mysql_query($sql2);
while ($array2 = mysql_fetch_array($result2))
{
echo $array2['first_name'];
echo " ";
echo $array2['last_name'];
}
mysql_close($sql2);

 echo"</td><td>".$array['cardcode']."</td><td>";
$sql1 = "SELECT name FROM devices WHERE id=".$array['device']."";
$result1 = mysql_query($sql1);
while ($array1 = mysql_fetch_array($result1))
{
echo $array1['name'];
}
mysql_close($sql1);
echo"</td><td>".$array['date_log']."</td></tr>";
}
        echo"</tbody></table>";
    mysql_close($sql);
echo "</div></div></div>";

                                ?>


                                                        </div>
                                                    </div>
                                                </div>
                                                <?
        break;
        default:
            ?>
                                                    <div class="container">


                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <h1 class="page-header">Sezione amministrazione
                                                                </h1>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <?


}

            ?>

                                                        <!-- /.container -->

                                                        <?
    include('../_footer.php');
    ?>


                                                            </body>

                                                            </html>


                                                            <?
}else {
header('Location: ../index.php');
};
?>
