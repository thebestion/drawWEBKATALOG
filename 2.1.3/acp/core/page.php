<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Webkatalog ACP: <?=$page_name;?></title>
       <meta name="robots" content="noindex,nofollow">
       <link rel="stylesheet" href="img/style.css" type="text/css">
       <link rel="shortcut icon" href="img/fav.ico" />
</head>
<body>

<div id="login">
<div align="center">
  <table cellpadding="0" cellspacing="0" width="160" height="162">
    <tr>
      <td width="160" height="162">
      <div align="left">
	  <img border="0" src="img/logo.gif" style="padding-left:35px;"><br /><br /><br>

      <form action="index.php" method="post">
      
      <b>Benutzername : </b><br>
      <input type='text' name='username' size='30' maxlength='20'><br>
      
      <b>Kennwort :</b> <br><input type='password' name='passwort' size='30' maxlength='20'><br>
      <input type='submit' class="submit_login" name='absenden' value='login'>
      
      </form>

      </div>
      </td>
    </tr>
  </table>
  
<div id="drawdesign"><br>
drawWEBKATALOG Engine &copy; <?=date(Y); ?> by <a href="http://www.draw-design.com" target="_blank" title="www.draw-design.com">www.draw-design.com</a>
</div>
  
</div>
</div>

</body>
</html>
