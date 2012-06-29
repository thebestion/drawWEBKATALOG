<br /><br />
<?
######### Alle Counter Logs löschen #########
if($delquest=="YES" AND $subpage=="delete_all") {
dbconnect();
$SQL_Befehl = "TRUNCATE TABLE ".get_db_table("counter")." ";
mysql_query($SQL_Befehl);
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=counter'>";
}

######## Banner Button ###########
if($subpage=="delete_all"){
echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=counter&a=delete_all&dq=YES'><span>Alle L&ouml;schen</span></a><a class='boldbuttons' href='index.php?s=counter'><span>Abbrechen</span></a></div><br />"; }
else { echo "<br /><div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=counter&a=delete_all'><span>Alle Logs L&ouml;schen</span></a></div><br />"; }


######## Counter Log Liste #######
echo'<div align="left"><table border="0" id="cmspages" width="890">';
dbconnect();
$sql_cat = "SELECT * FROM ".get_db_table("counter")." ";
$result_cat = mysql_query($sql_cat) OR die(mysql_error());
while($get_cat = mysql_fetch_assoc($result_cat)) {
include("core/counter_temp.html");
}
echo'</table></div>';

?>