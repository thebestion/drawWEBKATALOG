<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<h1>Ihr Eintrag war Erfolgreich</h1>
<?  
if($add_eintrag=="premium"){
?>

<p>Herzlichen Gl&uuml;ckwunsch zu Ihrer Wahl f&uuml;r den Premium Eintrag auf <?=$page_url;?>.</p>
<p>Zahlen Sie bequem per &Uuml;berweisung oder per PayPal was den Zahlungsvorgang verk&uuml;rzen w&uuml;rde.</p>
<p>Nach dem Eingang Ihrer Zahlung, schalten wir Ihren Eintrag sofort frei und Sie erhalten von uns eine Rechnung .</p>

<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?=get_setting_data(paypal);?>">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="item_name" value="Premium Eintrag f&uuml;r: <?=$add_url;?>">
<input type="hidden" name="amount" value="<?=get_setting_data(prempreis);?>">
<input type="image" src="templates/<?=get_aktiv_layout_data(layout_path);?>images/paypal.jpg" border="0" name="submit" alt="Jetzt mit PayPal zahlen!">
</form> 

<?
}else{
?>
<p>Wir haben Ihren Seiten Vorschlag erhalten. Nach prüfung Ihrer Daten, werden wir Ihre Seite in unserem Webkatalog freischalten.</p>
<?
}
?>
<p>&nbsp;</p><p>&nbsp;</p>
<div align="center">
<?=$banner_content;?>
</div>