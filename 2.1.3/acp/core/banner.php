<br /><br /><br />
<?
$ba=$_POST['aktiv'];
$bt=$_POST['typ'];
$bn=$_POST['name'];
$bp=$_POST['partner'];
$bc=$_POST['code'];


####### Banner aktiv / deaktiv #########
if($subpage=="aktiv") {
if(get_banner_data_id("aktiv",$pageid)=="0"){ $b_aktiv="1"; }else{ $b_aktiv="0"; }
dbconnect();
$sql_banner_work = "UPDATE `".get_db_table("banner")."` SET `aktiv`='".$b_aktiv."' WHERE `Id`='".$pageid."' ";
mysql_query($sql_banner_work) OR die("error");
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=banner'>";
}


################ Banner Löschen ################
if($subpage=="del") {
include("core/del_banner.htm");
if($pagesite=="YES") {
del_banner($pageid);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=banner'>";
}
}


################ Banner hinzufügen #############
if($subpage=="add") {
include("core/add_banner.htm");
if($pagesite=="YES") {
add_banner($bt,$bc,$ba,$bn,$bp);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=banner'>";
}
}


################ Banner bearbeiten ############
if($subpage=="work") {
$bid=get_banner_data_id("bannerid",$pageid);
$baktiv=get_banner_data_id("aktiv",$pageid);
$btyp=get_banner_data_id("bannertyp",$pageid);
$bname=get_banner_data_id("name",$pageid);
$bpartner=get_banner_data_id("partner",$pageid);
$bcode=get_banner_data_id("bannercode",$pageid);
include("core/work_banner.htm");
if($pagesite=="YES") {
work_Banner($pageid,$bt,$bc,$ba,$bn,$bp);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=banner&p=".$pageid."&a=work'>";
}
}


######## Banner Button ###########
if($subpage=="add" OR $subpage=="work"){
echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=banner'><span>Abbrechen</span></a></div><br />"; } 
else { echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=banner&a=add'><span>Werbebanner hinzuf&uuml;gen</span></a></div><br />"; }


################ Banner Liste ################
?>
<table id="cmspages" cellpadding="0" cellspacing="0" width="890">
<tr>
  <td width="505px" height="32" align="left">
  <div id="go_left"><strong>Name - Partnerprogramm</strong></div>
  </td>
  <td width="205px" height="32">
      <div id="go_left"><strong>Bannertyp</strong></div>
  </td>
  <td width="55px" height="32" align="center"><strong>Status</strong></td>
  <td width="55px" height="32" align="center"><strong>Bearbeiten</strong></td>
  <td width="55px" height="32" align="center"><strong>L&ouml;schen</strong></td>
</tr>    
<?  
dbconnect();
$sql_banner_list       = "SELECT * FROM ".get_db_table('banner')."  ORDER BY Id ";
$result_banner_list    = mysql_query($sql_banner_list) OR die(mysql_error());
while($get_banner_list = mysql_fetch_assoc($result_banner_list)){ 
if($get_banner_list['aktiv']=="1"){ $bcheck="accept"; }else{ $bcheck="cancel"; } 
?>         
<tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''">
  <td id="item" width="505px" height="32" align="left">
  <div id="go_left"><img src="img/layout.png" border="0"></div>
  <div id="go_left"><a href="index.php?s=banner&p=<? echo $get_banner_list['Id']; ?>&a=work" title="Bearbeiten"><b><? echo $get_banner_list['name']; ?> - <? echo $get_banner_list['partner']; ?></b></a></div>
  </td>
  <td id="item" width="205px" height="32">
      <div id="go_left"><strong><? echo $get_banner_list['bannertyp']; ?></strong></div>
  </td>
  <td id="item" width="55px" height="32" align="center">
  <a href="index.php?s=banner&p=<? echo $get_banner_list['Id']; ?>&a=aktiv" title="Aktiv / Deaktiv">
  <img src="img/<?=$bcheck;?>.png" border="0" width="16" height="16"></a>
  </td>
  <td id="item" width="55px" height="32" align="center">
  <a href="index.php?s=banner&p=<? echo $get_banner_list['Id']; ?>&a=work" title="Bearbeiten">
  <img src="img/layout_edit.png" border="0" width="16" height="16"></a>
  </td>
  <td id="item" width="55px" height="32" align="center">
  <a href="index.php?s=banner&p=<? echo $get_banner_list['Id']; ?>&a=del" title="L&ouml;schen">
  <img src="img/layout_delete.png" border="0" width="16" height="16"></a>
  </td>
</tr>   
<? } ?> 
 </table>
 <br /><br />
</div>
