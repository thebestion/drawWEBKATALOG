<br /><br /><br />
<div id="popup1" class="msg"><h3>Eintrag wurde aktualisiert!</h3></div>
<?
######## DELETE Link ##############
if($subpage=="del") {
include("core/del_new_link.htm");
if($delquest=="YES") { del_link($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=links'>"; }
}


############ Eintrag aktualisieren ##############
if($_POST['send']=="update"){

$p_rating=$_POST['rating'];
$p_category=$_POST['category'];
$p_url=$_POST['url'];
$p_Titel=$_POST['Titel'];
$p_beschreibung=$_POST['beschreibung'];
$p_typ=$_POST['typ'];
$p_keywords=$_POST['keywords'];
$p_firma=$_POST['firma'];
$p_name=$_POST['name'];
$p_strasse=$_POST['strasse'];
$p_ort=$_POST['ort'];
$p_email=$_POST['email'];

dbconnect();
$sql_layout_update = "UPDATE `".get_db_table("link")."` SET `id_kategorie`='".$p_category."', `url`='".$p_url."', `titel`='".$p_Titel."', `beschreibung`='".$p_beschreibung."', `typ`='".$p_typ."', `email`='".$p_email."', `ratinglink`='".$p_rating."', `keywords`='".$p_keywords."', `firma`='".$p_firma."', `name`='".$p_name."', `strasse`='".$p_strasse."', `ort`='".$p_ort."' ";
$sql_layout_update .= " WHERE `id_link`='".$pageid."'";
mysql_query($sql_layout_update);

echo '<script type="text/javascript">window.onload=popup1;</script>';
}
?>

<form action="" method="post" name="editor" class="form">
<input type="hidden" name="send" value="update">

<div class="linkedit">	
<table border="0" cellpadding="0" cellspacing="0" width="860">
<tr>
	<td width="430px" height="15">
    <span><a href="index.php?s=link_edit&p=<?=$pageid;?>&a=del&ps=<?=$pagesite;?>" title="Eintrag l&ouml;schen"><img src="img/del.png" id="del_icon" border="0" /></a></span>
    <? if(get_link_aktiv_by_id($pageid)=="0"){ ?>
    <span><a href="index.php?s=links&p=<?=$pageid;?>&a=aktiv&ps=<?=$pagesite;?>" title="Eintrag freischalten"><img src="img/add.png" border="0" /></a></span> 
    <? } ?>
    </td>
   	<td width="430px" height="15px"><div align="right"><input type="submit"  class="submit" value="Eintrag Speichern" /></div></td>
</tr>
</table>
</div>

<hr size="1" color="#999999"><br>

<div class="linkedit">

<table border="0" cellpadding="0" cellspacing="0" width="740">
<tr>
	<td width="370px" height="35px">
    	<? if(get_link_aktiv_by_id($pageid)=="0"){ $status="Nicht Aktiv"; }else{ $status="Aktiv"; } ?>
		<p><strong>Status:</strong> <?=$status; ?></p>
        <p><strong>Datum:</strong> <?=get_link_datum($pageid); ?></p>
        <p><strong>IP-Adresse:</strong> <?=get_link_ip($pageid); ?></p>
		<p><strong>Passwort:</strong> <?=get_link_passwort($pageid); ?></p>
    </td>
   	<td width="370px" height="35px">
    <? if(get_link_typ($pageid)=="0"){ $itempic="item_free.png"; $ddc = '<option value="0">Kostenloser Eintrag</option><option value="1">Premium Eintrag</option>'; 
	}else{ $itempic="item_prem.png"; $ddc = '<option value="1">Premium Eintrag</option><option value="0">Kostenloser Eintrag</option>'; } ?>
        <p><img src="img/<?=$itempic;?>" border="0" /></p>
        <p><select name="typ"><?=$ddc;?></select></p>    
    </td>
</tr>
<tr>
	<td width="370px" height="35px">
    <h3>Seitendaten:</h3>
    </td>
    <td width="370px" height="35px"></td>
</tr>
<tr>
	<td width="370px" height="35px">
    	<div id="field">
        <div id="form_tag"><b>Kategorie:</b></div>
        <div id="form_field">
        <? getCategorieDropdownUpdate($pageid); ?>
        </div>
        </div>
    </td>
   	<td width="370px" height="35px">
    <p><strong>Linkrating:</strong> 
    <select name="rating">
    <option value="<?=get_link_ratinglink($pageid); ?>"><?=get_link_ratinglink($pageid); ?></option>
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    </select></p>
    </td>
</tr>
<tr>
	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><b>Url (mit <i>http://</i>):</b></div>
    <div id="form_field"><input type="text" name="url" size="45" value="<?=get_link_url($pageid); ?>"></div>
    </div>
    </td>
   	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><br /><b>Titel:</b> (max. 65 Zeichen)</div>
    <div id="form_field"><input name="Titel" size="45" onkeyup="javascript:zaehle_title()" value="<?=get_link_title($pageid); ?>" /><br>
      Zeichen z&auml;hlen: <input type="titel" value="<? echo strlen(html_entity_decode(get_link_title($pageid)));?>" name="anzeigen_title" size="2" /></div>
    </div>
    </td>
</tr>
<tr>
	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><br />
    <b>Beschreibung:</b> (max. 255 Zeichen)</div>
    <div id="form_field"> 
    <textarea name="beschreibung" onkeyup="javascript:zaehle_beschreibung()" id="beschreibung" cols="45" rows="5"><?=get_link_description($pageid); ?></textarea>
    <br>Zeichen z&auml;hlen: 
    <input type="beschreibung" value="<? echo strlen(html_entity_decode(get_link_description($pageid)));?>" name="anzeigen_beschreibung" size="2" />
    </div>
    </div>
    </td>
   	<td width="370px">
    <div id="field">
    <div id="form_tag"><br />
    <b>Schl&uuml;sselworte:</b> (max. 160 Zeichen)</div>
    <div id="form_field">  
    <textarea name="keywords" onkeyup="javascript:zaehle_keywords()" id="keywords" cols="45" rows="5"><?=get_link_keywords($pageid); ?></textarea><br>
    Zeichen z&auml;hlen: <input type"keywords" value="<? echo strlen(html_entity_decode(get_link_keywords($pageid)));?>" name="anzeigen_keywords" size="2" />
    </div>
    </div>
    </td>
</tr>
<tr>
	<td width="370px" height="35px">
    <h3>Benutzerdaten:</h3>
    </td>
    <td width="370px" height="35px"></td>
</tr>
<tr>
	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><b>Firma:</b></div>
    <div id="form_field"><input type="text" size="45" name="firma" value="<?=get_link_firma($pageid); ?>">
    </div>
    </div>
    </td>
   	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><b>Name:</b></div>
    <div id="form_field"><input type="text" size="45" name="name" value="<?=get_link_name($pageid); ?>">
    </div>
    </div>
    </td>
</tr>
<tr>
	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><br /><b>Strasse:</b></div>
    <div id="form_field"><input type="text" size="45" name="strasse" value="<?=get_link_strasse($pageid); ?>">
    </div>
    </div>
    </td>
   	<td width="370px" height="35px">
    <div id="field">
    <div id="form_tag"><br /><b>Plz / Ort:</b></div>
    <div id="form_field"><input type="text" size="45" name="ort" value="<?=get_link_ort($pageid); ?>">
    </div>
    </div>
    </td>
</tr>
<tr>
	<td width="370px" height="35px"><div id="field">
    <div id="form_tag"><br /><b>Email:</b></div>
    <div id="form_field"><input type="text" size="45" name="email" value="<?=get_link_email($pageid);?>">
    </div>
	</div>
    </td>
   	<td width="370px" height="35px"></td>
</tr>
</table>


</div>

</form>        



<br><br>
