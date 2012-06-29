<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

function get_db_table($data) {
global $prefix;
return "".$prefix."".$data."";
}

function get_date() {
$now=date("d.m.Y, H:i:s",time());
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

function getCaptchaCode($lng=8) {
    mt_srand((double)microtime()*1000000);
    $charset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $length  = strlen($charset)-1;
    $code    = '';
    for($i=0;$i<$lng;$i++) {
      $code .= $charset{mt_rand(0, $length)};
    }
    return $code;
}

function checkCapatcha(){
$captchaValidierungOk = false;
if (!empty($_SESSION['captcha_code']) &&                   // code in der session
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


function linkedit_login($pass,$linkid) {
    dbconnect();
    $query = "SELECT `id_link`, `isfreigeschaltet`, `passwort`  FROM ".get_db_table("link")." WHERE id_link = '".$linkid."' AND isfreigeschaltet ='1' ";
    $result =  mysql_query($query);
    dbconnect();
    $result =  mysql_query("SELECT `id_link`, `isfreigeschaltet`, `passwort`  FROM ".get_db_table("link")." WHERE id_link = '$linkid' AND isfreigeschaltet ='1' ");
    $zeileholen =  mysql_fetch_array($result);
    if (!$zeileholen) { die ("<meta http-equiv='refresh' content='0; URL=5.html'></SCRIPT><script language='JavaScript'>(window-alert('Passwort nicht gefunden!!'))</script>"); }
    if ($zeileholen["passwort"] <> $pass)
    { die ("<meta http-equiv='refresh' content='0; URL=5.html'></SCRIPT><script language='JavaScript'>(window-alert('Sorry, aber dieses Passwort passt nicht zur Seite!!'))</script>");
    } else {
	$_SESSION['draw_webkatalog_usid'] = $zeileholen["passwort"];
	$_SESSION['draw_webkatalog_linkid'] = $zeileholen["id_link"];
    session_register('draw_webkatalog_usid');
	session_register('draw_webkatalog_linkid');
    }
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


function getAdminPW(){
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table('admin')." WHERE Id = 1 ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $get_sub_cat['Kennwort'];
}
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
list($gesamt_sub_cat1) = $query0001;
return $gesamt_sub_cat1;
}

function countAllCats() {
dbconnect();
$sqltag0002="SELECT COUNT(*) FROM  ".get_db_table('categorie')." WHERE aktiv = 'ja' ";
$query0002 = mysql_fetch_row(mysql_query($sqltag0002));
list($gesamt_sub_cat2) = $query0002;
return $gesamt_sub_cat2;
}


function get_count_cat_links($cat_id) {
dbconnect();
$sqltag0003="SELECT COUNT(*) FROM  ".get_db_table('link')."  WHERE id_kategorie = '".$cat_id."' AND isfreigeschaltet = '1' ";
$query0003 = mysql_fetch_row(mysql_query($sqltag0003));
list($gesamt_sub_cat3) = $query0003;
return $gesamt_sub_cat3;
}


function countallsubcatlinks($cid){
$i="0";
$gesamt_sub_cat = array();
dbconnect();
$sql_sub_cat       = "SELECT * FROM  ".get_db_table('categorie')." WHERE id_ober_kategorie = '".$cid."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
$i++;
$subcat = $get_sub_cat['id_kategorie'].",";
$subcat2 = $get_sub_cat['id_kategorie'];
dbconnect();
$sqltag0004="SELECT COUNT(*) FROM  ".get_db_table('link')." WHERE id_kategorie = '".$subcat2."' AND isfreigeschaltet = '1' ";
$query0004 = mysql_fetch_row(mysql_query($sqltag0004));
list($gesamt_sub_cat[$i]) = $query0004;
}
return array_sum($gesamt_sub_cat);
}



function get_cat_id_by_linkid($link_id) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $get_sub_cat['id_kategorie'];
}
}


