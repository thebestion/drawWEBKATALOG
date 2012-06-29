<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="install.css" type="text/css">
<title>Install drawWEBKATALOG</title>
</head>
<body>
<div align="center">
<div id="install">
<p><br /><img src="dw-logo.jpg" border="0" alt="drawWEBKATAOG" /></p><br />
<?
include("../configs/config.inc.php");
include("../configs/functions.inc.php");

$i_name = $_POST['name'];
$i_pass = $_POST['pass'];
$i_pass2 = $_POST['pass2'];
$i_url = $_POST['url'];
$i_sitename = $_POST['sitename'];
$i_genre = $_POST['genre'];
$i_email = $_POST['email'];

// MySql Daten anzeigen
echo"<h2>MySql-Daten</h2>";
echo"<p>Daten aus configs/config.inc.php Datei.</p>";
echo "<strong>MySql Host:</strong> ".$DB_HOST."<br>";
echo "<strong>MySql Benutzer:</strong> ".$DB_USER."<br>";
echo "<strong>MySql Passwort:</strong> ".$DB_PWD."<br>";
echo "<strong>Datenbankname:</strong> ".$DB_NAME."<br>";
echo "<strong>Table Prefix:</strong> ".$prefix."<br>";
echo"<h2>Installations Status</h2>";


if($_POST['install']=="1"){
if($i_pass==$i_pass2){
if($i_url!=""){
if($i_url!="http://"){
if($i_name!=""){

// Datenbank anlegen
dbconnect();
if (mysql_query("CREATE DATABASE ".$DB_NAME."")){ echo "Datenbank ".$DB_NAME." wurde angelegt<br>"; }
else{ echo "Datenbank ".$DB_NAME." wurde schon angelegt!<br>"; }



// Table Admin anlegen
$sql_admin = "CREATE TABLE ".$prefix."admin (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	Nickname varchar(55),
	Kennwort varchar(55) )";
dbconnect();
if (mysql_query($sql_admin)){ echo "Table ".$prefix."admin angelegt<br>"; 
dbconnect();
$sql_insert_admin= " INSERT INTO ".$prefix."admin ( Id,Nickname,Kennwort ) VALUES (1, '".$i_name."', '".$i_pass."')";
mysql_query($sql_insert_admin);
}



// Table Banner anlegen
$sql_banner = "CREATE TABLE ".$prefix."banner (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	bannertyp varchar(255),
	bannercode text,
	aktiv varchar(55) DEFAULT '0',
	name varchar(155),
	partner varchar(155) )";
dbconnect();
if (mysql_query($sql_banner)){ echo "Table ".$prefix."banner angelegt<br>"; }



// Table Kategorie anlegen
$sql_categorie = "CREATE TABLE ".$prefix."categorie (
	id_kategorie int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id_kategorie),
	UNIQUE KEY(`alias`),
	id_ober_kategorie int(11) NOT NULL DEFAULT '0',
	alias varchar(70),
	titel varchar(50),
	beschreibung text,
	aufrufe int(10) NOT NULL DEFAULT '0',
	meta_description varchar(200),
	meta_keywords varchar(100),
	aktiv enum('ja','nein') NOT NULL DEFAULT 'nein' )";
dbconnect();
if (mysql_query($sql_categorie)){ echo "Table ".$prefix."categorie angelegt<br>"; }



// Table Kategorie Vorschlag anlegen
$sql_categorie_offer = "CREATE TABLE ".$prefix."categorie_offer (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	offer varchar(255) )";
dbconnect();
if (mysql_query($sql_categorie_offer)){ echo "Table ".$prefix."categorie_offer angelegt<br>"; }



// Table Besucherzaehler anlegen
$sql_counter = "CREATE TABLE ".$prefix."counter (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	date varchar(255),
	ip_adresse varchar(55),
	methode varchar(255),
	call_url varchar(255),
	user_infos varchar(255),
	from_url varchar(255) )";
dbconnect();
if (mysql_query($sql_counter)){ echo "Table ".$prefix."counter angelegt<br>"; }



// Table Bestaestigungsemails anlegen
$sql_counter = "CREATE TABLE ".$prefix."emails (
	free_mail text,
	prem_mail text )";
dbconnect();
if (mysql_query($sql_counter)){ echo "Table ".$prefix."emails angelegt<br>"; 
// Daten von Standard Layout einfuegen
dbconnect();
$sql_insert_emails= "INSERT INTO ".$prefix."emails ( free_mail,prem_mail ) values ('<h1>{webkatalogname}</h1>\r\n<p>Vielen Danke f&uuml;r Ihre Anmeldung in unserem Webkatlog.</p>\r\n<p>Ihre Eintrag ({url}) wurde soeben freigeschaltet.</p>\r\n<p><strong>Profillink:</strong> {profil_url}<br /><strong>Ihr Passwort:</strong> {passwort}</p>', '<h1>{webkatalogname}</h1>\r\n<p>Vielen Danke f&uuml;r Ihre Anmeldung in unserem Webkatlog.</p>\r\n<p>Wir haben Ihre Zahlung erhalten und haben Ihren Eintrag ({url}) soeben freigeschaltet.</p>\r\n<p><strong>Profillink:</strong> {profil_url}<br /><strong>Ihr Passwort:</strong> {passwort}</p>')";
mysql_query($sql_insert_emails);
}



