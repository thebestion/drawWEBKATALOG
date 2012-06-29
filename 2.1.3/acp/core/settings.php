<br /><br />
<h2>Einstellungen</h2>
<?
############### DropDown Auswahl Counter #############
if(get_setting_data(counter)=="1"){ $ddc = '<option value="1">Aktiv</option><option value="0">Deaktiv</option>'; } 
else { $ddc = '<option value="0">Deaktiv</option><option value="1">Aktiv</option>'; }

############### Update Settings Data #################
if($_POST['send']=="1") {

# url 	name 	genre 	email 	sitedate 	counter 	layout_id 	favico 	google_verify 	google_analytics 

$url = $_POST['url'];
$name = $_POST['name'];

$genre = $_POST['genre'];
$email = $_POST['email'];
$sitedate = $_POST['sitedate'];
$counter = $_POST['counter'];
$layout_id = $_POST['layout'];
$favico = $_POST['favicon'];
$google_verify = $_POST['google_verify'];
$google_analytics = $_POST['google_analytics'];
$paypal = $_POST['paypal'];
$prempreis = $_POST['prempreis'];
$logo = $_POST['logo'];

dbconnect();
$sql_update ="UPDATE `".get_db_table("setting")."` SET `url`='".$url."', `name`='".$name."', `genre`='".$genre."', `email`='".$email."', `sitedate`='".$sitedate."', `counter`='".$counter."', `layout_id`='".$layout_id."', `favico`='".$favico."', `google_verify`='".$google_verify."', `google_analytics`='".$google_analytics."', `paypal`='".$paypal."', `prempreis`='".$prempreis."', `logo`='".$logo."' WHERE `Id`='1'  ";
mysql_query($sql_update) OR die("error");
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=settings'>";
#echo "<strong><font color='#00c909'>Einstellungen wurden gespeichert.</strong></font><br /><br />";
}
?>
<form action="" method="post">
<input type="hidden" name="send" value="1" />
<table border="0" width="590" height="264">
	<tr>
		<td height="12" width="185"><strong>Allgemeine Einstellungen</strong></td>
		<td height="12" width="389"></td>
	</tr>
    <tr>
		<td height="12" width="185">Seiten Url:</td>
		<td height="12" width="389"><input type="text" size="50" name="url" value="<?=get_setting_data(url);?>" /></td>
	</tr>
	<tr>
		<td height="22" width="185">Seiten Name:</td>
		<td height="22" width="389"><input type="text" size="50" name="name" value="<?=get_setting_data(name);?>" /></td>
	</tr>
	<tr>
		<td height="18" width="185">Seiten Genre:</td>
		<td height="18" width="389"><input type="text" size="50" name="genre" value="<?=get_setting_data(genre);?>" /></td>
	</tr>
	<tr>
		<td height="19" width="185">E-Mail:</td>
		<td height="19" width="389"><input type="text" size="50" name="email" value="<?=get_setting_data(email);?>" /></td>
	</tr>
	<tr>
		<td height="24" width="185">Erstellungsdatum:</td>
		<td height="24" width="389"><input type="text" size="50" name="sitedate" value="<?=get_setting_data(sitedate);?>" /></td>
	</tr>
	<tr>
		<td height="15" width="185"><br /><strong>Counter Log Einstellungen</strong></td>
		<td height="15" width="389"></td>
	</tr>
    <tr>
		<td height="15" width="185">Counter:</td>
		<td height="15" width="389">
        <select name="counter"><?=$ddc;?></select></td>
	</tr>
	<tr>
		<td height="22" width="185"><br /><strong>Template Einstellungen</strong></td>
		<td height="22" width="389"></td>
	</tr>
    <tr>
		<td height="22" width="185">Template:</td>
		<td height="22" width="389">
        <select name="layout"><?=get_layout_list();?></select></td>
	</tr>
	<tr>
		<td height="16" width="185">Favoriten Icon</td>
		<td height="16" width="389"><input type="text" size="50" name="favicon" value="<?=get_setting_data(favico);?>" /></td>
	</tr>
    <tr>
		<td height="16" width="185">Logo</td>
		<td height="16" width="389"><input type="text" size="50" name="logo" value="<?=get_setting_data(logo);?>" /></td>
	</tr>
	<tr>
		<td height="18" width="185"><br /><strong>Premiumlink Einstellung</strong></td>
		<td height="18" width="389"></td>
	</tr>
	<tr>
		<td height="16" width="185">Paypal Email-Adresse:</td>
		<td height="16" width="389"><input type="text" size="50" name="paypal" value="<?=get_setting_data(paypal);?>" /></td>
	</tr>
    <tr>
		<td height="16" width="185">Premiumlink Preis:</td>
		<td height="16" width="389"><input type="text" size="50" name="prempreis" value="<?=get_setting_data(prempreis);?>" /></td>
	</tr>
    <tr>
		<td height="18" width="185"><br /><strong>Google Webmaster Tool</strong></td>
		<td height="18" width="389"></td>
	</tr>
    <tr>
		<td height="18" width="185">Google Vertiferzierung (<i>MetaTag</i>):</td>
		<td height="18" width="389"><input type="text" size="50" name="google_verify" value='<?=get_setting_data(google_verify);?>'/></td>
	</tr>
	<tr>
		<td height="24" width="185" valign="top">Google Analytics:</td>
		<td height="24" width="389"><textarea rows="5" name="google_analytics" cols="50"><?=get_setting_data(google_analytics);?></textarea></td>
	</tr>
	<tr>
		<td height="23" width="185">&nbsp;</td>
		<td height="23" width="389"><input type="submit" class="submit" value="Speichern" />
        <input type="reset" class="submit" value="Zur&uuml;cksetzen" name="B4"></td>
	</tr>
</table>
</form>