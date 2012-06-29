<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
if($_POST['send']=="email"){
$anrede=$_POST['anrede'];
$name=$_POST['name'];
$email=$_POST['email'];
$telefon=$_POST['telefon'];
$mobil=$_POST['mobil'];
$msg=$_POST['msg'];
$mail=get_setting_data("email");
if($name=="") {echo '<div id="error">Bitte tragen Sie einen Namen ein!</div>';}
elseif($email=="") {echo '<div id="error">Keine Emailadresse eingetragen!</div>';}
elseif($msg=="") {echo '<div id="error">Keine Nachricht eingetragen!</div>';}
else {
mail($mail,"Kontakt - ".get_setting_data("url"),"
Anrede: $anrede \n
Name: $name \n
Telefon: $telefon \n
Mobiltelefon: $mobil \n
Emailadresse: $email \n
Anfrage: $msg \n",
"From: $name <$email>");
unset($_POST['anrede']);
unset($_POST['name']);
unset($_POST['email']);
unset($_POST['telefon']);
unset($_POST['mobil']);
unset($_POST['msg']);
echo'<h2><strong>Wir haben Ihre Nachricht empfangen und werden uns umgehend bei Ihnen melden.</strong></h2>';
echo'<p>Sollten wir uns innerhalb der n&auml;chsten 24 Std. nicht melden, dann liegt ein technisches Problem vor. Wir bitten um Ihre Verst&auml;ndnis. Rufen Sie uns an, oder schicken Sie uns eine neue Anfrage zu.</p><br />';
?>
<!-- conversion tracking sniped -->
<?
}
}
?>
<h1>Kontakt</h1>
<p>Wenn Sie Fragen zu unseren Leistungen haben oder einen Beratungstermin vereinbaren m&ouml;chten. Kontaktieren Sie uns einfach &uuml;ber unser Kontaktformular.</p></div>
<div id="contact">
<form name="form" id="contact_add" method="POST" action="">
<input type="hidden" name="send" value="email">
<div id="field">
<div id="form_tag"><b>Anrede:</b></div>
<div id="form_field">
<select size="1" id="anrede" name="anrede">
<option selected value="Herr">Herr</option>
<option value="Frau">Frau</option>
<option value="Firma">Firma</option>
</select>
</div>
</div>

<div id="field">
<div id="form_tag"><b>Name:</b></div>
<div id="form_field"><input type="text" id="name" name="name" size="30" value="" /></div>
</div>

<div id="field">
<div id="form_tag"><b>Email:</b></div>
<div id="form_field"><input type="text" id="email" name="email" size="30" value="" /></div>
</div>

<div id="field">
<div id="form_tag"><b>Telefon:</b></div>
<div id="form_field"><input type="text" id="telefon" name="telefon" size="30" value="" /></div>
</div>

<div id="field">
<div id="form_tag"><b>Mobiltelefon:</b></div>
<div id="form_field"><input type="text" id="mobil" name="mobil" size="30" value="" /></div>
</div>

<div id="field">
<div id="form_tag"><b>Anfrage:</b></div>
<div id="form_field"><textarea rows="10" id="msg" name="msg" cols="50"></textarea></div>
</div>

<div id="field">
<div id="form_tag"></div>
<div id="form_field"><input id="button" type="submit" class="submit" value="Senden" /></div>
</div>

</form>
</div>

<br />
<br />

<?=$banner_content;?>