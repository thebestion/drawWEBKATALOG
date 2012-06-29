<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<div id="cat_seiten">
<h1><?=$p_title?></h1>
<div id="search_container">
<form action="index.php" method="get" name="searchform" id="searchform">
<input type="hidden" name="c" value="seite-suchen" />
<input type="hidden" name="m" value="1" />
<input type="hidden" name="s" value="0" />
<span class="left"></span>
<input type="text" class="text" size="55" name="q" value="<?=$q;?>" />
<span class="right"><input type="submit" tabindex="0" class="submit2" value="suchen"></button></span>
</form>
</div>
<br /><br />
<?=$p_content?>
<br /><br />
<?  
$pageurl="index.php?c=".$cat."&m=".$mod."&s=".$page."&q=".$q."";
$limit="10";
get_search($q);
?>
<br />
</div>

<div id="cont_box">
<a href="seite-eintragen/1.html" rel="nofollow"><img src="templates/<?=get_aktiv_layout_data(layout_path);?>images/addsite.jpg" border="0" alt="Seite Anmelden Webkatalog" /></a>
<br /><br />
</div>
<br /><br />
<div align="center">
<?=$banner_content;?>
</div> 