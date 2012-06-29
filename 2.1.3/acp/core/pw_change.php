<br /><br />
<h2>Passwort &auml;ndern</h2>
<?
if($_POST['send']=="admin"){
$pw_old1=$_POST['pwold1']; 
$pw_new=$_POST['pwnew'];	
$pw_new2=$_POST['pwnew2']; 	
if($pw_new !=""){
if($pw_new==$pw_new2){  
dbconnect();
$sql_admin_update="UPDATE `".get_db_table("admin")."` SET `Kennwort`='".$pw_new."' WHERE `Id`= '1'";
mysql_query($sql_admin_update);
echo "<font color='#00DB00'><strong>Passwort wurde ge&auml;ndert.</strong></font><br /><br />";
}else{ echo "<font color='#FF0000'><strong>Passw&ouml;rter sind nicht identisch.</strong></font><br /><br />"; }
}else{ echo "<font color='#FF0000'><strong>Kein neues Passwort eingegeben.</strong></font><br /><br />"; }
}
?>
<form method="POST" action="">
<input type="hidden" name="send" value="admin">
<strong>Altes Passwort:</strong><br />
<input type="password" name="pwold" size="40" value=""><br><br>
<br>
<strong>Neues Passwort:</strong><br />
<input type="password" name="pwnew" size="40" value=""><br><br>
<strong>Neues Passwort wiederholen:</strong><br />
<input type="password" name="pwnew2" size="40" value=""><br><br />
<input type="submit" class="submit" value="Speichern" name="B3">
<input type="reset" class="submit" value="Zur&uuml;cksetzen" name="B4">
</form>