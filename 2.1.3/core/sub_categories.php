<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<div id="cont_box">
<div id="headline">
<div id="headline_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/sign.gif" border="0" /></div>
<div id="headline_right"><h1><? echo get_alias_to_cat_title($cat); ?></h1></div>
</div>
<br clear="left" />
<p><? echo get_alias_to_cat_beschreibung($cat); ?></p>
</div>
<br />

<div id="cont_box">
<div id="headline">
<div id="headline_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/sign.gif" border="0" /></div>
<div id="headline_right"><h1>Seiten von: <? echo get_alias_to_cat_title($cat); ?> im Webkatalog</h1></div>
</div>
<br clear="left" />
</div>

<br />

<div id="cat_seiten">
<?  
$pageurl="".$cat."/".$mod."";
$limit="5";
$orderby="typ";
get_cat($cat);
?>
<br />
</div>

<div id="cont_box">
<a href="seite-eintragen/1.html"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/addsite.jpg" border="0" alt="Seite Anmelden Webkatalog" /></a>
<br /><br />
Nach <strong><? echo get_alias_to_cat_title($cat); ?></strong> suchen auf: <a href="http://www.google.de/search?hl=de&q=<? echo $suchtag; ?>" target="_blank">[Google]</a> <a href="http://www.bing.com/search?q=<? echo $suchtag; ?>" target="_blank">[Bing]</a> <a href="http://search.lycos.de/cgi-bin/pursuit?query=<? echo $suchtag; ?>&cat=web&enc=utf-8" target="_blank">[Lycos]</a> <a href="http://de.search.yahoo.com/search?p=<? echo $suchtag; ?>" target="_blank">[Yahoo]</a>
</div>
<br /><br />
