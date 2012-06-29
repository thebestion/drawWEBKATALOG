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
<div id="headline_right"><h1><?=$p_title;?></h1></div>
</div>
<br clear="left" />
<?=$p_content; ?>
<br /><br />
<div id="headline">
<div id="headline_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/sign.gif" border="0" /></div>
<div id="headline_right"><h1>Unterkategorien von: <?=$p_title;?></h1></div>
</div>
<br clear="left" />
</div>



<div id="cat">
<?  
$i="0";
dbconnect();
$sql_cat="SELECT * FROM ".get_db_table("categorie")." WHERE aktiv = 'ja' AND id_ober_kategorie = '".get_alias_to_cat_id($cat)."' ORDER BY titel ASC ";
$query_cat=mysql_query($sql_cat);
while($get_cat = mysql_fetch_assoc($query_cat)){
    $zahl = $i++;
    if ($zahl % 2 != 0) { $tab_br="<br clear='left' />"; } else { $tab_br=""; }
	$get_cat_id=$get_cat['id_kategorie'];
?>  
<div id="cat_item">
<div id="cat_item_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/dicpic.jpg"></div>
<div id="cat_item_right">
<a href="<? echo $page_url."/".$get_cat['alias']; ?>/3.html" class="link"><strong><? echo $get_cat['titel']; ?></strong></a> (<? echo get_count_cat_links($get_cat_id); ?>)<br />
</div>
</div>
<?
echo $tab_br;
}
?>
</div>

<br clear="left" /><br />

<div id="cont_box">
<div id="headline">
<div id="headline_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/sign.gif" border="0" /></div>
<div id="headline_right"><h1>Seiten von: <?=$p_title;?> im Webkatalog</h1></div>
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
<a href="seite-eintragen/1.html" rel="nofollow"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/addsite.jpg" border="0" alt="Seite Anmelden Webkatalog" /></a>
<br /><br />
Nach <strong><?=$p_title;?></strong> suchen auf: <a href="http://www.google.de/search?hl=de&q=<? echo $suchtag; ?>" target="_blank" rel="nofollow">[Google]</a> <a href="http://www.bing.com/search?q=<? echo $suchtag; ?>" target="_blank" rel="nofollow">[Bing]</a> <a href="http://search.lycos.de/cgi-bin/pursuit?query=<? echo $suchtag; ?>&cat=web&enc=utf-8" target="_blank" rel="nofollow">[Lycos]</a> <a href="http://de.search.yahoo.com/search?p=<? echo $suchtag; ?>" target="_blank" rel="nofollow">[Yahoo]</a>
</div>
<br /><br />
