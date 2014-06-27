<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
//define("IN_CMS",1);
define("STARTPAGE",1);

include_once('../include/sub.initcms.inc.php');

if($_POST["login"] && $_POST["password"] )
{
	$auth = new auth();
	if($id=$auth->login(safevar($_POST["login"]),safevar($_POST["password"])))
	{  
		$_SESSION["sitesession"]=$id;
		exit(header("Location: main.php"));
	}
	else
	{
		unset($_SESSION["sitesession"]);
		$error=1;
	}
}
elseif(!empty($_POST))$error=1;


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>site :: pCMS 2 :: Вход в систему управления контентом</title>

	<meta http-equiv="Content-Language" content="ru">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

	<link rel="stylesheet" type="text/css" href="/css/admin.css" title="style">
	
	<link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js" type="text/javascript"></script> 
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="Robots" content="noindex, nofollow">
</head>
<body topmargin="0" leftmargin="0">

<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" >

<tr>
	<td align="center" valign="center">
		<form action="index.php" method="post">

			<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" style="width: 350px; position: relative;">
				<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
					<span class="ui-dialog-title">Вход в систему</span>
					<span class="ui-icon ui-icon-locked" style="position: absolute; right: .3em;"></span>
				</div>
				<div style="height: 170px; min-height: 170px; width: auto;" class="ui-dialog-content ui-widget-content">
					<?php
					if($error)
					{
						$mb=new CMessageBox("Вы ввели неверный логин и/или пароль!");
						$mb->Icon=MB_ICON_ERROR;
						$mb->Show();
					}
					?>
					<br>
					<table cellspacing="0" cellpadding="1" border="0" align="center">
					<tr>
						<td width="25%">Логин</td>
						<td width="75%"><input type="text" name="login" maxlength="20" class="text ui-widget-content ui-corner-all"></td>
					</tr>
					<tr>
						<td>Пароль</td>
						<td><input type="password" name="password" class="text ui-widget-content ui-corner-all"></td>
					</tr>
					<tr>
						<td></td><td><input class="submit" type="submit" value="Войти"></td>
					</tr>
					</table>
				</div>
			</div>


			<script>
			$(function() {
			$( "input:submit", ".submit" ).button();
			});
			</script>

		</form>
	</td>	
</tr>

</table>

</body>
</html>