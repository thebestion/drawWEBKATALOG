<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

switch ($page) {
case "": $home="current"; $sub_home="current"; break;
case "home": $home="current"; $sub_home="current"; break;
case "pages": $site="current"; break;
case "editor": $site="current"; break;
case "categories": $cats="current";$sub_cats="current"; break;
case "cat_offer": $cats="current";$cat_offer="current"; break;
case "links": $links="current"; $sub_links="current"; break;
case "link_free": $links="current"; $sub_link_free="current"; break;
case "link_pro": $links="current"; $sub_link_pro="current"; break;
case "link_cat": $links="current"; $sub_link_cat="current"; break;
case "link_edit": $links="current"; break;
case "link_suche": $links="current"; $sub_link_such="current"; break;
case "banner": $banner="current"; break;
case "settings": $settings="current"; $sub_settings="current"; break;
case "counter": $home="current"; $counter="current"; break;
case "emails": $settings="current"; $emails="current"; break;
case "prem_eintrag": $settings="current"; $prem_eintrag="current"; break;
case "pw_change": $settings="current"; $pw_change="current"; break;
case "layout": $layout="current"; break;
case "newsletter": $home="current"; $newsletter="current"; break;

}

function get_db_table($data) {
global $prefix;
return "".$prefix."".$data."";
}

function get_date() {
$now=date("d.m.Y, H:i:s",time());
return $now;
}

function get_prempaydate() {
$now=date("d.m.Y");
return $now;
}

function get_prempayenddate() {
$payend=date("Y");
$res=$payend+1;
$now=date("d.m.").$res;
return $now;
}

function get_premrememberdate() {
$payrember=date("m");
$res=$payrember-1;
if($res=="0"){ $result="12"; }else{ $result=$res; }
$now=date("d.").$result.date(".Y");
return $now;
}

function getUrlName($url){
$un = explode(".", $url);
return $un[1]; 
}

function getUrlBack($urlname){
$lid = explode("-", $urlname);
return $lid[0]; 
}

function getCutStrip($cs,$ml,$end){
$cutstrip = $cs;
$maxlaenge = $ml;
$cutstrip = (strlen($cutstrip) > $maxlaenge) ? substr($cutstrip,0,$maxlaenge).$end : $cutstrip;
return $cutstrip;
}

/*   Captcha Start  */

function getCaptchaCode(){
$code = '';
for ($i = 0; $i < 4; $i++) { $code .= chr(rand(97, 122)); }
return $code;
}

function checkCapatcha(){
$captchaValidierungOk = false;
if (ereg('^[a-z]{4}$', $_POST['captcha_code']) &&         // eingabe syntaktisch korrekt
   !empty($_SESSION['captcha_code']) &&                   // code in der session
   ($_SESSION['captcha_code']==$_POST['captcha_code'])) { // session-code = eingabe-code
   $captchaValidierungOk = true; }
$_SESSION['captcha_code'] = getCaptchaCode();
return $captchaValidierungOk;
}

/*   Captcha Ende  */



function dbconnect()
{
    global $DB_HOST, $DB_USER, $DB_PWD, $DB_NAME;
	if (!($link = mysql_connect($DB_HOST, $DB_USER, $DB_PWD)))
	{
        print "<h3>could not connect to database</h3>\n";
		exit;
	}
	mysql_select_db($DB_NAME);
    return $link;
}


function acp_login($draw_cms_username,$draw_cms_passwort) {
	global $prefix;
	$admintable=$prefix."admin";
    dbconnect();
    $query = "SELECT `Id`, `Nickname`, `Kennwort`  FROM ".$admintable." WHERE Nickname = '".$draw_cms_username."'";
    $result =  mysql_query($query);
    dbconnect();
    $result =  mysql_query("SELECT `Id`, `Nickname`, `Kennwort`  FROM ".$admintable." WHERE Nickname = '$draw_cms_username'");
    $zeileholen =  mysql_fetch_array($result);
    if (!$zeileholen) { die ("<meta http-equiv='refresh' content='0; URL=index.php'></SCRIPT><script language='JavaScript'>(window-alert('".$admintable."Benutzername nicht gefunden'))</script>"); }
    if ($zeileholen["Kennwort"] <> $draw_cms_passwort)
    { die ("<meta http-equiv='refresh' content='0; URL=".get_setting_data(url)."/acp'></SCRIPT><script language='JavaScript'>(window-alert('Sorry, aber dieses Passwort passt nicht zum Benutzernamen!!'))</script>");
    } else {
    $webkatalog_acp_usid = $zeileholen["Id"];
    session_register('webkatalog_acp_username');
    session_register('webkatalog_acp_usid');
    }
}



