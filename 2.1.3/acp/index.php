<? 
session_start();
#error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
######### GET Variabeln ############
$username=stripslashes($_POST["username"]);
$passwort=stripslashes($_POST["passwort"]);
$page=stripslashes($_GET["s"]);
$pageid=stripslashes($_GET["p"]);
$subpage=stripslashes($_GET["a"]);
$pagesite=stripslashes($_GET["ps"]);
$delquest=stripslashes($_GET["dq"]);
include('../configs/config.inc.php');
include('configs/functions.inc.php');
######### LOGIN ############
if($username) {
acp_login($username,$passwort);
}
######### LOGOUT ############
if ($page == "logout") {
session_unset ();
session_destroy ();
ob_end_flush ();
header("Location: index.php");
}
##### Page Auswahl nach Session #####
if(session_is_registered('webkatalog_acp_username')) {  include("core/acp.php"); }
if(!session_is_registered('webkatalog_acp_username')) { include("core/page.php"); }
?>