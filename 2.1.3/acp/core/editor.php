<div id="popup1" class="msg"><h3>Seite wurde aktualisiert!</h3></div>
<?
if($_GET["p"]!='') {

$work_page=htmlentities($_GET["p"]);
$site_name=htmlentities($_POST['Name_Link']);
$site_name2=$_POST['Name_Url'];
$site_titel=htmlentities($_POST['Titel']);
$site_keywords=htmlentities($_POST['keywords']);
$site_beschreibung=htmlentities($_POST['beschreibung']);
$site_content=$_POST['elm1'];
$contentoption=$_POST['contentoption'];
$contentdatei=$_POST['contentdatei'];
$sitelastmod=date("Y-m-d");

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
  
    # check and upload file
    if(!empty($_FILES['uploaddata']['name'])) {
    $upload_dir="../core/";
    move_uploaded_file($_FILES['uploaddata']['tmp_name'],$upload_dir.$_FILES['uploaddata']['name']);
    $upload_data=$_FILES['uploaddata']['name'];    
    }else {    
    if($contentdatei=="0") { $upload_data="0"; }else{ $upload_data=$contentdatei; }    
    }	

    # update site content
   
   #            url 	name 	titel 	text 	file 	content_option 	meta_keywords 	meta_beschreibung 	home 	datum
   
	dbconnect();
    $sql_site_update = "UPDATE `".get_db_table("page")."` SET `url`='".$site_name2."', `name`='".$site_name."', `titel`='".$site_titel."', `text`='".$site_content."', `file`='".$upload_data."', `content_option`='".$contentoption."', `meta_keywords`='".$site_keywords."', `meta_beschreibung`='".$site_beschreibung."', `datum`='".$sitelastmod."'  ";
	$sql_site_update .= " WHERE `id_page`='".$work_page."' ";
    mysql_query($sql_site_update) OR die("error");
	echo '<script type="text/javascript">window.onload=popup1;</script>';
}

    $sName          = get_page_name_by_id($work_page);
	$sUrl           = get_page_url_by_id($work_page);
    $sTitle         = get_page_title_by_id($work_page);
    $sContent       = get_page_content_by_id($work_page);
    $sUpload        = get_page_upload_by_id($work_page);
    $sOption        = get_page_option_by_id($work_page);
	$mkeywords      = get_page_keywords_by_id($work_page);
	$mbeschreibung  = get_page_beschreibung_by_id($work_page);
	$slastmod		= get_page_date_by_id($work_page);

if($sOption=="1") { $check_1="checked"; } else{ $check_1=""; }
if($sOption=="0") { $check_2="checked"; } else{ $check_2=""; }
if($sUpload=="" || $sUpload=="0") { $uploadlist='<option value="0">Keine Daten</option>'; } else { $uploadlist="<option value='".$sUpload."'>".$sUpload."</option>"; }

?>
<script language="javascript" type="text/javascript">  
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "elm1",
    plugins : "style,table,advhr,advimage,insertdatetime,paste,fullscreen,noneditable,visualchars,",
    theme_advanced_toolbar_location : "top",
    theme_advanced_buttons1 : "fullscreen,bold,italic,underline,strikethrough,separator,"
    + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,hr,advhr,bullist,numlist,outdent,indent",
    theme_advanced_buttons2 : "link,unlink,anchor,image,separator,undo,redo,cleanup,code,separator,sub,sup,charmap,insertdate,inserttime,",
    theme_advanced_buttons3 :"",
    height:"350px",
    width:"904px",
  });
</script>
<br /><br /><br />
<div class='buttonwrapper'>
<a class='boldbuttons' href='index.php?s=pages'><span>Zur&uuml;ck zur Seiten Verwaltung</span></a>
<a class='boldbuttons' href='<?=get_setting_data('url'); ?>/<?=$sUrl; ?>/1.html' target="_blank"><span>Seiten Vorschau</span></a>
<span><div style="padding-top:8px;"><? get_site_tree(); ?></div></span></div>
<form enctype="multipart/form-data" method="post" action="" name="editor">
 <input type="hidden" name="send" value="1">
  <br /><br />
  <div id="editor_head">
  <div id="editor_head_left">
  <strong>Letzte &Auml;nderung</strong> <? echo $slastmod; ?></div>
  <div id="editor_head_right">
  <input type="submit" class="submit" name="save" value="Speichern" />
  <input type="reset" class="submit" name="reset" value="Zur&uuml;cksetzen" />
  </div>
  </div>
  <br clear="left" />
  <hr size="1" color="#a9a9a9"><br />
  <strong>Seiten Name:</strong><br />
  <input name="Name_Link" size="60" value="<? echo $sName;?>" />
  <br /><br />
  <strong>Seiten Url:</strong><br />
  <input name="Name_Url" size=60" value="<? echo $sUrl;?>" />
  <br /><br />
  <strong>Seiten Title</strong><br />
  <input name="Titel" onkeyup="javascript:zaehle_title()" size="60" value="<? echo $sTitle;?>" /><br>
  Zeichen z&auml;hlen: <input type="titel" value="<? echo strlen(html_entity_decode($sTitle));?>" name="anzeigen_title" size="2" />
  <br /><br />
  
  <div style="float:left; width:300px; padding-right:15px;">
  <strong>Meta-Keywords</strong><br />
  <textarea name="keywords" onkeyup="javascript:zaehle_keywords()" id="keywords" cols="35" rows="5"><? echo $mkeywords;?></textarea><br>
  Zeichen z&auml;hlen: <input type"keywords" value="<? echo strlen(html_entity_decode($mkeywords));?>" name="anzeigen_keywords" size="2" />
  </div>

  <div style="float:left; width:300px; padding-right:15px;">
  <strong>Meta-Description</strong><br />
  <textarea name="beschreibung" onkeyup="javascript:zaehle_beschreibung()" id="beschreibung" cols="35" rows="5"><? echo $mbeschreibung;?></textarea><br>
 Zeichen z&auml;hlen: <input type="beschreibung" value="<? echo strlen(html_entity_decode($mbeschreibung));?>" name="anzeigen_beschreibung" size="2" />
 <i></i>
  </div>
  
  <br clear="left" /><br /><hr size="1" color="#a9a9a9"><br />
   
  <input type="radio" value="1" name="contentoption" <? echo $check_1;?> >
  Datei Upload:<br /><br />
  <input type="file" name="uploaddata" size="20">
  <br /><br />
  <select size="1" name="contentdatei">
  <? echo $uploadlist;?>
  <option value="0">Keine Datei ausgew&auml;lt</option>
  <? get_upload_file_list();?>
  </select>
  <br /><br /><hr size="1" color="#a9a9a9"><br />
  <input type="radio" value="0" name="contentoption" <? echo $check_2;?> >Editor:<br /><br />
  <textarea id="elm1" name="elm1" cols="145" rows="25"><? echo $sContent;?></textarea>
  <br /><br />
</form>
<? 
} else { echo"<h2>".EDT_NO_PAGE."</h2>";}
?>