function get_IP() {
  if(isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] && strcasecmp($_SERVER['HTTP_CLIENT_IP'], "unknown")) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], "unknown")) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
    $ip = $_SERVER['REMOTE_ADDR'];
  } else {
    $ip = FALSE;
  }
  return $ip;
}





function get_setting_data($data) {
dbconnect();
$query_settings = mysql_query("SELECT * FROM ".get_db_table("setting")." ORDER BY ID ASC LIMIT 1 ");
while ($row_settings=mysql_fetch_object($query_settings)) {
$settings_url               = $row_settings -> url;
$settings_name              = $row_settings -> name;
$settings_genre             = $row_settings -> genre;
$settings_email             = $row_settings -> email;
$settings_sitedate          = $row_settings -> sitedate;
$settings_counter           = $row_settings -> counter;
$settings_layout_id         = $row_settings -> layout_id;
$settings_favico            = $row_settings -> favico;
$settings_google_verify     = $row_settings -> google_verify;
$settings_google_analytics  = $row_settings -> google_analytics;
$settings_paypal  			= $row_settings -> paypal;
$settings_prempreis  		= $row_settings -> prempreis;
$settings_logo  			= $row_settings -> logo;
}
switch ($data) {
case "url":              return $settings_url; break;
case "name":             return $settings_name; break;
case "genre":            return $settings_genre; break;
case "email":            return $settings_email; break;
case "sitedate":         return $settings_sitedate; break;
case "counter":          return $settings_counter; break;
case "layout_id":        return $settings_layout_id; break;
case "favico":           return $settings_favico; break;
case "google_verify":    return $settings_google_verify; break;
case "google_analytics": return $settings_google_analytics; break;
case "paypal": 			 return $settings_paypal; break;
case "prempreis": 		 return $settings_prempreis; break;
case "logo": 		 	 return $settings_logo; break;
}
}


function get_aktiv_layout_data($data) {
dbconnect();
$query_layout = mysql_query("SELECT * FROM ".get_db_table("layout")." WHERE Id = ".get_setting_data("layout_id")." ");
while ($row_layout=mysql_fetch_object($query_layout)) {
$layout_id     = $row_layout -> Id;
$layout_name   = $row_layout -> layout_name;
$layout_path   = $row_layout -> layout_path;
$layout_index  = $row_layout -> layout_index;
$layout_img    = $row_layout -> layout_img;
$layout_temp   = $row_layout -> layout_temp;
}
switch ($data) {
case "layout_id":      return $layout_id; break;
case "layout_name":    return $layout_name; break;
case "layout_path":    return $layout_path; break;
case "layout_index":   return $layout_index; break;
case "layout_img":     return $layout_img; break;
case "layout_img":     return $layout_img; break;
}
}



function get_free_mail() {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('emails')." ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['free_mail'];
}
}

function get_prem_mail() {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('emails')." ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['prem_mail'];
}
}


function add_premlink($id_link,$payday,$prem_end,$prem_remember){
dbconnect();
$sql_premlink_insert= " INSERT INTO ".get_db_table("prem_link")." ( Id,id_link,payday,prem_end,prem_remember ) values (  '', '".$id_link."', '".$payday."', '".$prem_end."', '".$prem_remember."' )";
mysql_query($sql_premlink_insert);
}


function get_link_passwort_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['passwort'];
}
}


function get_link_url_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['url'];
}
}

######################################################### Anfang Layout Functions #######################
function get_layout_data_id($data,$data_id) {
dbconnect();
$query_layout = mysql_query("SELECT * FROM ".get_db_table("layout")." WHERE Id = ".$data_id." ");
while ($row_layout=mysql_fetch_object($query_layout)) {
$layout_id     = $row_layout -> Id;
$layout_name   = $row_layout -> layout_name;
$layout_path   = $row_layout -> layout_path;
$layout_index  = $row_layout -> layout_index;
$layout_img    = $row_layout -> layout_img;
$layout_temp   = $row_layout -> layout_temp;
}
switch ($data) {
case "layout_id":         return $layout_id; break;
case "layout_name":       return $layout_name; break;
case "layout_path":       return $layout_path; break;
case "layout_index":   return $layout_index; break;
case "layout_img": return $layout_img; break;
case "layout_temp": return $layout_temp; break;
}
}


function del_layout($data_id){
dbconnect();
$sql_del_layout = "DELETE FROM ".get_db_table("layout")." WHERE Id = ".$data_id;
mysql_query($sql_del_layout);
}

