<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<div id="cont_box">
<h1><strong><?=$p_title;?></strong></h1>

<div id="search_container">
<form action="index.php" method="get" name="searchform" id="searchform">
<input type="hidden" name="c" value="seite-suchen">
<input type="hidden" name="m" value="1">
<input type="hidden" name="s" value="0">
<span class="left"></span>
<input type="text" class="text" size="55" name="q" value="<?=$sq;?>">
<span class="right"><input type="submit" tabindex="0" class="submit2" value="suchen"></button></span>
</form>
</div>

<p></p>
<h2><strong>Kategorien - Webkatalog</strong></h2><br>
</div>

<div id="cat">
<? 

$i="0";
dbconnect();
$sql_cat="SELECT * FROM ".get_db_table("categorie")." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$query_cat=mysql_query($sql_cat);
while($get_cat = mysql_fetch_assoc($query_cat)){
    $zahl = $i++;
    if ($zahl % 2 != 0) { $tab_br="<br clear='left'>"; } else { $tab_br=""; }
	$get_cat_id=$get_cat['id_kategorie'];
	
	$alllinksincat = get_count_cat_links($get_cat_id)+countallsubcatlinks($get_cat_id);
?>  
<div id="cat_item">
<div id="cat_item_left"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/dicpic.jpg"></div>
<div id="cat_item_right">
<a href="<?=$page_url."/".$get_cat['alias']; ?>/2.html" class="link"><strong><?=$get_cat['titel']; ?></strong></a> (<?=$alllinksincat; ?>)<br />
<div id="prew_sub_cats"><?=get_sub_cat($get_cat_id); ?>...</div></div>
</div>
<?
echo $tab_br;
}
?>
</div>

<br clear="left"><br>

<div id="cont_box">
<?=$p_content;?>
</div>

<br><br>
<div align="center">
<!-- Banner Main -->
<?=$banner_content;?>
</div>
<br>
