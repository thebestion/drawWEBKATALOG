<script language="javascript" type="text/javascript">  
  tinyMCE.init({
    theme : "advanced",
    mode: "exact",
    elements : "elm1",
    plugins : "style,table,advhr,advimage,insertdatetime,paste,fullscreen,noneditable,visualchars,",
    theme_advanced_toolbar_location : "top",
    theme_advanced_buttons1 : "fullscreen,bold,italic,underline,strikethrough,separator,"
    + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,hr,advhr,bullist,numlist,outdent,indent",
    theme_advanced_buttons2 : "link,unlink,anchor,image,separator,undo,redo,cleanup,code,separator,sub,sup,charmap,insertdate,inserttime,",
    theme_advanced_buttons3 :"",
    height:"250px",
    width:"604px",
  });
</script>
<br /><br />
<h2>Best&auml;tigungs Mails bearbeiten</h2>

<table border="0" width="640" height="30">
	<tr>
		<td id="item" height="15" width="640">
        <a href="index.php?s=emails&p=free_mail" title="Bearbeiten"><strong>E-mail für Kostenlose Eintr&auml;ge bearbeiten</strong></a>
        </td>
	</tr>
	<tr>
		<td id="item" height="15" width="640">
        <a href="index.php?s=emails&p=prem_mail" title="Bearbeiten"><strong>E-mail für Premium Eintr&auml;ge bearbeiten</strong></a>
        </td>
	</tr>
</table>

<?
############### Update Email Data #################
if($_POST['send']=="1") {

$mail = $_POST['mail'];
$free_mail = $_POST['free_mail'];
$prem_mail = $_POST['prem_mail'];

dbconnect();
if($mail=="free_mail"){
$sql_update_mail ="UPDATE `".get_db_table("emails")."` SET `free_mail`='".$free_mail."' ";
}elseif($mail=="prem_mail"){
$sql_update_mail ="UPDATE `".get_db_table("emails")."` SET `prem_mail`='".$prem_mail."'  ";}
mysql_query($sql_update_mail) OR die("error");
echo"<meta http-equiv='refresh' content='0; URL=index.php?s=emails'>";
#echo "<strong><font color='#00c909'>Daten wurden gespeichert.</strong></font><br /><br />";
}
?>

<? if($pageid=="free_mail" OR $pageid=="prem_mail"){ ?>
<form action="" method="post">
<input type="hidden" name="send" value="1" />
<input type="hidden" name="mail" value="<?=$pageid;?>" />
<table border="0" width="650" height="264">
	<tr>
    
		<td height="18" width="650"><br /><br /><h2><strong>Email Bearbeiten:</strong></h2><br />
        <div class='buttonwrapper2'><a class='boldbuttons' href='index.php?s=emails'><span>Schließen</span></a></div><br />
        <? if($pageid=="free_mail"){ ?>
        <textarea rows="7" name="free_mail" id="elm1" cols="70"<? echo get_free_mail();?></textarea>
        <? }elseif($pageid=="prem_mail"){ ?>
        <textarea rows="7" name="prem_mail" id="elm1" cols="70"<? echo get_prem_mail();?></textarea>
        <? } ?>
        </td>
        
	</tr>
	<tr>
		<td height="23" width="650"><br /><br />
        <input type="submit" class="submit" value="Speichern" />
        </td>
	</tr>
</table>
</form>
<? } ?>