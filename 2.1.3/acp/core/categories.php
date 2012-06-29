<?
$send=$_POST['send'];


####### Kategorie hinzufügen #########
if($subpage=="add") {
include("core/cat_add.html");
if($send=="add") { 
$caktiv=$_POST['aktiv'];
$ctopcategory=$_POST['topcategory'];
$ctitel=$_POST['titel'];
$calias=$_POST['alias'];
$cbeschreibung=$_POST['beschreibung'];
$cdescription=$_POST['description'];
$ckeywords=$_POST['keywords'];
dbconnect();
$sql_add_node= " INSERT INTO ".get_db_table("categorie")." ( id_kategorie,id_ober_kategorie,alias,titel,beschreibung,aufrufe,meta_description,meta_keywords,aktiv ) values (  '', '".$ctopcategory."', '".$calias."', '".$ctitel."', '".$cbeschreibung."', '0', '".$cdescription."', '".$ckeywords."', '".$caktiv."' )";
mysql_query($sql_add_node);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=categories'>";
}
}

####### Kategorie Bearbeiten #########
if($subpage=="work") {
include("core/cat_work.html");
if($send=="work") { 
$caktiv=$_POST['aktiv'];
$ctopcategory=$_POST['topcategory'];
$ctitel=$_POST['titel'];
$calias=$_POST['alias'];
$cbeschreibung=$_POST['beschreibung'];
$cdescription=$_POST['description'];
$ckeywords=$_POST['keywords'];
$caufrufe=get_cat_aufrufe_by_id($pageid);
dbconnect();
$sql_cat_work = "UPDATE `".get_db_table("categorie")."` SET `id_ober_kategorie`='".$ctopcategory."', `alias`='".$calias."', `titel`='".$ctitel."', `beschreibung`='".$cbeschreibung."', `aufrufe`='".$caufrufe."', `meta_description`='".$cdescription."', `meta_keywords`='".$ckeywords."', `aktiv`='".$caktiv."' WHERE `id_kategorie`='".$pageid."' ";
mysql_query($sql_cat_work) OR die("error");
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=categories'>";
}
}

####### Kategorie aktiv / deaktiv #########
if($subpage=="aktiv") {
if(get_cat_aktiv_by_id($pageid)=="" OR get_cat_aktiv_by_id($pageid)=="nein"){ $ca_aktiv="ja"; }else{ $ca_aktiv="nein"; }
dbconnect();
$sql_cat_work = "UPDATE `".get_db_table("categorie")."` SET `aktiv`='".$ca_aktiv."' WHERE `id_kategorie`='".$pageid."' ";
mysql_query($sql_cat_work) OR die("error");
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=categories#".$pageid."'>";
}

######## Kategorie Löschen ###########
if($subpage=="del") {
include('core/cat_del.html');
if($pagesite=="YES") {
del_categorie($pageid);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=categories'>";
}
}

######## Kategorie Button ###########
if($subpage=="add" or $subpage=="work"){
echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=categories'><span>Abbrechen</span></a></div><br />"; } 
else { echo "<br /><br /><br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=categories&a=add'><span>Kategorie hinzuf&uuml;gen</span></a></div><br />"; }

######## Kategorie Liste ###########
echo'<div align="left"><table border="0" id="cmspages" width="890">';
$root_id="1";
dbconnect();
$sql221 = "SELECT * FROM ".get_db_table('categorie')." WHERE id_ober_kategorie ='0' ORDER BY titel";
$result221 = mysql_query($sql221) OR die(mysql_error());
while($get_sites221 = mysql_fetch_assoc($result221)){
$nodeid=$get_sites221['id_kategorie'];
if(get_cat_aktiv_by_id($nodeid)=="" OR get_cat_aktiv_by_id($nodeid)=="nein"){ $img_aktiv="cancel.png"; }else{ $img_aktiv="accept.png"; }
?> <tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''"> <?
echo'<td id="nodes" width="710"><img border="0" src="img/exfolderbw.gif" width="21" height="16"><a href="index.php?s=categories&p='.$nodeid.'&a=work" title="'.htmlentities($get_sites221['titel']).'">'.htmlentities($get_sites221['titel']).'</a></td>';
echo'<td id="item" width="30"><div id="'.$nodeid.'"><a href="index.php?s=categories&p='.$nodeid.'&a=aktiv"><img src="img/'.$img_aktiv.'" border="0" alt="Aktiv / Deaktiv"></a></div></td>';
echo'<td id="item" width="30"><a href="index.php?s=categories&p='.$nodeid.'&a=work" title="'.htmlentities($get_sites221['titel']).'"><img border="0" src="img/page_edit.png" width="16" height="16"></a></td>';
echo'<td id="item" width="30"><a href="index.php?s=categories&p='.$nodeid.'&a=del" title="'.htmlentities($get_sites221['titel']).'"><img border="0" src="img/page_delete.gif" width="16" height="16"></a></td></tr>';

$count_pnode = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".get_db_table('categorie')." WHERE id_ober_kategorie = '".$nodeid."' "));
list($check_nodes) = $count_pnode;
if($check_nodes!=="0") {
dbconnect();
$sql222 = "SELECT * FROM ".get_db_table('categorie')." WHERE id_ober_kategorie=".$nodeid." ORDER BY titel ";
$result222 = mysql_query($sql222) OR die(mysql_error());
while($get_sites222 = mysql_fetch_assoc($result222)){
$nodeid2=$get_sites222['id_kategorie'];
if(get_cat_aktiv_by_id($nodeid2)=="" OR get_cat_aktiv_by_id($nodeid2)=="nein"){ $img_aktiv="cancel.png"; }else{ $img_aktiv="accept.png"; }
?> <tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''"> <?
echo'<td id="pnodes" width="710"><span><img border="0" src="img/exfolderbw.gif" width="21" height="16"></span><span><a href="index.php?s=categories&p='.$nodeid2.'&a=work" title="'.$get_sites222['titel'].'">'.htmlentities($get_sites222['titel']).'</a></span></td>';
echo'<td id="item" width="30"><div id="'.$nodeid.'"><a href="index.php?s=categories&p='.$nodeid2.'&a=aktiv"><img src="img/'.$img_aktiv.'" border="0" alt="Aktiv / Deaktiv"></a></div></td>';
echo'<td id="item" width="30"><a href="index.php?s=categories&p='.$nodeid2.'&a=work" title="'.$get_sites222['titel'].'"><img border="0" src="img/page_edit.png" width="16" height="16"></a></td>';
echo'<td id="item" width="30"><a href="index.php?s=categories&p='.$nodeid2.'&a=del" title="'.$get_sites222['titel'].'"><img border="0" src="img/page_delete.gif" width="16" height="16"></a></td></tr>';
}
}
}
echo'</table></div>';

?>