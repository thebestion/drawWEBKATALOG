<br />
<br />
<h2>Neue Eintr&auml;ge</h2>
<?  
######## DELETE Link ##############
if($subpage=="del") {
include("core/del_new_link.htm");
if($delquest=="YES") { del_link($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=links&ps=".$pagesite."'>"; }
}


####### Link freischalten ##########################################################
if($subpage=="aktiv") {
if(get_link_aktiv_by_id($pageid)=="0"){ $ca_aktiv='1'; }else{ $ca_aktiv='0'; }
dbconnect();
$sql_cat_work = "UPDATE `".get_db_table("link")."` SET `isfreigeschaltet`='".$ca_aktiv."' WHERE `id_link`='".$pageid."' ";
mysql_query($sql_cat_work) OR die("error");
##### Bestätigungs Mail senden #####

if(get_link_typ($pageid)=="0")
{
$mail_txt=get_free_mail();
}elseif(get_link_typ($pageid)=="1")
{
$mail_txt=get_prem_mail();
# eintrag in prem_links
add_premlink($pageid,get_prempaydate(),get_prempayenddate(),get_premrememberdate());
}

$profil_url = get_setting_data(url)."/".$pageid."-".getUrlName(getItemLinkById($pageid))."/4.html";
$mt1 = str_replace("{webkataloglogo}", get_setting_data('url')."/".get_setting_data('logo'), $mail_txt);
$mt2 = str_replace("{webkatalogname}", get_setting_data('name'), $mt1);
$mt3 = str_replace("{profil_url}", $profil_url, $mt2);
$mt4 = str_replace("{passwort}", get_link_passwort_by_id($pageid), $mt3);
$mt  = str_replace("{url}", get_link_url_by_id($pageid), $mt4);

$webmasterMail=get_setting_data("email");
$subject="Bestätigungs E-Mail von ".get_setting_data("name");
$mailUser=get_link_email($pageid);
$header .= "From: $webmasterMail\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
$header .= "X-Mailer: PHP ". phpversion();

$mail='<html><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#FFFFFF"><div align="center"><table style="margin-top:10px; margin-bottom:15px;color:#000000; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px;" border="0" width="619px" cellpadding="0" cellspacing="0"><tr><td valign="top" width="619px" height="300px"><br>'.$mt.'<br></td></tr></table></body></html>';
mail($mailUser,$subject,$mail,$header);
echo "<h3>Best&auml;tigungs E-Mail gesendet!</h3>";
}


####### Link Liste ##########################################################
$pageurl="index.php?s=".$page."";
$limit="50";
$orderby="id_link";

dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE isfreigeschaltet = 0 ";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['ps'])) { $site = 1; } elseif($_GET['ps'] <= 0 || $_GET['ps'] > $num_news) { $site = 1; } else { $site = $_GET['ps']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'&ps='.$prev.'">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'&ps='.$i.'">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'&ps='.$next.'">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="Eintr&auml;ge Gesamt:<strong>".$gesamt_cat."</strong><br /><div id='item_bar'>Seiten: ".$link_string."</div>";
	$news_bar2="<div id='item_bar'>Seiten: ".$link_string."</div>";
    #if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
	if($gesamt_cat !== "0") { echo $news_bar; }
	echo'<div align="left"><table border="0" id="cmspages" width="890">';
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = 0 ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_link'];
	if($get_cat['typ']==1) { $item_prem='<img src="img/star.png" border="0" alt="Premiumeintrag" />'; } else { $item_prem=""; }
	if($get_cat['isfreigeschaltet']==1) { $item_aktiv="accept.png"; } else { $item_aktiv="page_tick.gif"; }
	include("core/link_item.html");
    }
    
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }


echo'</table></div><br />';
if($gesamt_cat !== "0") { echo $news_bar2; }
?>








