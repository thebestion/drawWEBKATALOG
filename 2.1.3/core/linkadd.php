<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

$fehler=""; 
$add_url="http://";
$formOK="0";



function get_page_id_last() {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." ORDER BY id_link DESC Limit 1 ");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_idlast = $row_title['id_link'];
}
return $page_idlast+1;
}

#echo get_page_id_last();

if($_POST['send']==""){

include("core/addform.php");

}elseif($_POST['send']=="1"){

$add_eintrag=$_POST[eintrag];
$add_url=stripslashes($_POST[url]);
$add_cat=stripslashes($_POST[category]);
$add_cat_offer=stripslashes($_POST[cat_offer]);

$add_cat_offer=stripslashes($_POST[cat_offer]);
if($add_url=="" OR $add_url=="http://") { $fehler.="Bitte geben Sie eine URL ein!<br>"; $urlOK="0"; } else { $urlOK="1"; }
if($add_cat=="0") { $fehler.="Bitte w&auml;hlen Sie eine Kategorie!<br>"; $catOK="0"; } else { $catOK="1"; }

if($urlOK=="1" and  $catOK=="1"){ 
$add_title=getUrlData($add_url,"title");
$add_keys=getUrlData($add_url,"keywords");
$add_text=getUrlData($add_url,"description");
include("core/addform2.php"); 
}else{
include("core/addform.php");
}

if($add_cat_offer != ""){
dbconnect();
$sql_cat_offer= " INSERT INTO ".get_db_table("categorie_offer")." ( Id,offer) values (  '', '".$add_cat_offer."' )";
mysql_query($sql_cat_offer);
}

}elseif($_POST['send']=="2"){

$add_eintrag=$_POST[eintrag];
$add_url=stripslashes($_POST[url]);
$add_cat=stripslashes($_POST[category]); 
$add_title=stripslashes($_POST[title]);
$add_text=stripslashes($_POST[text]);
$add_keys=stripslashes($_POST[keys]);
$add_email=stripslashes($_POST[email]);
$add_abg=stripslashes($_POST[agb]);
$add_news=stripslashes($_POST[news]);
$add_firma=stripslashes($_POST[firma]);
$add_name=stripslashes($_POST[name]);
$add_strasse=stripslashes($_POST[strasse]);
$add_ort=stripslashes($_POST[ort]);
$add_email=stripslashes($_POST[email]);
$add_date=get_date();
$add_passwort=getCaptchaCode();
$add_ip=get_IP();

if($add_url=="" OR $add_url=="http://") { $fehler.="Bitte geben Sie eine URL ein!<br>"; $urlOK="0"; } else { $urlOK="1"; }
if($add_cat=="0") { $fehler.="Bitte w&auml;hlen Sie eine Kategorie!<br>"; $catOK="0"; } else { $catOK="1"; }

if($add_title=="") { $fehler.="Bitte geben Sie einen Titel ein!<br>"; $titleOK="0"; } else { $titleOK="1"; }
if($add_text=="") { $fehler.="Bitte geben Sie eine Beschreibung ein!<br>"; $textOK="0"; } else { $textOK="1"; }
if($add_keys=="") { $fehler.="Bitte geben Sie Schl&uuml;sselworte für die Suche ein!<br>"; $keysOK="0"; } else { $keysOK="1"; }
if($add_name=="") { $fehler.="Bitte geben Sie Ihren Namen ein!<br>"; $nameOK="0"; } else { $nameOK="1"; }
if($add_strasse=="") { $fehler.="Bitte geben Sie Ihren Strassennamen ein!<br>"; $strasseOK="0"; } else { $strasseOK="1"; }
if($add_ort=="") { $fehler.="Bitte geben Sie Ihren Wohnort ein!<br>"; $ortOK="0"; } else { $ortOK="1"; }
if($add_email=="") { $fehler.="Bitte geben Sie Ihre Emailadresse ein!<br>"; $mailOK="0"; } else { $mailOK="1"; }
if(countEmail($add_email)=="1") { $fehler.="Diese Emailadresse wird schon verwendet!<br>"; $mail2OK="0"; } else { $mail2OK="1"; }
if($add_abg=="") { $fehler.="Bitte best&auml;tigen Sie unsere AGBs!<br>"; $agbOK="0"; } else { $agbOK="1"; }

if($urlOK=="1" and  $catOK=="1" and $titleOK=="1" and $textOK=="1" and $keysOK=="1" and $nameOK=="1" and $strasseOK=="1" and $ortOK=="1" and $mailOK=="1" and $mail2OK=="1" and $agbOK=="1"){
if($add_eintrag=="kostenlos"){ $add_type="0"; }elseif($add_eintrag=="premium"){ $add_type="1"; }

# id_link 	id_kategorie 	url 	titel 	beschreibung 	typ 	isfreigeschaltet 	datum 	email 	ratinglink 	keywords 	firma 	name 	strasse 	ort 	passwort 	ip

dbconnect();
$sql_modul_insert= " INSERT INTO ".get_db_table("link")." ( id_link,id_kategorie,url,titel,beschreibung,typ,isfreigeschaltet,datum,email,ratinglink,keywords,firma,name,strasse,ort,passwort,ip ) values (  '".get_page_id_last()."', '".$add_cat."', '".$add_url."', '".$add_title."', '".$add_text."', '".$add_type."', '0', '".$add_date."', '".$add_email."', '0', '".$add_keys."', '".$add_firma."', '".$add_name."', '".$add_strasse."', '".$add_ort."', '".$add_passwort."', '".$add_ip."' )";
mysql_query($sql_modul_insert);


if($add_news == "1"){
dbconnect();
$sql_add_news= " INSERT INTO ".get_db_table("newsletter")." ( Id,email,name) values ( '', '".$add_email."', '".$add_name."' )";
mysql_query($sql_add_news);
}

$formOK="1";
include("core/addtemp.php");

}else{ include("core/addform2.php"); }

}else{ if($formOK="0"){ include("core/addform.php");}  }

?>