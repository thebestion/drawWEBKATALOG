<?
####### Kategorie löschen #########
if($subpage=="del") {
include("core/cat_offer_del.htm");
if($pagesite=="YES") { del_cat_offer($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=cat_offer'>"; }
}

####### Kategorie vorschläge #########
echo "<br /><br /><h2>Kategorie Vorschläge</h2>";
echo'<div align="left"><table border="0" id="cmspages" width="890">';
dbconnect();
$sql222 = "SELECT * FROM ".get_db_table('categorie_offer')." ORDER BY Id ";
$result222 = mysql_query($sql222) OR die(mysql_error());
while($get_sites222 = mysql_fetch_assoc($result222)){
if($get_sites222['home']=="1") { $check_1="checked"; } else{ $check_1=""; }
$pageid2=$get_sites222['Id'];
?><tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''"><?
echo'<td id="pnodes" width="710"><span><img border="0" src="img/exfolderbw.gif" width="21" height="16"></span><span><a href="index.php?s=categories&a=add&title='.$get_sites222['offer'].'" title="'.$get_sites222['offer'].'">'.htmlentities($get_sites222['offer']).'</a></span></td>';
echo'<td id="item" width="30"><a href="index.php?s=categories&a=add&title='.$get_sites222['offer'].'" title="'.$get_sites222['offer'].'"><img border="0" src="img/page_add.png" width="16" height="16"></a></td>';
echo'<td id="item" width="30"><a href="index.php?s=cat_offer&p='.$pageid2.'&a=del" title="'.$get_sites222['offer'].'"><img border="0" src="img/page_delete.gif" width="16" height="16"></a></td></tr>';
}
echo'</table><br /></div>';
?>