// Table layout anlegen
$sql_layout = "CREATE TABLE ".$prefix."layout (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	layout_name varchar(155),
	layout_path varchar(255),
	layout_index varchar(255),
	layout_img varchar(255),
	layout_temp varchar(255) )";
dbconnect();
if (mysql_query($sql_layout)){ 
echo "Table ".$prefix."layout angelegt<br>"; 
// Daten von Standard Layout einfuegen
dbconnect();
$sql_insert_layout= " INSERT INTO ".$prefix."layout (  Id,layout_name,layout_path,layout_index,layout_img,layout_temp ) values (1, 'drawWEBKATALOG', 'dwk/', 'dwk/index.htm', 'dwk/images/', 'dwk/content_temp/')";
mysql_query($sql_insert_layout);
}



// Table Links anlegen
$sql_link = "CREATE TABLE ".$prefix."link (
	id_link int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id_link),
	id_kategorie varchar(255),
	url varchar(155),
	titel varchar(50),
	beschreibung text,
	typ varchar(55),
	isfreigeschaltet varchar(55), 
	datum varchar(55),
	email varchar(255),
	ratinglink varchar(55),
	keywords varchar(255),
	firma varchar(155),
	name varchar(155),
	strasse varchar(100),
	ort varchar(55),
	passwort varchar(55),
	ip varchar(55))";
dbconnect();
if (mysql_query($sql_link)){ echo "Table ".$prefix."link angelegt<br>"; }



// Table Newsletter anlegen
$sql_newsletter = "CREATE TABLE ".$prefix."newsletter (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	email varchar(255),
	name varchar(155) )";
dbconnect();
if (mysql_query($sql_newsletter)){ echo "Table ".$prefix."newsletter angelegt<br>"; }



// Table System-Seiten anlegen
$sql_page = "CREATE TABLE ".$prefix."page (
	id_page int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id_page),
	UNIQUE KEY(url),
	url varchar(100),
	name varchar(55),
	titel varchar(255),
	text text,
	file varchar(255),
	content_option varchar(255) DEFAULT '0',
	meta_keywords varchar(255),
	meta_beschreibung varchar(255),
	home varchar(55) DEFAULT '0',
	datum varchar(55) )";
dbconnect();
if (mysql_query($sql_page)){ 
echo "Table ".$prefix."page angelegt<br>"; 
// Daten von Standard Startseite einfuegen
dbconnect();
$sql_insert_page1=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (1, 'startseite', 'Startseite', 'drawWEBKATALOG', '<p><strong>Willkommen im drawWEBKATALOG</strong></p>', '0', '0', 'drawWEBKATALOG', 'drawWEBKATALOG', '1', '".get_date()."')";
$sql_insert_page2=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (2, 'seite-eintragen', 'Seite eintragen', 'Seite in Webkatalog eintragen', '<p>Tragen Sie Ihre Seite in unserem Webkatalog ein.</p>', 'linkadd.php', '1', '', '', '0', '".get_date()."')";
$sql_insert_page3=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (3, 'top-seiten', 'Top Seiten', 'Webkatalog Top 100 Seiten', '<p>Hier finden Sie die Top 100 Seiten in unserem Webkatalog. Diese Listung ist nur f&uuml;r Premium Eintr&auml;ge.</p>', 'top100.php', '1', '', '', '0', '".get_date()."')";
$sql_insert_page4=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (4, 'neusten-seiten', 'Neuste Seiten', 'Neue Seiten im Webkatalog ', '<p>Hier finden Sie die neusten Seiten in unserem Webkatalog. Diese Listung ist f&uuml;r alle Eintr&auml;ge.</p>', 'newsites.php', '1', '', '', '0', '".get_date()."')";
$sql_insert_page5=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (5, 'seite-suchen', 'Suchen', 'Seite im Webkatalog suchen', '<p>Suchen Sie in unserem Webkatalog nach Eintr&auml;gen.</p>', 'search.php', '1', '', '', '0', '".get_date()."')";
$sql_insert_page6=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (6, 'hilfe-seite', 'Hilfe', 'drawWebkatalog Hilfe', '<p>Zur Zeit liegen noch keine Fragen vor.</p>', '0', '0', '', '', '0', '".get_date()."')";
$sql_insert_page7=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (7, 'kontakt', 'Kontakt', 'Kontakt', '<p></p>', 'kontakt.php', '1', '', '', '0', '".get_date()."')";
$sql_insert_page8=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (8, 'impressum', 'Impressum', 'Impressum', '<p>Name: <br /> <br /> Internet: http://<br /> E-Mail: <br /> <br /></p>', '0', '0', '', '', '0', '".get_date()."')";
$sql_insert_page9=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (9, 'nutzungsbedingung', 'Nutzungsbedingung', 'Nutzungsbedingung', '<p>Nutzungsbedingung</p>', '0', '0', '', '', '0', '".get_date()."')";
$sql_insert_page10=" INSERT INTO ".$prefix."page ( id_page,url,name,titel,text,file,content_option,meta_keywords,meta_beschreibung,home,datum ) VALUES (10, 'agbs', 'AGBs', 'AGBs', '<p>&sect; AGBs</p>', '0', '0', '', '', '0', '".get_date()."')";

mysql_query($sql_insert_page1);
mysql_query($sql_insert_page2);
mysql_query($sql_insert_page3);
mysql_query($sql_insert_page4);
mysql_query($sql_insert_page5);
mysql_query($sql_insert_page6);
mysql_query($sql_insert_page7);
mysql_query($sql_insert_page8);
mysql_query($sql_insert_page9);
mysql_query($sql_insert_page10);
}



