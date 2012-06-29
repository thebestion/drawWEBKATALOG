<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

if($_GET['m']==1){
# Seite
$bc_link = "<a href='".$page_url."' title='Startseite'>Startseite</a> > ".$gp->getName($cat)."";
}elseif($_GET['m']==2){
# Kategorien
$bc_link = "<a href='".$page_url."' title='Startseite'>Startseite</a> > ".get_alias_to_cat_title($cat)."";
}elseif($_GET['m']==3){
# Sub Kategorien
$bc_link = "<a href='".$page_url."' title='Startseite'>Startseite</a> > <a href='".getCatDownAlias(get_alias_to_cat_id($cat))."/2.html'>".getCatDownName(get_alias_to_cat_id($cat))."</a> > ".get_alias_to_cat_title($cat)." ";
}elseif($_GET['m']==4){
# Details
$bc_link = "<a href='".$page_url."' title='Startseite'>Startseite</a> > Details von: ".getItemLinkById(getUrlBack($cat))."";
}else{ 
# Startseite
$bc_link = $gp->getNameHome();
}

?>