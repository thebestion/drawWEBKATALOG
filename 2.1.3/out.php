<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
#### Ausgabe fuer neue Eintraee ####
# Beispiel: out.php?admin=deinpasswort
include("configs/config.inc.php");
include("configs/functions.inc.php");
$adminpw=$_GET['admin'];
if($adminpw==getAdminPW()){
dbconnect();
$sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE isfreigeschaltet = '0'";
$query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
list($gesamt_cat) = $query_cat;
echo $gesamt_cat;
}
?>