function add_layout($name,$path,$index_file,$path_img,$cont_path){
dbconnect();
$sql_layout_insert= " INSERT INTO ".get_db_table("layout")." ( Id,layout_name,layout_path,layout_index,layout_img,layout_temp ) values (  '', '".$name."', '".$path."', '".$index_file."', '".$path_img."', '".$cont_path."' )";
mysql_query($sql_layout_insert);
}

function work_layout($data_id,$name,$path,$index_file,$path_img,$cont_path){
dbconnect();
$sql_layout_update = "UPDATE `".get_db_table("layout")."` SET `layout_name`='".$name."', `layout_path`='".$path."', `layout_index`='".$index_file."', `layout_img`='".$path_img."', `layout_temp`='".$cont_path."' ";
$sql_layout_update .= " WHERE `Id`='".$data_id."'";
mysql_query($sql_layout_update);
}


function get_layout_list() {

echo '<option value="'.get_aktiv_layout_data("layout_id").'">'.get_aktiv_layout_data("layout_name").'</option>';
dbconnect();
$sql_layout_list = "SELECT * FROM ".get_db_table('layout')." ";
$result_layout_list = mysql_query($sql_layout_list) OR die(mysql_error());
while($get_layout_list = mysql_fetch_assoc($result_layout_list)){
if($get_layout_list['Id']!=get_aktiv_layout_data("layout_id")){
$layout_list_id        = $get_layout_list['Id'];
$layout_list_name      = $get_layout_list['layout_name'];
echo '<option value="'.$layout_list_id.'">'.$layout_list_name.'</option>';
}
}
}

############################################################### Ende Layout Functions ########################## 


######################################################### Anfang Banner Functions #######################
function get_banner_data_id($data,$data_id) {
dbconnect();
$query_banner = mysql_query("SELECT * FROM ".get_db_table("banner")." WHERE Id = ".$data_id." ");
while ($row_banner=mysql_fetch_object($query_banner)) {
$bannerid     	= $row_banner -> Id;
$bannertyp   	= $row_banner -> bannertyp;
$bannercode   	= $row_banner -> bannercode;
$aktiv  		= $row_banner -> aktiv;
$name  			= $row_banner -> name;
$partner  		= $row_banner -> partner;
}
switch ($data) {
case "bannerid":       return $bannerid; break;
case "bannertyp":      return $bannertyp; break;
case "bannercode":     return $bannercode; break;
case "aktiv":   	   return $aktiv; break;
case "name":   	   	   return $name; break;
case "partner":   	   return $partner; break;
}
}

function del_banner($data_id){
dbconnect();
$sql_del_banner = "DELETE FROM ".get_db_table("banner")." WHERE Id = ".$data_id;
mysql_query($sql_del_banner);
}

function add_banner($btyp,$bcode,$baktiv,$bname,$bpartner){
dbconnect();
$sql_banner_insert= " INSERT INTO ".get_db_table("banner")." ( Id,bannertyp,bannercode,aktiv,name,partner ) values (  '', '".$btyp."', '".$bcode."', '".$baktiv."', '".$bname."', '".$bpartner."' )";
mysql_query($sql_banner_insert);
}

function work_banner($data_id,$btyp,$bcode,$baktiv,$bname,$bpartner){
dbconnect();
$sql_banner_update = "UPDATE `".get_db_table("banner")."` SET `bannertyp`='".$btyp."', `bannercode`='".$bcode."', `aktiv`='".$baktiv."', `name`='".$bname."', `partner`='".$bpartner."' ";
$sql_banner_update .= " WHERE `Id`='".$data_id."'";
mysql_query($sql_banner_update);
}
############################################################### Ende Banner Functions ########################## 


############################################################### Anfang Twitter Functions ########################## 
function get_twitter_user($lang) {
dbconnect();
$sql_tuser       = "SELECT * FROM ".get_db_table('twitter')." WHERE lang = '$lang' AND aktiv = '1' ";
$result_tuser    = mysql_query($sql_tuser) OR die(mysql_error());
while($get_tuser = mysql_fetch_assoc($result_tuser)){
$tuser           = $get_tuser['username']; 
}
return $tuser;
}


function get_twitter_pass($lang) {
dbconnect();
$sql_tpass       = "SELECT * FROM ".get_db_table('twitter')." WHERE lang = '$lang' AND aktiv = '1' ";
$result_tpass    = mysql_query($sql_tpass) OR die(mysql_error());
while($get_tpass = mysql_fetch_assoc($result_tpass)){
$tpass 			 = $get_tpass['password']; 
}
return $tpass;
}



