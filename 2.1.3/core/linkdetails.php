<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<style type="text/css">
#linkdetails ul{
padding:0px;
margin:0px;
}

#linkdetails li{
list-style:none;
}
</style>
<h1>Details: </h1>
<table border="0" width="560px" cellpadding="0" cellspacing="0">
<tr>
<td width="560px">
<h1><a href="<?=$p_url;?>" target="_blank" title="<?=$p_title;?>"><?=$p_title;?></a></h1>
</td>
</tr>
<tr>
<td width="560px" colspan="2">
<strong>Beschreibung:</strong><br />
<?=$p_content;?><br /><br />
<ul id="linkdetails">
<li><strong>Kategorie:</strong> <?=get_cat_name_by_id(get_cat_id_by_linkid(getUrlBack($cat)));?></li>
<li><strong>Datum:</strong> <?=get_link_datum_by_id(getUrlBack($cat));?></li>
<li><strong>Listing Rank:</strong> <?=get_link_rating_by_id(getUrlBack($cat));?></li>
</ul><br />
<strong>Url:</strong><br />
<a href="<?=$p_url;?>" target="_blank" rel="nofollow"><?=$p_url;?></a>

<br /><br />

</td>
</tr>
<tr>
<td width="280px">
<a href="<?=$p_url;?>" target="_blank" rel="nofollow">
<img border="0" src="http://fadeout.de/thumbshot-pro/?url=<?=urlencode($p_url); ?>&scale=4" alt="<?=$p_title;?>" width="246" height="300">
</a>
<br /><br />
<a rel="nofollow" href="<? echo getUrlBack($cat)."-linkedit"; ?>/5.html" title="Eintrag bearbeiten"><strong>Eintrag bearbeiten</strong></a>
</td>
<td width="280px" valign="top">
</td>
</tr>
</table>