function get_cat_name_by_id($cat_id) {
dbconnect();
$sql_name_cat       = "SELECT * FROM  ".get_db_table('categorie')."  WHERE id_kategorie = '".$cat_id."' ";
$query_name_cat     = mysql_query($sql_name_cat);
while($get_title_cat = mysql_fetch_assoc($query_name_cat)){
return $get_title_cat['titel'];
}
}


function get_link_rating_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['ratinglink'];
}
}


function get_link_datum_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['datum'];
}
}


function get_link_title_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['titel'];
}
}


function get_link_beschreibung_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['beschreibung'];
}
}


function get_link_keywords_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['keywords'];
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

function get_link_passwort_by_id($link_id) {
dbconnect();
$sql_klicks_cat       = "SELECT * FROM  ".get_db_table('link')."  WHERE id_link = '".$link_id."' ";
$query_klicks_cat     = mysql_query($sql_klicks_cat);
while($get_klicks_cat = mysql_fetch_assoc($query_klicks_cat)){
return $get_klicks_cat['passwort'];
}
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
echo '<select name="category">';
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




function getItemLinkById($item_id){
dbconnect();
$sql_link       = "SELECT * FROM ".get_db_table('link')."  WHERE id_link = ".$item_id." ";
$result_link    = mysql_query($sql_link) OR die(mysql_error());
while($get_link = mysql_fetch_assoc($result_link)){
return $get_link['url'];
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



function get_alias_to_cat_metadescription($cat_alias){
dbconnect();
$sqltag_beschreibung="SELECT COUNT(*) FROM  ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_beschreibung = mysql_fetch_row(mysql_query($sqltag_beschreibung));
list($gesamt_sub_cat) = $query_beschreibung;
if($gesamt_sub_cat=="1") {
dbconnect();
$sql_cat_beschreibung       = "SELECT * FROM ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_cat_beschreibung     = mysql_query($sql_cat_beschreibung);
while($get_cat_beschreibung = mysql_fetch_assoc($query_cat_beschreibung)){
return $get_cat_beschreibung['meta_description']; }
}
}



function get_alias_to_cat_metakeywords($cat_alias){
dbconnect();
$sqltag_beschreibung="SELECT COUNT(*) FROM  ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_beschreibung = mysql_fetch_row(mysql_query($sqltag_beschreibung));
list($gesamt_sub_cat) = $query_beschreibung;
if($gesamt_sub_cat=="1") {
dbconnect();
$sql_cat_beschreibung       = "SELECT * FROM ".get_db_table('categorie')."  WHERE alias = '".$cat_alias."'";
$query_cat_beschreibung     = mysql_query($sql_cat_beschreibung);
while($get_cat_beschreibung = mysql_fetch_assoc($query_cat_beschreibung)){
return $get_cat_beschreibung['meta_keywords']; }
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
	$temppath="templates/".get_aktiv_layout_data("layout_path")."content_temp/cat_item.html";
	include($temppath);
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}



function get_top100($cat_id) {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE isfreigeschaltet = '1' AND typ = '1'";
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
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = '1' AND typ = '1' ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	$temppath="templates/".get_aktiv_layout_data("layout_path")."content_temp/cat_item.html";
	include($temppath);
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}

function get_newpags($cat_id) {
    global $pageurl, $orderby, $limit, $cat, $mod;
    dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE isfreigeschaltet = '1'";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat < 150){ $gesamt_cat=$gesamt_cat; } else { $gesamt_cat="150"; }
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
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = '1' ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	$temppath="templates/".get_aktiv_layout_data("layout_path")."content_temp/cat_item.html";
	include($temppath);
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
}


function get_array_banner($typ){
$i="0";
$banner_array = array();
dbconnect();
$sql_sub_cat       = "SELECT * FROM  ".get_db_table('banner')."  WHERE bannertyp = '".$typ."' AND aktiv = 1 ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
$i++;
$banner_array[$get_sub_cat['Id']] = $get_sub_cat['Id'].",";
}
return array_rand($banner_array);
}





function get_banner($bannerid,$typ){
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table(banner)." WHERE Id = '$bannerid' AND bannertyp = '$typ' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
$code_code = $get_sub_cat['bannercode']; 
}
return $code_code; 
}


function get_search($query) {
    global $pageurl, $limit, $cat, $mod;
    if($query !=""){
	dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE beschreibung LIKE '%".$query."%' AND isfreigeschaltet = '1'";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['s'])) { $site = 1; } elseif($_GET['s'] <= 0 || $_GET['s'] > $num_news) { $site = 1; } else { $site = $_GET['s']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="index.php?c='.$cat.'&m='.$mod.'&s='.$prev.'&q='.$query.'">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
	$links[] = '<a class="itemlink" href="index.php?c='.$cat.'&m='.$mod.'&s='.$i.'&q='.$query.'">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;	
	$links[] = '<a href="index.php?c='.$cat.'&m='.$mod.'&s='.$next.'&q='.$query.'">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE beschreibung LIKE '%".$query."%' AND isfreigeschaltet = '1' ORDER BY ratinglink LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_kategorie'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	$temppath="templates/".get_aktiv_layout_data("layout_path")."content_temp/cat_item.html";
	include($temppath);
    }
    echo $show_cat_bar;
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }
	} else { echo ""; } 
}



