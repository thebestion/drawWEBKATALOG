<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################
header ("content-type: text/xml");
include("configs/config.inc.php");
include("configs/functions.inc.php");
$page_url=get_setting_data("url"); 
echo'<?xml version="1.0" encoding="UTF-8" ?>';
echo'<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">';
echo "<url><loc>".$page_url."</loc>";
echo "<lastmod>2009-07-06</lastmod>";
echo "<changefreq>weekly</changefreq>";
echo "<priority>1.0</priority></url>";

dbconnect();
$sql_sitemap_data = "SELECT * FROM ".get_db_table('page')." ";
$result_sitemap_data = mysql_query($sql_sitemap_data) OR die(mysql_error());
while($get_sitemap = mysql_fetch_assoc($result_sitemap_data))
{
$sitemap_url = $page_url."/".$get_sitemap['url']."/1.html";
echo "<url><loc>".$sitemap_url."</loc>";
echo "<lastmod>2009-07-06</lastmod>";
echo "<changefreq>monthly</changefreq>";
echo "<priority>0.5</priority></url>";
}

dbconnect();
$sql_sitemap_data2 = "SELECT * FROM ".get_db_table('categorie')." WHERE aktiv = 'ja' ";
$result_sitemap_data2 = mysql_query($sql_sitemap_data2) OR die(mysql_error());
while($get_sitemap2 = mysql_fetch_assoc($result_sitemap_data2))
{
if($get_sitemap2['id_ober_kategorie'] == "0"){ $paid="2"; } else { $paid="3"; }
$sitemap_url = $page_url."/".$get_sitemap2['alias']."/". $paid.".html";
echo "<url><loc>".$sitemap_url."</loc>";
echo "<lastmod>2009-07-06</lastmod>";
echo "<changefreq>monthly</changefreq>";
echo "<priority>0.5</priority></url>";
}


#7-draw-design/4.html
dbconnect();
$sql_sitemap_data2 = "SELECT * FROM ".get_db_table('link')." WHERE isfreigeschaltet = '1' ";
$result_sitemap_data2 = mysql_query($sql_sitemap_data2) OR die(mysql_error());
while($get_sitemap2 = mysql_fetch_assoc($result_sitemap_data2))
{
if($get_sitemap2['id_ober_kategorie'] == "0"){ $paid="2"; } else { $paid="3"; }
$sitemap_url = $page_url."/".$get_sitemap2['id_link']."-".getUrlName($get_sitemap2['url'])."/4html";
echo "<url><loc>".$sitemap_url."</loc>";
echo "<lastmod>2009-07-06</lastmod>";
echo "<changefreq>monthly</changefreq>";
echo "<priority>0.5</priority></url>";
}

echo"</urlset>";
?>