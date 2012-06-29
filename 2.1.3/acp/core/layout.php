<br /><br /><br />
<?
$ln=$_POST['layout_name'];
$lp=$_POST['layout_path'];
$lif=$_POST['layout_index_file'];
$lpi=$_POST['layout_path_img'];
$lcf=$_POST['layout_content_file'];


################ Layout Löschen ################
if($subpage=="del") {
include("core/del_layout.htm");
if($pagesite=="YES") {
del_layout($pageid);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=layout'>";
}
}


################ Layout hinzufügen #############
if($subpage=="add") {
include("core/add_layout.htm");
if($pagesite=="YES") {
add_layout($ln,$lp,$lif,$lpi,$lcf);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=layout'>";
}
}


################ Layout bearbeiten ############
if($subpage=="work") {
$work_id = get_layout_data_id("layout_id",$pageid);
$work_name = get_layout_data_id("layout_name",$pageid);
$work_path = get_layout_data_id("layout_path",$pageid);
$work_img_path = get_layout_data_id("layout_img",$pageid);
$work_index_file = get_layout_data_id("layout_index",$pageid);
$work_content_file = get_layout_data_id("layout_temp",$pageid);
include("core/work_layout.htm");
if($pagesite=="YES") {
work_layout($pageid,$ln,$lp,$lif,$lpi,$lcf);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=layout&p=".$pageid."&a=work'>";
}
}


######## Banner Button ###########
if($subpage=="add" OR $subpage=="work"){
echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=layout'><span>Abbrechen</span></a></div><br />"; } 
else { echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=layout&a=add'><span>Template hinzuf&uuml;gen</span></a></div><br />"; }


################ Layout Liste ################
?>
<table id="cmspages" cellpadding="0" cellspacing="0" width="890" >
    <tr>
      <td style="padding:5px;" width="170" height="20" align="left">
      </td>
      <td style="padding:5px;" width="610" height="20" align="left">
      <b>Templatename</b></td>
      <td width="55" height="20" align="center">
      <b>Bearbeiten</b></td>
      <td width="55" height="20" align="center">
      <b>L&ouml;schen</b></td>
    </tr>
    
<?   
dbconnect();
$sql_mylayout_list       = "SELECT * FROM ".get_db_table('layout')."  ORDER BY Id ";
$result_mylayout_list    = mysql_query($sql_mylayout_list) OR die(mysql_error());
while($get_mylayout_list = mysql_fetch_assoc($result_mylayout_list)){ 
?>         
    <tr onmouseover="style.backgroundColor='#95d8fe'" onmouseout="style.backgroundColor=''">
      <td id="item" width="170" height="87" valign="middle" align="left">
      <img src="../templates/<? echo $get_mylayout_list['layout_path']; ?>thumb.png" border="0">
      </td>
      <td id="item" width="610" height="87" align="left">
      <a href="index.php?s=layout&p=<? echo $get_mylayout_list['Id']; ?>&a=work" title="Bearbeiten"><b><? echo $get_mylayout_list['layout_name']; ?></b></a>
      </td>
      <td id="item" width="55" height="87" align="center">
      <a href="index.php?s=layout&p=<? echo $get_mylayout_list['Id']; ?>&a=work" title="Bearbeiten">
      <img src="img/layout_edit.png" border="0" width="16" height="16"></a></td>
      <td id="item" width="55" height="87" align="center">
      <a href="index.php?s=layout&p=<? echo $get_mylayout_list['Id']; ?>&a=del" title="L&ouml;schen">
      <img src="img/layout_delete.png" border="0" width="16" height="16"></a></td>
    </tr>   
<? } ?> 
 </table>
 <br /><br />
</div>
