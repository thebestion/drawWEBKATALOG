<br /><br />
<?  
######## DELETE Link ##############
if($subpage=="del") {
include("core/del_new_link.htm");
if($delquest=="YES") { del_link($pageid); echo"<meta http-equiv='refresh' content='0; URL=index.php?s=link_suche&ps=".$pagesite."&q=".$query."'>"; }
}
?>
<br />
<form action="index.php" method="get">
<input type="hidden" value="link_suche" name="s" />
<input type="text" size="55" name="q" />
<input type="submit" class="submit2" value="Suchen" />
</form>
<br /><br />
<?  
$query=$_GET['q'];
# index.php?s=link_suche&q=aachen
$pageurl="index.php?s=".$page."&q=".$q;
$limit="50";

if($query !=""){
	dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE beschreibung LIKE '%".$query."%' ";
    $query_cat = mysql_fetch_row(mysql_query($sqltag_cat));
    list($gesamt_cat) = $query_cat;
	if($gesamt_cat!="0") {
    $num_news = ceil($gesamt_cat/$limit);
    if(empty($_GET['ps'])) { $site = 1; } elseif($_GET['ps'] <= 0 || $_GET['ps'] > $num_news) { $site = 1; } else { $site = $_GET['ps']; }
    $links = array();
    if($site != 1) { $prev = $site-1;
    $links[] = '<a href="'.$pageurl.'&site='.$prev.'">zur&uuml;ck</a>'; }
    for($i=1;$i<=$num_news;$i++) {
    if($i == $site) { $links[] = '<a class="aktiv_item"><b>'.$i.'</b></a>'; } else {
	$links[] = '<a class="itemlink" href="'.$pageurl.'&site='.$i.'">'.$i.'</a>'; }}
    if($site != $num_news) { $next = $site+1;	
	$links[] = '<a href="'.$pageurl.'&site='.$next.'">weiter</a>'; }
    $link_string = implode(" <font id='news_site_cutter'></font> ", $links);
    $news_bar="<div id='item_bar'>Seiten: ".$link_string."</div>";
    if($gesamt_cat !== "0") { $show_cat_bar=$news_bar; }
    $start = ($site-1)*$limit;
	echo "<h3>Gefundene Eintr&auml;ge: ".$gesamt_cat."</h3>";
	echo $show_cat_bar;
	echo'<br /><div align="left"><table border="0" id="cmspages" width="890">';
    dbconnect();
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE beschreibung LIKE '%".$query."%' ORDER BY ratinglink LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_link'];
	include("core/link_suche.html");
    }
    
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden!</h2>"; }
	} else { echo "<h2>Ein Suchwort eingeben!</h2>"; } 
echo'</table></div><br />';
echo $show_cat_bar;


?>

<br /><br />