function get_aktiv_taccount($lang) {
dbconnect();
$sql_taccount       = "SELECT * FROM ".get_db_table('twitter')." WHERE lang = '$lang' ";
$result_taccount    = mysql_query($sql_taccount) OR die(mysql_error());
while($get_taccount = mysql_fetch_assoc($result_taccount)){
$taccount 			= $get_taccount['aktiv']; 
}
return $taccount;
}



function get_twiiter_aktiv_btn($lang) {
if(get_aktiv_taccount($lang)=="1"){
$btn="<a href='index.php?s=twitter&p=".$lang."&a=update'><img src='img/accept.png' border='0'></a>";
}else{
$btn="<a href='index.php?s=twitter&p=".$lang."&a=update'><img src='img/action_stop.gif' border='0'></a>";
}
return $btn;
}

############################################################### Ende Twitter Functions ########################## 



function checkEmailOK($addr){
// if(validate($addr)){ }else{}
if(!ereg("^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+.([a-zA-Z0-9-]{2,4})$",$addr)){ return FALSE; } 
else{ list($user, $host) = explode("@", $addr); if(checkdnsrr($host, "MX") or checkdnsrr($host, "A")) { return TRUE; }else{ return FALSE; } }
} 

function get_counter() {
dbconnect();
$query_counter = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM ".get_db_table("counter")." WHERE ip_adresse = '".get_IP()."' "));
list($check_click) = $query_counter;
if($check_click=="0") {
dbconnect();
$sql_counter= " INSERT INTO ".get_db_table("counter")." (  Id,date,ip_adresse,methode,call_url,user_infos,from_url ) values (  '', '".get_date()."', '".get_IP()."', '".$_SERVER['REQUEST_METHOD']."', '".$_SERVER['PHP_SELF']."', '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['HTTP_REFERER']."' )";
mysql_query($sql_counter);
}
}



function countPages() {
dbconnect();
$sql_cpage="SELECT COUNT(*) FROM  ".get_db_table('page')." ";
$queryl_cpage = mysql_fetch_row(mysql_query($sql_cpage));
list($gesamt_queryl_cpage) = $queryl_cpage;
return $gesamt_queryl_cpage;
}

function countNewsletter() {
dbconnect();
$sql_cnl="SELECT COUNT(*) FROM  ".get_db_table('newsletter')." ";
$queryl_cnl = mysql_fetch_row(mysql_query($sql_cnl));
list($gesamt_queryl_cnl) = $queryl_cnl;
return $gesamt_queryl_cnl;
}

function countUser() {
dbconnect();
$sql_cuser="SELECT COUNT(*) FROM  ".get_db_table('counter')." ";
$queryl_cuser = mysql_fetch_row(mysql_query($sql_cuser));
list($gesamt_queryl_cuser) = $queryl_cuser;
return $gesamt_queryl_cuser;
}

function countFreeLinks() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('link')."  WHERE typ = '0'  AND isfreigeschaltet = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countPremLinks() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('link')."  WHERE typ = '1'  AND isfreigeschaltet = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countEmail($mail) {
dbconnect();
$sql_cmail="SELECT COUNT(*) FROM  ".get_db_table('link')." WHERE email = '".$mail."' ";
$queryl_cmail = mysql_fetch_row(mysql_query($sql_cmail));
list($gesamt_queryl_cmail) = $queryl_cmail;
return $gesamt_queryl_cmail;
}

function countAllLinks() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('link')." WHERE isfreigeschaltet = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countAllNewLinks() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('link')." WHERE isfreigeschaltet = '0' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countAllCats() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie')." WHERE aktiv = 'ja' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countSubcat() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie')." WHERE id_ober_kategorie != 0 AND aktiv = 'ja' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countMaincat() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie')." WHERE id_ober_kategorie = 0 AND aktiv = 'ja' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countCatOffer() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie_offer')." ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countBanner() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('banner')." ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countAktivBanner() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('banner')." WHERE aktiv = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countBannerHead() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('banner')." WHERE bannertyp = 'head' AND aktiv = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}

function countBannerContent() {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('banner')." WHERE bannertyp = 'content' AND aktiv = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}


function get_count_cat_links($cat_id) {
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('link')."  WHERE id_kategorie = '".$cat_id."'  AND isfreigeschaltet = '1' ";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
return $gesamt_sub_cat;
}


function get_sub_cat2($cat_id) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_ober_kategorie = ".$cat_id." AND aktiv = 'ja' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
echo " ".$get_sub_cat['titel'].","; 
}
}


