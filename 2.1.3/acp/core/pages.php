<br /><br /><br /><div id="popup1" class="msg"><h3>Startseite wurde aktualisiert!</h3></div>
<?  
$send=$_POST['send'];
$home=$_POST['home'];


####### Seite hinzufügen #########
if($subpage=="add") {
include("core/page_add.html");
if($send=="add") { 
$purl=$_POST['page_url'];
$pame=$_POST['page_name'];
$ptitle=$_POST['page_title'];
dbconnect();
$sql_add_node= " INSERT INTO ".get_db_table("page")." ( id_page,url,name,titel ) values (  '', '".$purl."', '".$pame."', '".$ptitle."' )";
mysql_query($sql_add_node);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=pages'>";
}
}


####### Startseite ändern #########
if($home) {
dbconnect();
$sql_home_update0 = "UPDATE `".get_db_table("page")."` SET `home`='0' WHERE `id_page`='".get_page_home()."' ";
mysql_query($sql_home_update0) OR die("error");
dbconnect();
$sql_home_update1 = "UPDATE `".get_db_table("page")."` SET `home`='1' WHERE `id_page`='".$home."' ";
mysql_query($sql_home_update1) OR die("error");
echo '<script type="text/javascript">window.onload=popup1;</script>';
}


####### Seite löschen #########
if($subpage=="del") {
include("core/del_temp.htm");
if($pagesite=="YES") { del_page($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=pages'>"; }
}


######## Seiten Button ###########
if($subpage=="add" or $subpage=="work"){
echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=pages'><span>Abbrechen</span></a></div><br />"; } 
else { echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=pages&a=add'><span>Seite hinzuf&uuml;gen</span></a></div><br />"; }


######## Seiten Liste ###########
echo'<div align="left"><table border="0" id="cmspages" width="890"><form action="" method="post">';
dbconnect();
$sql222 = "SELECT * FROM ".get_db_table('page')." ORDER BY id_page ";
$result222 = mysql_query($sql222) OR die(mysql_error());
while($get_sites222 = mysql_fetch_assoc($result222)){
if($get_sites222['home']=="1") { $check_1="checked"; } else{ $check_1=""; }
$pageid2=$get_sites222['id_page'];
?><tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''"><?
echo'<td id="pnodes" width="710"><span><img border="0" src="img/exfilebw.gif" width="21" height="16"></span><span><a href="index.php?s=editor&p='.$pageid2.'" title="'.$get_sites222['name'].'">'.htmlentities($get_sites222['name']).'</a></span></td>';
echo'<td id="item" width="30"><input type="radio" value="'.$pageid2.'" name="home" '.$check_1.'></td>';
echo'<td id="item" width="30"><a href="index.php?s=pages&p='.$pageid2.'&a=del" title="'.$get_sites222['name'].'"><img border="0" src="img/page_delete.gif" width="16" height="16"></a></td>';
echo'<td id="item" width="30"><a href="index.php?s=editor&p='.$pageid2.'" title="'.$get_sites222['name'].'"><img border="0" src="img/page_edit.png" width="16" height="16"></a></td></tr>';
}
echo'</table><br /><div align="right" style="padding-right:40px;"><input type="submit" class="submit" name="save" value="Speichern" /></div></form></div>';
?>