// Table Premium Link Buchung anlegen
$sql_counter = "CREATE TABLE ".$prefix."prem_link (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	id_link varchar(55),
	payday varchar(55),
	prem_end varchar(55),
	prem_remember varchar(55) )";
dbconnect();
if (mysql_query($sql_counter)){ echo "Table ".$prefix."prem_link angelegt<br>"; }



// Table Einstellungen anlegen
$sql_setting = "CREATE TABLE ".$prefix."setting (
	Id int NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(Id),
	UNIQUE KEY(url),
	url varchar(100),
	name varchar(55),
	genre varchar(50),
	email varchar(255),
	sitedate varchar(55), 
	counter varchar(55) DEFAULT '0',
	layout_id varchar(55) DEFAULT '0',
	favico varchar(255),
	google_verify varchar(255),
	google_analytics varchar(255),
	paypal varchar(255) DEFAULT '0',
	prempreis varchar(55) DEFAULT '0.00',
	logo varchar(255) DEFAULT '0' )";
dbconnect();
if (mysql_query($sql_setting)){ 
echo "Table ".$prefix."setting angelegt<br>"; 
// Einstellungen einf�gen
dbconnect();
$sql_insert_setting= " INSERT INTO ".$prefix."setting ( Id,url,name,genre,email,sitedate,counter,layout_id,favico,google_verify,google_analytics,paypal,prempreis,logo ) VALUES
(1, '".$i_url."', '".$i_sitename."', '".$i_genre."', '".$i_email."', '".get_date()."', '0', '1', 'templates/dwk/images/fav.ico', '', '', '', '0.00', 'templates/dwk/images/logo.jpg')";
mysql_query($sql_insert_setting);
}


//echo"<h3>Webkalalog wurde Installiert</h3>";
}else{ $emsg="Bitte geben Sie einen Adminnamen ein."; } // Ob Adminname vorhanden
}else{ $emsg="Geben Sie eine Url an."; } // Ob Url vorhanden
}else{ $emsg="Geben Sie eine Url an."; } // Ob Url vorhanden
}else{ $emsg="&Uuml;berpr&uuml;fen Sie die Passw&ouml;rter."; } // Passwort �bereinstimmung
}
// Wenn Formular gesendet
?>
<form action="" method="post" name="editor">
<input type="hidden" name="install" value="1">
<p><?=$emsg;?></p>
<h2>Admin-Daten</h2>
<div id="field">
<div id="form_tag"><b>Admin-Name:</b></div>
<div id="form_field"><input type="text" name="name" size="45" value="admin"></div>
</div>
<div id="field">
<div id="form_tag"><b>Admin-Passwort:</b></div>
<div id="form_field"><input type="password" name="pass" size="45" maxlength="50" value=""></div>
</div>
<div id="field">
<div id="form_tag"><b>Passwort wiederholen:</b></div>
<div id="form_field"><input type="password" name="pass2" size="45" maxlength="50" value=""></div>
</div>
<p>&nbsp;</p>
<h2>Webkatalog Einstellung</h2>
<div id="field">
<div id="form_tag"><b>Seiten Url:</b></div>
<div id="form_field"><input type="text" name="url" size="45" maxlength="50" value="http://"><br /><em>( Beispiel:http://www.IhreDomain.de )</em></div>
</div>
<div id="field">
<div id="form_tag"><b>Seiten Name:</b></div>
<div id="form_field"><input type="text" name="sitename" size="45" maxlength="50" value=""></div>
</div>
<div id="field">
<div id="form_tag"><b>Seiten Genre:</b></div>
<div id="form_field"><input type="text" name="genre" size="45" maxlength="50" value=""></div>
</div>
<div id="field">
<div id="form_tag"><b>Kontakt Email:</b></div>
<div id="form_field"><input type="text" name="email" size="45" maxlength="50" value=""></div>
</div>
<div id="field">
<div id="form_field"><input type="submit" class="submit" value="Webkatalog Installieren" /></div>
</div>
</form>
</div>
</div>


</body>
</html>