function get_sub_cat($cat_id) {
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_ober_kategorie = ".$cat_id." AND aktiv = 'ja' ORDER BY titel ASC LIMIT 2 ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
echo " <a href='".$get_link['alias']."/3.html'>".$get_link['titel']."</a>,"; 
}
}


function getSubDropdown($cat_id) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_ober_kategorie = ".$cat_id." AND aktiv = 'ja' ORDER BY titel ASC  ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
echo "<option value='".$get_sub_cat['id_kategorie']."'>- ".htmlentities($get_sub_cat['titel'])."</option>"; 
}
}


function getCategorieDropdown(){
echo '<select name="category" >';
echo '<option value="0">Bitte hier ausw&auml;hlen:</option>';
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$categorieid=$get_link['id_kategorie'];
echo "<option value='0'>-----------------------------</option>";
echo "<option value='".$categorieid."'>".htmlentities($get_link['titel'])."</option>"; 
echo getSubDropdown($categorieid);
}
echo "</select>";
}




function gotoCategorieDropdown(){
echo '<form name="form"><select name="category" id="site_tree" size="1" onChange="gotocat()">';
echo '<option value="index.php?s=link_cat">Bitte hier ausw&auml;hlen:</option>';
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$categorieid=$get_link['id_kategorie'];
$showlink="index.php?s=link_cat&catid=".$categorieid;
echo "<option value='index.php?s=link_cat'>-----------------------------</option>";
echo "<option value='".$showlink."'>".htmlentities($get_link['titel'])."</option>"; 
echo gotoSubDropdown($categorieid);
}
echo "</select></form>";
}

function gotoSubDropdown($cat_id) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_ober_kategorie = ".$cat_id." AND aktiv = 'ja' ORDER BY titel ASC  ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
$showlink="index.php?s=link_cat&catid=".$get_sub_cat['id_kategorie'];
echo "<option value='".$showlink."'>- ".htmlentities($get_sub_cat['titel'])."</option>"; 
}
}



function getCategorieDropdownUpdate($link_id){
echo '<select name="category">';
echo '<option value="'.get_link_cat($link_id).'">'.get_cat_titel_by_id(get_link_cat($link_id)).'</option>';
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$categorieid=$get_link['id_kategorie'];
echo "<option value='0'>-----------------------------</option>";
echo "<option value='".$categorieid."'>".htmlentities($get_link['titel'])."</option>"; 
echo getSubDropdown($categorieid);
}
echo "</select>";
}


function get_page_name_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_name = $row_title['name'];
}
return $page_name;
}


function get_page_url_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_url = $row_title['url'];
}
return $page_url;
}


function get_page_title_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_title = $row_title['titel'];
}
return $page_title;
}


function get_page_content_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_text = $row_title['text'];
}
return $page_text;
}


function get_page_upload_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_file = $row_title['file'];
}
return $page_file;
}


function get_page_option_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_content_option = $row_title['content_option'];
}
return $page_content_option;
}


function get_page_keywords_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_meta_keywords = $row_title['meta_keywords'];
}
return $page_meta_keywords;
}


function get_page_beschreibung_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_meta_beschreibung = $row_title['meta_beschreibung'];
}
return $page_meta_beschreibung;
}


function get_page_date_by_id($page_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE id_page = ".$page_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$page_datum = $row_title['datum'];
}
return $page_datum;
}

function get_page_home() {
dbconnect();
$query_home = mysql_query("SELECT * FROM ".get_db_table('page')." WHERE home = 1");
while ($row_home=mysql_fetch_assoc($query_home)) {
$page_home = $row_home['id_page'];
}
return $page_home;
}


function get_upload_file_list() {
$pfad = "../core/";
$fd = dir($pfad);
while($v = $fd->read()) {
  if($v != "." && $v != ".." && $v != "search.php" && $v != "sub_categories.php" && $v != "top100.php" && $v != "newsites.php" && $v != "addform.php" && $v != "addform2.php" && $v != "addtemp.php" && $v != "categories.php" && $v != "content.php" && $v != "linkadd.php" && $v != "linkdetails.php" && $v != "del_temp.htm") {
  echo '<option value="'.$v.'">'.$v.'</option>';
  }
}
$fd->close();
}



function del_page($data_id) {
dbconnect();
$sql_del_page = "DELETE FROM ".get_db_table("page")." WHERE id_page = ".$data_id;
mysql_query($sql_del_page);
}



function del_link($data_id) {
dbconnect();
$sql_del_page = "DELETE FROM ".get_db_table("link")." WHERE id_link = ".$data_id;
mysql_query($sql_del_page);
}


