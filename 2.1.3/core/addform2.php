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

<h1><?=$p_title?> - Schritt 2</h1>
<p><strong>Ihre IP-Adresse: <?=get_IP();?></strong></p>
<div id="linkadderr"><?=$fehler?></div>
<form action="" method="post" name="editor">
<input type="hidden" name="send" value="2">
<input type="hidden" name="category" value="<?=$add_cat;?>">
<input type="hidden" name="eintrag" value="<?=$add_eintrag;?>">

<hr size="1" color="#999999"><br>

<h1>Seitendaten:</h1>

<div id="field">
<div id="form_tag"><b>Url (mit <i>http://</i>):</b></div>
<div id="form_field"><input type="text" name="url" size="45" value="<?=$add_url;?>"></div>
</div>


<div id="field">
<div id="form_tag"><b>Titel:</b><br />(max. 65 Zeichen)</b></div>
<div id="form_field"><input type="text" name="title" onKeyUp="javascript:zaehle_title()" size="45" maxlength="95" value="<?=$add_title;?>"><br>
Zeichen:&nbsp;<input type="text" value="<?=strlen(html_entity_decode($add_title));?>" name="anzeigen_title" size="2" maxlength="3"></div>
</div>

<div id="field">
<div id="form_tag"><b>Beschreibung:</b><br />(max. 255 Zeichen)</b></div>
<div id="form_field"><textarea name="text" onKeyUp="javascript:zaehle_text()" rows="6" maxlength="255" cols="40"><?=$add_text?></textarea><br>
Zeichen:&nbsp;<input type="text" value="<?=strlen(html_entity_decode($add_text));?>" name="anzeigen_text" size="2" maxlength="3">
</div>
</div>

<div id="field">
<div id="form_tag"><b>Schl&uuml;sselworte:</b><br />(max. 160 Zeichen)</b></div>
<div id="form_field"><textarea name="keys" onKeyUp="javascript:zaehle_keys()" rows="6" maxlength="160" cols="40"><?=$add_keys?></textarea><br>
Zeichen:&nbsp;<input type="text" value="<?=strlen(html_entity_decode($add_keys));?>" name="anzeigen_keys" size="2" maxlength="3">
</div>
</div>

<h1>Benutzerdaten:</h1>

<div id="field">
<div id="form_tag"><b>Firma:</b></div>
<div id="form_field"><input type="text" size="45" name="firma" value="<?=$add_firma?>">
</div>
</div>

<div id="field">
<div id="form_tag"><b>Name:*</b></div>
<div id="form_field"><input type="text" size="45" name="name" value="<?=$add_name?>">
</div>
</div>

<div id="field">
<div id="form_tag"><b>Strasse:*</b></div>
<div id="form_field"><input type="text" size="45" name="strasse" value="<?=$add_strasse?>">
</div>
</div>

<div id="field">
<div id="form_tag"><b>Plz / Ort:*</b></div>
<div id="form_field"><input type="text" size="45" name="ort" value="<?=$add_ort?>">
</div>
</div>

<div id="field">
<div id="form_tag"><b>Email:*</b></div>
<div id="form_field"><input type="text" size="45" name="email" value="<?=$add_email?>">
</div>
</div>

<div id="field">
<div id="form_tag"><b>AGB:</b></div>
<div id="form_field"><input type="checkbox" value="1" name="agb">&nbsp;&nbsp;<a href="<?=$page_url?>/agbs/1.html" target="blank"><u>AGB</u></a> gelesen und akzeptiert!
</div>
</div>

<div id="field">
<div id="form_tag"><b>Newsletter:</b></div>
<div id="form_field"><input type="checkbox" value="1" name="news">&nbsp;<b>Newsletter anmelden!</b>
</div>
</div>

<div id="field">
<div id="form_field"><input type="submit" class="submit" value="Seite Anmelden" /></div>
</div>
</form>