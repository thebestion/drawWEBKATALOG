<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

# Siten Settings
$page_name=get_setting_data(name);
$page_genre=get_setting_data(gerne); 	
$page_url=get_setting_data(url); 	
$page_email=get_setting_data(email);
$page_ico=get_setting_data(favico);
$page_date=get_setting_data(sitedate); 

// Site Layout Path
$page_layout_path        = "templates/".get_aktiv_layout_data(layout_path);
$page_layout_path_index  = "templates/".get_aktiv_layout_data(layout_index); 
$page_layout_path_img    = "templates/".get_aktiv_layout_data(layout_img);
$page_layout_path_temp   = "templates/".get_aktiv_layout_data(layout_temp); 

// Counter Option
$sitecounter=get_setting_data(counter); // 0=off 1=on

// Path for Upload Data
$page_data_path="media/"; 	

# Banner
$banner_head   = get_banner(get_array_banner("head"),"head");
$banner_content= get_banner(get_array_banner("content"),"content");
$banner_sitenav= get_banner(get_array_banner("sitenav"),"sitenav");

if($_GET['m']==1){
# Seite
$p_name        = $gp->getName($cat);
$p_title       = $gp->getTitle($cat);
$p_content     = $gp->getContent($cat);
$p_file		   = "core/".$gp->getContentFile($cat);
$p_content_opt = $gp->getContentOption($cat);
$p_keywords    = $gp->getKeywords($cat);
$p_description = $gp->getDescription($cat);

# Click On Main Navigation
if($cat=="seite-eintragen"){ $ladd=' class="curred"'; }else{ $ladd=""; }
if($cat=="top-seiten"){ $ltop=' class="curred"'; }else{ $ltop=""; }
if($cat=="neusten-seiten"){ $lnew=' class="curred"'; }else{ $lnew=""; }
if($cat=="seite-suchen"){ $lsuche=' class="curred"'; }else{ $lsuche=""; }
if($cat=="hilfe-seite"){ $lhelp=' class="curred"'; }else{ $lhelp=""; }

}elseif($_GET['m']==2){
# Kategorien
$p_name        = get_alias_to_cat_title($cat);
$p_title       = get_alias_to_cat_title($cat);
$p_content     = get_alias_to_cat_beschreibung($cat);
$p_keywords    = get_alias_to_cat_metakeywords($cat);
$p_description = get_alias_to_cat_metadescription($cat);

}elseif($_GET['m']==3){
# Sub Kategorien
$p_name        = get_alias_to_cat_title($cat);
$p_title       = get_alias_to_cat_title($cat);
$p_content     = get_alias_to_cat_beschreibung($cat);
$p_keywords    = get_alias_to_cat_metakeywords($cat);
$p_description = get_alias_to_cat_metadescription($cat);

}elseif($_GET['m']==4){
# Details
$p_name        = get_link_title_by_id(getUrlBack($cat));
$p_title       = get_link_title_by_id(getUrlBack($cat));
$p_url         = get_link_url_by_id(getUrlBack($cat));
$p_content     = get_link_beschreibung_by_id(getUrlBack($cat));
$p_keywords    = get_link_keywords_by_id(getUrlBack($cat));
$p_description = get_link_beschreibung_by_id(getUrlBack($cat));
}elseif($_GET['m']==5){
# Details
$p_name        = "Eintag Bearbeiten";
$p_title       = "Eintag Bearbeiten - ".get_link_url_by_id(getUrlBack($cat));
$p_url         = get_link_url_by_id(getUrlBack($cat));
$p_content     = "";
$p_keywords    = "";
$p_description = "Eintrag editieren";
}else{ 
# Startseite
$p_name        = $gp->getNameHome();
$p_title       = $gp->getTitleHome();
$p_content     = $gp->getContentHome();
$p_keywords    = $gp->getKeywordsHome();
$p_description = $gp->getDescriptionHome();

if($cat==""){ $lhome=' class="curred"'; }else{ $lhome=""; }
}

?>