function del_prem_link($data_id) {
dbconnect();
$sql_del_prem_link = "DELETE FROM ".get_db_table("prem_link")." WHERE Id = ".$data_id;
mysql_query($sql_del_prem_link);
}
	 	 	 	

function get_cat_aktiv_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_aktiv = $row_aktiv['aktiv'];
}
return $cat_aktiv;
}


function get_link_aktiv_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$link_aktiv = $row_aktiv['isfreigeschaltet'];
}
return $link_aktiv;
}

function get_link_email($cat_id) {
dbconnect();
$query_email = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_email=mysql_fetch_assoc($query_email)) {
$link_email = $row_email['email'];
}
return $link_email;
}

function get_link_url($cat_id) {
dbconnect();
$query_url = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_url=mysql_fetch_assoc($query_url)) {
$link_url = $row_url['url'];
}
return $link_url;
}

function get_link_cat($linkid) {
dbconnect();
$query_id_kategorie = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$linkid." ");
while ($row_id_kategorie=mysql_fetch_assoc($query_id_kategorie)) {
$id_kategorie = $row_id_kategorie['id_kategorie'];
}
return $id_kategorie;
}

function get_link_title($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_title = $row_title['titel'];
}
return $link_title;
}

function get_link_description($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_description = $row_title['beschreibung'];
}
return $link_description;
}

function get_link_keywords($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_keywords = $row_title['keywords'];
}
return $link_keywords;
}

function get_link_typ($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_typ = $row_title['typ'];
}
return $link_typ;
}

function get_link_datum($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_datum = $row_title['datum'];
}
return $link_datum;
}

function get_link_ratinglink($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_ratinglink = $row_title['ratinglink'];
}
return $link_ratinglink;
}

function get_link_firma($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_firma = $row_title['firma'];
}
return $link_firma;
}

function get_link_name($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_name = $row_title['name'];
}
return $link_name;
}

function get_link_strasse($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_strasse = $row_title['strasse'];
}
return $link_strasse;
}

function get_link_ort($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_ort = $row_title['ort'];
}
return $link_ort;
}

function get_link_ip($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_ip = $row_title['ip'];
}
return $link_ip;
}

function get_link_passwort($cat_id) {
dbconnect();
$query_title = mysql_query("SELECT * FROM ".get_db_table('link')." WHERE id_link = ".$cat_id."");
while ($row_title=mysql_fetch_assoc($query_title)) {
$link_passwort = $row_title['passwort'];
}
return $link_passwort;
}


function get_cat_ober_kategorie_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_ober_kategorie = $row_aktiv['id_ober_kategorie'];
}
return $cat_ober_kategorie;
}


function get_cat_titel_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_titel = $row_aktiv['titel'];
}
return $cat_titel;
}


function get_cat_alias_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_alias = $row_aktiv['alias'];
}
return $cat_alias;
}


function get_cat_beschreibung_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_beschreibung = $row_aktiv['beschreibung'];
}
return $cat_beschreibung;
}


function get_cat_description_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_description = $row_aktiv['meta_description'];
}
return $cat_description;
}


function get_cat_keywords_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_keywords = $row_aktiv['meta_keywords'];
}
return $cat_keywords;
}

function get_cat_aufrufe_by_id($cat_id) {
dbconnect();
$query_aktiv = mysql_query("SELECT * FROM ".get_db_table('categorie')." WHERE id_kategorie = ".$cat_id."");
while ($row_aktiv=mysql_fetch_assoc($query_aktiv)) {
$cat_aufrufe = $row_aktiv['aufrufe'];
}
return $cat_aufrufe;
}





function get_site_tree() {
echo'<form name="form"><select name="site" id="site_tree" size="1" onChange="goto()"><option value="">Seite ausw&auml;hlen</option>';
dbconnect();
$sql221 = "SELECT * FROM ".get_db_table('page')." ORDER BY id_page ASC ";
$result221 = mysql_query($sql221) OR die(mysql_error());
while($get_sites221 = mysql_fetch_assoc($result221)){
$nodeid=$get_sites221['id_page'];
echo "<option value='index.php?s=editor&p=".$nodeid."'>".get_page_name_by_id($nodeid)."</option>";
}
echo'</select></form>';
}


function getTopCategorieDropdown(){
echo '<select name="topcategory">';
echo '<option value="0">Bitte hier ausw&auml;hlen:</option>';
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$categorieid=$get_link['id_kategorie'];
echo "<option value='".$categorieid."'>".htmlentities($get_link['titel'])."</option>"; 
}
echo "</select>";
}


