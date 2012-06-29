<br />
<br />
<h2>Eintr&auml;ge nach Kategorien</h2>
<div align="left">

<? 
$catid=$_GET['catid'];

gotoCategorieDropdown(); 

if($catid!=""){

if(get_cat_titel_by_id(get_cat_ober_kategorie_by_id($catid))!=""){ $obercat="<a href='index.php?s=link_cat&catid=".get_cat_ober_kategorie_by_id($catid)."'>".get_cat_titel_by_id(get_cat_ober_kategorie_by_id($catid))."</a> -> "; }
echo "<h2>".$obercat."<a href='index.php?s=link_cat&catid=".$catid."'>".get_cat_titel_by_id($catid)."</a></h2>";

####### Eintrag Liste ##########################################################
$pageurl="index.php?s=".$page."&catid=".$catid;
$limit="50";
$orderby="id_link";

dbconnect();
    $sqltag_cat="SELECT COUNT(*) FROM ".get_db_table("link")." WHERE id_kategorie = ".$catid." ";
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
	$sql_cat = "SELECT * FROM ".get_db_table("link")." WHERE id_kategorie = ".$catid." ORDER BY ".$orderby." DESC LIMIT ".$start.",".$limit."";
	$result_cat = mysql_query($sql_cat) OR die(mysql_error());
    while($get_cat = mysql_fetch_assoc($result_cat))
    {
	$get_seite_id=$get_cat['id_link'];
	if($get_cat['typ']==1) { $item_prem='<img src="img/star.png" border="0" alt="Premiumeintrag" />'; } else { $item_prem=""; }
	if($get_cat['isfreigeschaltet']==1) { $item_aktiv="accept.png"; } else { $item_aktiv="page_tick.gif"; }
	include("core/cat_temp.html");
    }
    
	} else { echo "<h2>Keine Eintr&auml;ge vorhanden</h2>"; }


echo'</table></div><br />';
if($gesamt_cat !== "0") { echo $news_bar2; }

}
?>
</div>






