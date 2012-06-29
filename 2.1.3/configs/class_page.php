<?
####################################
#
# COPYRIGHT BY Sebastian Harke 2010
#
####################################

class Page {

private $Title = "";

public function getUrl($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title = htmlentities($get_sub_cat['url']); 
}
} 

public function getName($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title = htmlentities($get_sub_cat['name']); 
}
}

public function getNameHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title = htmlentities($get_sub_cat['name']); 
}
}

public function getTitle($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title = htmlentities($get_sub_cat['titel']); 
}
}

public function getTitleHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title = htmlentities($get_sub_cat['titel']); 
}
}

public function getContent($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['text']; 
}
}

public function getContentHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['text']; 
}
}

public function getContentFile($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['file']; 
}
}

public function getContentFileHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['file']; 
}
}


public function getContentOption($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['content_option']; 
}
}

public function getContentOptionHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  $get_sub_cat['content_option']; 
}
}

public function getKeywords($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  htmlentities($get_sub_cat['meta_keywords']); 
}
}

public function getKeywordsHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  htmlentities($get_sub_cat['meta_keywords']); 
}
}

public function getDescription($title) {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE url = '".$title."' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  htmlentities($get_sub_cat['meta_beschreibung']); 
}
}

public function getDescriptionHome() {
dbconnect();
$sql_sub_cat       = "SELECT * FROM ".get_db_table("page")." WHERE home = '1' ";
$query_sub_cat     = mysql_query($sql_sub_cat);
while($get_sub_cat = mysql_fetch_assoc($query_sub_cat)){
return $this->Title =  htmlentities($get_sub_cat['meta_beschreibung']); 
}
}

}

?>