function getWorkCategorieDropdown($c_id){
echo '<select name="topcategory">';
if(get_cat_ober_kategorie_by_id($c_id)=="0"){ echo '<option value="0">Keine Kategorie ausgew&auml;hlt</option>'; } else { echo '<option value="'.get_cat_ober_kategorie_by_id($c_id).'">'.get_cat_titel_by_id(get_cat_ober_kategorie_by_id($c_id)).'</option>'; }
echo '<option value="0">Keine Kategorie ausw&auml;hlen:</option>';
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' AND id_ober_kategorie = '0' ORDER BY titel ASC ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$categorieid=$get_link['id_kategorie'];
echo "<option value='".$categorieid."'>".htmlentities($get_link['titel'])."</option>"; 
}
echo "</select>";
}


function del_categorie($data_id){
dbconnect();
$sql_del_categorie = "DELETE FROM ".get_db_table("categorie")." WHERE id_kategorie=".$data_id."";
mysql_query($sql_del_categorie);
}


function del_cat_offer($data_id){
dbconnect();
$sql_del_categorie = "DELETE FROM ".get_db_table("categorie_offer")." WHERE Id=".$data_id."";
mysql_query($sql_del_categorie);
}


function del_newsletter($data_id){
dbconnect();
$sql_del_newsletter = "DELETE FROM ".get_db_table("newsletter")." WHERE Id=".$data_id."";
mysql_query($sql_del_newsletter);
}


function getItemLinkById($item_id){
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('link')."  WHERE id_link = ".$item_id." ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
return $get_link['url'];
}
}

function getItemTitleById($item_id){
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('link')."  WHERE id_link = ".$item_id." ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
return $get_link['titel'];
}
}


function getCatDownName($cat_id){
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_kategorie = ".$cat_id." ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$cat_id_down      = $get_link['id_ober_kategorie'].", ";

dbconnect();
$sql_cat_id       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_kategorie = '".$cat_id_down."'";
$query_cat_id     = mysql_query($sql_cat_id);
while($get_cat_id = mysql_fetch_assoc($query_cat_id)){
return $get_cat_id['titel']; }
}
}


function getCatDownAlias($cat_id){
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_kategorie = ".$cat_id." ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
$cat_id_down      = $get_link['id_ober_kategorie'].", ";

dbconnect();
$sql_cat_id       = "SELECT * FROM ".get_db_table('categorie')."  WHERE id_kategorie = '".$cat_id_down."'";
$query_cat_id     = mysql_query($sql_cat_id);
while($get_cat_id = mysql_fetch_assoc($query_cat_id)){
return $get_cat_id['alias']; }
}
}


function get_alias_to_cat_id($cat_alias){
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
if($gesamt_sub_cat=="1") {
dbconnect();
$sql_cat_id       = "SELECT * FROM ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_cat_id     = mysql_query($sql_cat_id);
while($get_cat_id = mysql_fetch_assoc($query_cat_id)){
return $get_cat_id['id_kategorie']; }
}
}

function get_alias_to_cat_title($cat_alias){
dbconnect();
$sqltag0001="SELECT COUNT(*) FROM  ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query0001 = mysql_fetch_row(mysql_query($sqltag0001));
list($gesamt_sub_cat) = $query0001;
if($gesamt_sub_cat=="1") {
dbconnect();
$sql_cat_id       = "SELECT * FROM ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_cat_id     = mysql_query($sql_cat_id);
while($get_cat_id = mysql_fetch_assoc($query_cat_id)){
return htmlentities($get_cat_id['titel']); }
}
}

function get_alias_to_cat_beschreibung($cat_alias){
dbconnect();
$sqltag_beschreibung="SELECT COUNT(*) FROM  ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_beschreibung = mysql_fetch_row(mysql_query($sqltag_beschreibung));
list($gesamt_sub_cat) = $query_beschreibung;
if($gesamt_sub_cat=="1") {
dbconnect();
$sql_cat_beschreibung       = "SELECT * FROM ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_cat_beschreibung     = mysql_query($sql_cat_beschreibung);
while($get_cat_beschreibung = mysql_fetch_assoc($query_cat_beschreibung)){
return $get_cat_beschreibung['beschreibung']; }
}
}


function get_last_5_links(){
dbconnect();
$sql_last_links="SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = '1' ORDER BY id_link DESC LIMIT 5 ";
$query_last_links=mysql_query($sql_last_links);
while($get_last_links = mysql_fetch_assoc($query_last_links)){
$tit=$get_last_links['titel'];
echo"<li><a href='".$get_last_links['url']."' title='".$tit."' target='_blank'>".getCutStrip($tit,"26","...")."</a></li>";
}
}