/*function getPageContentMain() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $get_sub_cat['text']; 
}
}*/





function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0) {
    $result = false; 
    $contents = @file_get_contents($url);
    if (isset($contents) && is_string($contents)) {
        preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
        if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1) {
            if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections){
                return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
            }         
            $result = false;
        } else {
            $result = $contents;
        }
    }
    return $contents;
}


function getUrlData($url,$option) {
    $result = false;   
    $contents  = getUrlContents($url);
	
	
    if (isset($contents) && is_string($contents))    {
        $title = null;
        $metaTags = null;    
		$links = null;   
       
	    preg_match('/<title>([^>]*)<\/title>/si', $contents, $match ); 
		if (isset($match) && is_array($match) && count($match) > 0) { $title = strip_tags($match[1]); 
		}
		
        preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);			  
		if (isset($match) && is_array($match) && count($match) == 3) {
            $originals = $match[0];
            $names = $match[1];
            $values = $match[2];
            if (count($originals) == count($names) && count($names) == count($values)) {
                $metaTags = array();              
                for ($i=0, $limiti=count($names); $i < $limiti; $i++) {                  
				$metaTags[$names[$i]] = array (
                        'html' => htmlentities($originals[$i]),
                        'value' => $values[$i]
                    );
                }
            }
        } 
		
					  		
        $result = array (
            'title' => $title,
            'metaTags' => $metaTags,		
        );
    
	
# Page Title
if($result['title'] != "") { $title = $result['title']; }
elseif($result['metaTags']['title']['value'] != "") { $title = $result['metaTags']['title']['value']; }
elseif($result['metaTags']['Title']['value'] != "") { $title = $result['metaTags']['Title']['value']; }
elseif($result['metaTags']['TITLE']['value'] != "") { $title = $result['metaTags']['TITLE']['value']; }
elseif($result['metaTags']['DC.Title']['value'] != "") { $title = $result['metaTags']['DC.Title']['value']; }
elseif($result['metaTags']['DC.title']['value'] != "") { $title = $result['metaTags']['DC.title']['value']; }
elseif($result['metaTags']['DC.TITLE']['value'] != "") { $title = $result['metaTags']['DC.TITLE']['value']; }
elseif($result['metaTags']['Page-topic']['value'] != "") { $title = $result['metaTags']['Page-topic']['value']; }
elseif($result['metaTags']['page-topic']['value'] != "") { $title = $result['metaTags']['page-topic']['value']; }
elseif($result['metaTags']['PAGE-TOPIC']['value'] != "") { $title = $result['metaTags']['PAGE-TOPIC']['value']; }
if( $title =="" ) { $title2=$site; } else { $title2=$title; }

# Keywords
if($result['metaTags']['DC.keywords']['value'] != "") { $keywords = $result['metaTags']['DC.keywords']['value']; }
elseif($result['metaTags']['keywords']['value'] != "") { $keywords = $result['metaTags']['keywords']['value']; }
elseif($result['metaTags']['Keywords']['value'] != "") { $keywords = $result['metaTags']['Keywords']['value']; }
elseif($result['metaTags']['KEYWORDS']['value'] != "") { $keywords = $result['metaTags']['KEYWORDS']['value']; }
elseif($result['metaTags']['DC.KEYWORDS']['value'] != "") { $keywords = $result['metaTags']['DC.KEYWORDS']['value']; }
elseif($result['metaTags']['DC.Keywords']['value'] != "") { $keywords = $result['metaTags']['DC.Keywords']['value']; }
elseif($result['metaTags']['DC.keywords']['value'] != "") { $keywords = $result['metaTags']['DC.keywords']['value']; }

# Description
if($result['metaTags']['description']['value'] != "") { $description = $result['metaTags']['description']['value']; }
elseif($result['metaTags']['DC.description']['value'] != "") { $description = $result['metaTags']['DC.description']['value']; }
elseif($result['metaTags']['DC.Description']['value'] != "") { $description = $result['metaTags']['DC.Description']['value']; }
elseif($result['metaTags']['DESCRIPTION']['value'] != "") { $description = $result['metaTags']['DESCRIPTION']['value']; }
elseif($result['metaTags']['DC.DESCRIPTION']['value'] != "") { $description = $result['metaTags']['DC.DESCRIPTION']['value']; }
elseif($result['metaTags']['Description']['value'] != "") { $description = $result['metaTags']['Description']['value']; }

# Generator
if($result['metaTags']['generator']['value'] != "") { $generator = $result['metaTags']['generator']['value']; }
elseif($result['metaTags']['Generator']['value'] != "") { $generator = $result['metaTags']['Generator']['value']; }
elseif($result['metaTags']['GENERATOR']['value'] != "") { $generator = $result['metaTags']['GENERATOR']['value']; }
elseif($result['metaTags']['DC.generator']['value'] != "") { $generator = $result['metaTags']['DC.generator']['value']; }
elseif($result['metaTags']['DC.Generator']['value'] != "") { $generator = $result['metaTags']['DC.Generator']['value']; }
elseif($result['metaTags']['DC.GENERATOR']['value'] != "") { $generator = $result['metaTags']['DC.GENERATOR']['value']; }
	
}
	
if($option=="title") { return $title; }
if($option=="keywords") { return $keywords; }
if($option=="description") { return $description; }
if($option=="generator") { return $generator; }
}


function getAlexaRank($url){
$alexa_rank = "http://alexa.com/siteinfo/".$url;
$alexaQuery = file_get_contents($alexa_rank);
$pos = strpos($alexaQuery, '<div class="data up">');
if ($pos === false) { $alexaContent = explode('<div class="data down">',$alexaQuery);
} else { $alexaContent = explode('<div class="data up">',$alexaQuery); }
$alexaContent2 = explode('</a>',$alexaContent[1]);
return $alexaContent2[0];
}

function getAlexaLinkIn($url){
$alexa_rank = "http://alexa.com/siteinfo/".$url;
$alexaQuery = file_get_contents($alexa_rank);
$alexaContent = explode('<div class="data"><a href="/site/linksin/',$alexaQuery);
$alexaContent2 = explode('</a>',$alexaContent[1]);
$alexaContent3 = explode('>',$alexaContent2[0]);
if($alexaContent3[1]=="No data"){ return 0;} else { return $alexaContent3[1]; }
}


?>