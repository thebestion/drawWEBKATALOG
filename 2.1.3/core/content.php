<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

if($_GET['m']==1){
if($p_content_opt=="0"){
echo "<h1>".$p_title."</h1>"; echo $p_content;
}else{ include($p_file); }
}elseif($_GET['m']==2){ include("categories.php");
}elseif($_GET['m']==3){ include("sub_categories.php");
}elseif($_GET['m']==4){ include("linkdetails.php");
}elseif($_GET['m']==5){ include("linkedit.php");
}elseif($_GET['m']==6){ if($_GET['c'] == "logout") { session_unset(); session_destroy(); ob_end_flush(); 
echo "<meta http-equiv='refresh' content='0; URL=".get_setting_data(url)."'>"; }
}else{ include("main.php");}
?>