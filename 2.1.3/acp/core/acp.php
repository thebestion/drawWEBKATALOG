<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=get_setting_data(name);?> | drawWEBKATALOG ACP</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="img/style.css" type="text/css">
<link rel="shortcut icon" href="img/fav.ico" />
<script type="text/javascript" src="img/jquery.js"></script>
<script language="javascript" type="text/javascript" src="editor/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
<!--
function popup1(){ $("#popup1").fadeIn(150); $("#popup1").fadeOut(2500); }
function popup2(){ $("#popup2").fadeIn(150); $("#popup2").fadeOut(2500); }
function popup3(){ $("#popup3").fadeIn(150); $("#popup3").fadeOut(2500); }
function zaehle_title(){ formfeld=window.document.editor.Titel.value; window.document.editor.anzeigen_title.value=window.document.editor.Titel.value.length;}
function zaehle_keywords(){formfeld=window.document.editor.keywords.value; window.document.editor.anzeigen_keywords.value=window.document.editor.keywords.value.length;}
function zaehle_beschreibung(){formfeld=window.document.editor.beschreibung.value;window.document.editor.anzeigen_beschreibung.value=window.document.editor.beschreibung.value.length;}
function goto(){var URL = document.form.site.options[document.form.site.selectedIndex].value;window.location.href = URL;}
function gotocat(){var URL = document.form.category.options[document.form.category.selectedIndex].value;window.location.href = URL;}
//-->
</script>
</head>
<body>

<div id="page">
  <table cellpadding="0" cellspacing="0" bordercolor="#111111" width="1004" height="1">
    <tr>
      <td width="604" height="1">
      	<a href="index.php" title="drawWEBKATALOG">
        <img src="img/logo.gif" border="0" id="logo" />
        </a> 
      </td>
      <td width="400" align="right">
      <form action="index.php" method="get"><input type="hidden" value="link_suche" name="s" /><input type="text" size="35" name="q" /><input type="submit" class="submit2" value="Suchen" /></form>
      </td>
    </tr>
    <tr>
      <td width="1004" height="1" colspan="2">
      <ul class="solidblockmenu">
      <li><a href="index.php?s=home" class="<? echo $home; ?>">Dashboard</a></li>
      <li><a href="index.php?s=pages" class="<? echo $site; ?>">Seiten</a></li>
      <li><a href="index.php?s=categories" class="<? echo $cats; ?>">Kategorien</a></li>
      <li><a href="index.php?s=links" class="<? echo $links; ?>">Eintr&auml;ge</a></li>
      <li><a href="index.php?s=layout" class="<? echo $layout; ?>">Templates</a></li>	  
      <li><a href="index.php?s=banner" class="<? echo $banner; ?>">Werbebanner</a></li>
      <li><a href="index.php?s=settings" class="<? echo $settings; ?>">Einstellungen</a></li>
      </ul>   
      </td>
    </tr>
    <tr>
      <td width="1004" height="15" colspan="2">
      
      <div align="right" id="language">
      <a href="index.php?s=logout" title="Logout"><img src="img/logout2.png" border="0" alt="Logout"></a>
      </div>
      
      </td>
    </tr>
    <tr>
      <td bgcolor="#C6C6C6" style="margin: 15px, padding: 15px" width="1004" height="1"  colspan="2">
      <div id="helptooltip"></div>

      <div align="left" style="margin:25px;padding:25px;padding-top:0px;background-color: #FFFFFF;">
	  <div id="subnav">
	  <?
	 if ($page=="categories" OR $page=="cat_offer"){
	 echo'<span><a href="index.php?s=categories" class="'.$sub_cats.'">Kategorie Liste</a></span><span><a href="index.php?s=cat_offer" class="'.$cat_offer.'">Kategorievorschl&auml;ge</a></span>';
	 }elseif ($page=="links" OR $page=="link_free" OR $page=="link_pro" OR $page=="link_cat" OR $page=="link_edit" OR $page=="link_suche"){
	 echo'<span><a href="index.php?s=links" class="'.$sub_links.'">Neue Eintr&auml;ge</a></span><span><a href="index.php?s=link_free" class="'.$sub_link_free.'">Kostenlose Eintr&auml;ge</a></span><span><a href="index.php?s=link_pro" class="'.$sub_link_pro.'">Premium Eintr&auml;ge</a></span><span><a href="index.php?s=link_cat" class="'.$sub_link_cat.'">Eintr&auml;ge nach Kategorien</a></span><span><a href="index.php?s=link_suche" class="'.$sub_link_such.'">Eintrag Suche</a></span>';
	 }elseif ($page=="settings" OR $page=="emails" OR $page=="pw_change" OR $page=="prem_eintrag"){
	 echo'<span><a href="index.php?s=settings" class="'.$sub_settings.'">Einstellungen</a></span><span><a href="index.php?s=emails" class="'.$emails.'">Emails</a></span><span><a href="index.php?s=prem_eintrag" class="'.$prem_eintrag.'">Premium Eintr&auml;ge</a></span><span><a href="index.php?s=pw_change" class="'.$pw_change.'">Passwort &auml;ndern</a></span>';
	 }elseif ($page=="home" OR $page=="" OR $page=="counter" OR $page=="newsletter"){
	 echo'<span><a href="index.php?s=home" class="'.$sub_home.'">Dashboard</a></span><span><a href="index.php?s=counter" class="'.$counter.'">Counter Log</a></span><span><a href="index.php?s=newsletter" class="'.$newsletter.'">Newsletter</a></span>';
	 }
	 

	  echo"</div>";
	  
      #### Auswahl des Contents
      if ($page == "home") { include("core/home.php"); }
      if (($page == "") || !isset($page)) { include("core/home.php"); }
		
	  if ($page == "pages") { include("core/pages.php"); }
      if ($page == "categories") { include("core/categories.php"); }
	  if ($page == "cat_offer") { include("core/cat_offer.php"); }
      if ($page == "links") { include("core/links.php"); }
	  if ($page == "link_free") { include("core/link_free.php"); }
	  if ($page == "link_pro") { include("core/link_pro.php"); }
	  if ($page == "link_cat") { include("core/link_cat.php"); }
	  if ($page == "link_edit") { include("core/link_edit.php"); }
      if ($page == "banner") { include("core/banner.php"); }
      if ($page == "settings") { include("core/settings.php"); }
      if ($page == "catadd") { include("core/cat_add.php"); }
	  if ($page == "catoffer") { include("core/cat_offer.php"); }
	  if ($page == "editor") { include("core/editor.php"); }
      if ($page == "pw_change") { include("core/pw_change.php"); }
	  if ($page == "counter") { include("core/counter.php"); }
	  if ($page == "layout") { include("core/layout.php"); }
	  if ($page == "newsletter") { include("core/newsletter.php"); }
	  if ($page == "link_suche") { include("core/link_suche.php"); }
	  if ($page == "emails") { include("core/emails.php"); }
	  if ($page == "prem_eintrag") { include("core/prem_eintrag.php"); }
	  ?>

      </div> 
      </div>
      </td>
    </tr>
  </table>
  <br />
<div id="drawdesign">
drawWEBKATALOG Engine &copy; <?=date(Y); ?> by <a href="http://www.draw-design.com" target="_blank" title="www.draw-design.com">www.draw-design.com</a>
</div>
 </div>
 
</body>
</html>