function get_last_5_cats(){
global $page_url;
dbconnect();
$sql_last_cats="SELECT * FROM ".get_db_table("categorie")." WHERE id_ober_kategorie = '0' AND aktiv='ja' ORDER BY id_kategorie DESC LIMIT 5 ";
$query_last_cats=mysql_query($sql_last_cats);
while($get_last_cats = mysql_fetch_assoc($query_last_cats)){
echo"<li><a href='".$page_url."/".$get_last_cats['alias']."/2.html' title='".$get_last_cats['titel']."'>".$get_last_cats['titel']."</a></li>";
}
}



function get_last_10_newlinks(){
dbconnect();
$sql_last_links="SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = '0' ORDER BY id_link DESC LIMIT 10 ";
$query_last_links=mysql_query($sql_last_links);
while($get_last_links = mysql_fetch_assoc($query_last_links)){
$tit=$get_last_links['titel'];
if($get_last_links['typ']=="1"){ $prem="<img src='img/star.png' border='0' width='8px' heidht='8px'> "; }else{ $prem=""; }
echo"<li><a href='index.php?s=link_edit&p=".$get_last_links['id_link']."' title='".$tit."'>".$prem.getCutStrip($tit,"26","...")." </a></li>";
}
}

function get_last_10_catoffer(){
dbconnect();
$sql_last_links="SELECT * FROM ".get_db_table("categorie_offer")." ORDER BY Id DESC LIMIT 10 ";
$query_last_links=mysql_query($sql_last_links);
while($get_last_links = mysql_fetch_assoc($query_last_links)){
$tit=$get_last_links['offer'];
echo"<li><a href='index.php?s=cat_offer' title='".$tit."'>".getCutStrip($tit,"30","...")."</a></li>";
}
}

function get_last_10_newsletter(){
dbconnect();
$sql_last_links="SELECT * FROM ".get_db_table("newsletter")." ORDER BY Id DESC LIMIT 10 ";
$query_last_links=mysql_query($sql_last_links);
while($get_last_links = mysql_fetch_assoc($query_last_links)){
$tit=$get_last_links['email'];
echo"<li><a href='index.php?s=newsletter' title='".$tit."'>".getCutStrip($tit,"30","...")."</a></li>";
}
}

function get_last_10_counter(){
dbconnect();
$sql_last_links="SELECT * FROM ".get_db_table("counter")." ORDER BY Id DESC LIMIT 10 ";
$query_last_links=mysql_query($sql_last_links);
while($get_last_links = mysql_fetch_assoc($query_last_links)){
$tit=$get_last_links['date'];
echo"<li><a href='index.php?s=counter' title='".$tit." - ".$get_last_links['ip_adresse']."'>".getCutStrip($tit,"30","...")."</a></li>";
}
}





function get_cat($cat_id) {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE id_kategorie = '".get_alias_to_cat_id($cat_id)."' AND isfreigeschaltet = '1'";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['s'])) { $site = 1; } elseif($_GET['s'] <= 0 || $_GET['s'] > $num_news) { $site = 1; } else { $site = $_GET['s']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'/'.$prev.'.html">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'/'.$i.'.html">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'/'.$next.'.html">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE id_kategorie = '".get_alias_to_cat_id($cat_id)."' AND isfreigeschaltet = '1' ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	include("templates/web_dict/content_temp/cat_item.html");
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}



function get_top100($cat_id) {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE typ = '1' AND isfreigeschaltet = '1'";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['s'])) { $site = 1; } elseif($_GET['s'] <= 0 || $_GET['s'] > $num_news) { $site = 1; } else { $site = $_GET['s']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'/'.$prev.'.html">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'/'.$i.'.html">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'/'.$next.'.html">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE typ = '1' AND isfreigeschaltet = '1' ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	include("templates/web_dict/content_temp/cat_item.html");
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}



function get_links() {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." ";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['s'])) { $site = 1; } elseif($_GET['s'] <= 0 || $_GET['s'] > $num_news) { $site = 1; } else { $site = $_GET['s']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'/'.$prev.'.html">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'/'.$i.'.html">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'/'.$next.'.html">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	include("core/link_item.html");
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}



function get_links_by_cat() {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." ";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['s'])) { $site = 1; } elseif($_GET['s'] <= 0 || $_GET['s'] > $num_news) { $site = 1; } else { $site = $_GET['s']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'/'.$prev.'.html">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'/'.$i.'.html">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'/'.$next.'.html">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	include("core/link_item.html");
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}


/*function getPageContentMain() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $get_sub_cat['text']; 
}
}*/


?>