<?
####### Email-Adresse löschen #########
if($subpage=="del") {
include("core/newsletter_del.htm");
if($pagesite=="YES") { del_newsletter($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=newsletter'>"; }
}
?>
<br /><br />
<h2>Newsletter E-Mail-Adressen</h2>
<table border="0" cellpadding="0" cellspacing="0" width="400">
<tr><td width="250" height="20"><strong>E-Mail</strong></td>
<td width="100" height="20"><strong>Name</strong></td>
<td width="50" height="20"><strong>L&ouml;schen</strong></td></tr>
<?
######## Newsletter Email Liste #######
dbconnect();
$sql_cat = "SELECT * FROM ".get_db_table("newsletter")." ";
$result_cat = mysql_query($sql_cat) OR die(mysql_error());
while($get_cat = mysql_fetch_assoc($result_cat)) {
echo '<tr><td id="item" width="250" height="20">'.$get_cat['email'].'</td>';
echo '<td id="item" width="100" height="20">'.$get_cat['name'].'</td>';
echo '<td id="item" width="50" height="20" align="center"><a href="index.php?s=newsletter&p='.$get_cat['Id'].'&a=del"><img src="img/newspaper_delete.png" border="0"></a></td></tr>';
}
?>
</table>