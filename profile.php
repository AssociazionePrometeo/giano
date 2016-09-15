<?
include 'include/config.inc.php';

?>
<html>
<table class=outside-box  border='1' width='89%' height='272'>
  <tr>
    <td width='20%' height='10'>
<? print"<b>Nome:</B> ".$array['first_name'].""; ?>
    </td>
    <td width='80%' height='10'>
<? print"<b>Cognome:</B> ".$array['last_name'].""; ?>
    </td>
    <td width='80%' height='10'>
<? print"<b>Username:</B> ".$array['username'].""; ?>
     </td>
     <td width='80%' height='10'>
     <b>Status:</B>
         <? if ($array['user_level']==0){
echo"<B>Amministratore</B>";
}else ($array['user_level']==1){
echo"<B>Utente</B>";
}

 echo"</td></tr><td width='20%' height='10'><b>INFO:</B><br>".$array['info']."
    </td></table></html>";
?>
