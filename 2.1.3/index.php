<?
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
######### GET Variabeln ############
$cat=stripslashes($_GET["c"]);
$mod=stripslashes($_GET["m"]);
$page=stripslashes($_GET["s"]);
$q=stripslashes($_GET["q"]);
$suchtag = str_replace("-", "+",$cat);
########## Includes #################
include('configs/config.inc.php');
include("configs/functions.inc.php"); 
include("configs/class_page.php"); 
include("configs/class_template.php");
$gp =  new Page;
include("configs/class_system.php"); 
include("configs/class_breadcrumb.php");
########## Counter ##################
if(get_setting_data("counter")=="1") { get_counter(); }
###### Installationsverzeichnis######
if(is_dir('install')=="1"){ 
if(get_setting_data("url")==""){ $warning="<a href='".$_SERVER['REQUEST_URI']."install/'>drawWEBKATALOG installieren</a>"; }else{ $warning="Installationsverzeichnis l&ouml;schen"; }
echo '<div style="color:#404040;background-color:#caedfc;border:1px solid #CCCCCC;padding:10px;font-size:18px;font-family:Verdana,Arial,Helvetica,sans-serif;">'.$warning.'</div>'; }
########## Layout ###################
include($page_layout_path_index);
?>