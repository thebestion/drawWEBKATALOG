<?php
define("TEMPLATE_ERR_FILE","Could not load template file.");
class Template {
var $delimiterStart = "{";
var $delimiterEnd = "}";
var $t;
var $templatefile;
function Template($filename = "") {
$this->loadTemplateFile($filename); }
function setStartDelim($delim="{") {
$this->delimiterStart = $delim; }
function setEndDelim($delim="}") {
$this->delimiterEnd = $delim; }
function loadTemplateFile($filename = "") {
if (!$filename)
return false;
if ($filename)
$this->templatefile = $filename;
if (!$fp = @fopen($this->templatefile,'r')) {
die(TEMPLATE_ERR_FILE); }
$this->t = fread($fp,filesize($this->templatefile));
fclose($fp);
$this->_initTemplate(); }
function loadTemplateContent($templatestring="") {
$this->t = $templatestring;
$this->_initTemplate(); }
function _initTemplate() {
preg_match_all("/<!--\s+BEGIN\s+(.*)?\s+-->\s*\n*\s*(.*)\s*\n*\s*<!--\s+END\s+(\\1)\s+-->/ms",$this->t,$ma);
for ($i = 0; $i < count($ma[0]); $i++) {
$search = "/\s*\n*<!--\s+BEGIN\s+(" . $ma[1][$i] . ")?\s+-->(.*)<!--\s+END\s+(" . $ma[1][$i]. ")\s+-->\s*\n*/ms";
$replace = $this->delimiterStart . $ma[1][$i] . $this->delimiterEnd;
$this->bl[$ma[1][$i]] =& new Template();
$this->bl[$ma[1][$i]]->loadTemplateContent($ma[2][$i]);
$this->t = preg_replace($search,$replace,$this->t); } }
function fetchBlock($blockName) {
if (isset($this->bl[$blockName]))
return $this->bl[$blockName];
else return false; }
function assign($varName,$varValue=false) {
if (is_array($varName)) {
foreach ($varName as $key => $value) {
$this->pl[$key][] = $value; } }
else { $this->pl[$varName][] = $varValue; } }
function reset() {
unset($this->pl); }
function out() {
print $this->get(); }
function get() {
if (is_array($this->pl)) {
foreach ($this->pl as $key => $value) {
$search = $this->delimiterStart . $key . $this->delimiterEnd;
$replaceText = "";
for ($i = 0; $i < count($this->pl[$key]); $i++) {
if (is_object($this->pl[$key][$i]))
$replaceText .= $this->pl[$key][$i]->get();
else
$replaceText .= $this->pl[$key][$i]; }
$this->t = str_replace($search,$replaceText,$this->t); } }
return $this->t; } }
?>