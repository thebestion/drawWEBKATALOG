<br />
<br />
<h2>Kostenlose Eintr&auml;ge</h2>
<div id="popup1" class="msg"><h3>Eintrag wurde gelöscht!</h3></div>
<?  
######## DELETE Link ##############
if($subpage=="del") {
include("core/del_new_link.htm");
if($delquest=="YES") { del_link($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=link_free&ps=".$pagesite."'>"; }
}


####### kostenlose Einträge ##########################################################
$pageurl="index.php?s=".$page."";
$limit="50";
$orderby="id_link";

dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE isfreigeschaltet = 1 AND typ = 0 ";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['ps'])) { $site = 1; } elseif($_GET['ps'] <= 0 || $_GET['ps'] > $num_news) { $site = 1; } else { $site = $_GET['ps']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'&ps='.$prev.'.html">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
    $links[] = '<a class="itemlink" href="'.$pageurl.'&ps='.$i.'.html">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;
    $links[] = '<a href="'.$pageurl.'&ps='.$next.'.html">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="Eintr&auml;ge Gesamt:<strong>".$gesamt_cat."</strong><br /><div id='item_bar'>Seiten: ".$link_string."</div>";
	$news_bar2="<div id='item_bar'>Seiten: ".$link_string."</div>";
    #if($gesamt_cat !== "0") { echo $news_bar; }
    $start = ($site-1)*$limit;
	if($gesamt_cat !== "0") { echo $news_bar; }
	echo'<div align="left"><table border="0" id="cmspages" width="890">';
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE isfreigeschaltet = 1 AND typ = 0 ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_link'];
	if($get_cat['typ']==1) { $item_look="seite_item_star"; $item_look_bottom="seite_item_bottom_star"; } 
	else { $item_look="seite_item"; $item_look_bottom="seite_item_bottom"; }
	include("core/link_free.html");
    }
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }


echo'</table></div><br />';
if($gesamt_cat !== "0") { echo $news_bar2; }
?>






