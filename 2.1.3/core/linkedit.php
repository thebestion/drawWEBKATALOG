<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<script language="javascript" type="text/javascript">
<!--
function zaehle_title(){ formfeld=window.document.editor.title.value; window.document.editor.anzeigen_title.value=window.document.editor.title.value.length;}
function zaehle_keys(){formfeld=window.document.editor.keys.value; window.document.editor.anzeigen_keys.value=window.document.editor.keys.value.length;}
function zaehle_text(){formfeld=window.document.editor.text.value;window.document.editor.anzeigen_text.value=window.document.editor.text.value.length;}
//-->
</script>
<h1><?=$p_title;?></h1>

<?
if($_POST['password']) {
$passwort=$_POST['password'];
$linkid=getUrlBack($cat);
linkedit_login($passwort,$linkid);
}

if(session_is_registered('draw_webkatalog_usid') && $_SESSION['draw_webkatalog_linkid'] == getUrlBack($cat)){ 

#echo $data_id = $_SESSION['draw_webkatalog_linkid']."<br />"; 
#echo getUrlBack($cat);
$data_id = $_SESSION['draw_webkatalog_linkid'];

if($_POST['send']=="linkedit"){
$lt_title=$_POST['title'];
$lt_beschreibung=$_POST['text'];
$lt_keywords=$_POST['keys'];

#work_link($data_id,$lt_kategorie,$lt_title,$lt_beschreibung,$lt_keywords);
dbconnect();
$sql_layout_update = "UPDATE `".get_db_table("link")."` SET `titel`='".$lt_title."', `beschreibung`='".$lt_beschreibung."', `keywords`='".$lt_keywords."' ";
$sql_layout_update .= " WHERE `id_link`='".$data_id."'";
mysql_query($sql_layout_update);
}
?>

<div style="padding-left:70px;">
<h1><a href="logout/6.html">Logout</a></h1><br />
<form action="" method="post" name="editor">
<input type="hidden" name="send" value="linkedit">
<img src="http://fadeout.de/thumbshot-pro/?url=<?=get_link_url_by_id($data_id);?>&scale=5" border="0" /><br /><br />

	<b>Titel:</b> (max. 65 Zeichen)<br />
    <input name="title" size="45" onkeyup="javascript:zaehle_title()" value="<?=get_link_title_by_id($data_id);?>" /><br>
      Zeichen z&auml;hlen: <input type="titel" value="<?=strlen(html_entity_decode(get_link_title_by_id($data_id)));?>" name="anzeigen_title" size="2" />
	
    <br /><br /><b>Beschreibung:</b> (max. 255 Zeichen)<br />
    <textarea name="text" onkeyup="javascript:zaehle_text()" id="text" cols="45" rows="5"><?=get_link_beschreibung_by_id($data_id);?></textarea>	<br />Zeichen z&auml;hlen: 
    <input type="beschreibung" value="<?=strlen(html_entity_decode(get_link_beschreibung_by_id($data_id)));?>" name="anzeigen_text" size="2" />

    <br /><br /><b>Schl&uuml;sselworte:</b> (max. 160 Zeichen)<br />
    <textarea name="keys" onkeyup="javascript:zaehle_keys()" id="keys" cols="45" rows="5"><?=get_link_keywords_by_id($data_id);?></textarea><br />
    Zeichen z&auml;hlen: <input type"keywords" value="<?=strlen(html_entity_decode(get_link_keywords_by_id($data_id)));?>" name="anzeigen_keys" size="2" />
    <br /><br />
    <input type="submit" class="submit2" value="Speichern" />
<br /><br />
</div>

<? }else{ ?>


<div id="linkadderr"><?=$fehler;?></div>
<form action="" method="post" name="editor">
<input type="hidden" name="send" value="login">
<input type="hidden" name="linkid" value="<?=getUrlBack($cat);?>">
<div id="field">
<div id="form_tag"><b>Passwort:</b></div>
<div id="form_field"><input type="password" name="password" size="35"> <input type="submit" class="submit2" value="login" /></div>
</div>
</form>
<br /><br /><br /><br />
<div style="padding-left:70px;">
<img border="0" src="http://fadeout.de/thumbshot-pro/?url=<?=get_link_url_by_id(getUrlBack($cat));?>%2F&scale=4" alt="QR Code Button / Icon - QR CODE Script - by ONEURL" width="246" height="300">
</div>
<? } ?>

<br /><br />

<?=$banner_content;?>