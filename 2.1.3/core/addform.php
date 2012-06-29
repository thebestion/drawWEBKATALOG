<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<h1><?=$p_title?> - Schritt 1</h1>
<?=$p_content?><br />
<div id="linkadderr"><?=$fehler?></div>
<hr size="1" color="#999999">
<form action="" method="post" name="editor">
<input type="hidden" name="send" value="1">
<input type="radio" name="eintrag" checked="checked" value="kostenlos"> <font size=4><b>Kostenloser Eintrag</b></font><br />(Keine garantierte Eintragung Ihrer Seite in unserem Verzeichnis!)</p>
<p><input type="radio" name="eintrag" value="premium"><font size=4><b>Premium Eintrag</b></font><br />(Garantierte Eintragung Ihrer Seite in unserem Verzeichnis!)<br /><br />
<strong>Ihr Eintrag wird zus&auml;tzlich:</strong><br />
- farblich hervorgehoben.<br />
- mit einem Thumbnail von Ihrer Seite angezeigt.<br />
- in der jeweiligen Kategorie oben angezeigt.<br />
- unter Top Seiten gelistet.<br />
- Backlink frei aufgenommen.<br />
<br />
<strong>F&uuml;r nur <?=get_setting_data(prempreis);?> Euro im Jahr*.</strong></p>
<hr size="1" color="#999999">

<div id="field">
<div id="form_tag"><b>Webseite:</b></div>
<div id="form_field"><input type="text" name="url" size="45" value="<?=$add_url;?>"></div>
</div>

<div id="field">
<div id="form_tag"><b>Kategorie:</b></div>
<div id="form_field"><? getCategorieDropdown(); ?></div>
</div>

<div id="field">
<div id="form_tag"><b>Kategorie Vorschlag:</b></div>
<div id="form_field"><input type="text" name="cat_offer" size="45" maxlength="50" value="<?=$add_cat_offer;?>"></div>
</div>

<div id="field">
<div id="form_field"><input type="submit" class="submit" value="Weiter" /></div>
</div>

</form>
<p>
<a href="<?=$page_url;?>/werbemittel/1.html"><strong>Wir w&uuml;rden uns freuen, wenn Sie auf Ihre Webseite einen Backlink zu uns setzen w&uuml;rden.</strong></a></p>

<br /><br />

<div align="center">
<?=$banner_content;?>
</div>