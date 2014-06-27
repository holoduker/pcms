<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
include_once('../include/sub.initcms.inc.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta content="text/html; charset=windows-1251" http-equiv=Content-Type>
	<title>Система управления контентом pCMS</title>
	<link rel="stylesheet" type="text/css" href="/css/admin.css">
	
	<link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js" type="text/javascript"></script> 

	<link type="text/css" rel="stylesheet" href="/lib/treeview/jquery.treeview.css">
	<link type="text/css" rel="stylesheet" href="/lib/treeview/screen.css">
	<script src="/lib/treeview/jquery.cookie.js" type="text/javascript"></script>
	<script src="/lib/treeview/jquery.treeview.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(function() {
			$("#browser").treeview();
		});
	</script>
</head>
<body>

	<ul id="browser" class="filetree">
		<li>
			<span class="folder">site.ru</span>
			<ul>
				<li><span class="file"><a target="content" href="content.php?module=about&action=update&mode=show">О компании</a></span></li>
				<li><span class="file"><a target="content" href="content.php?module=projects&action=list">Проекты</a></span></li>
				<li><span class="file"><a target="content" href="photo_start.php">Фотогалерея</a></span></li>
				<li><span class="file"><a target="content" href="content.php?module=contacts&action=update&mode=show">Контакты</a></span></li>
				<li class="closed">
					<span class="folder">Администрирование</span>
					<ul>
						<li><span class="file"><a target="content" href="content.php?module=admins&action=list">Администраторы</a></span></li>
						<li><span class="file"><a target="content" href="content.php?module=clearcache&action=list">Очистка кэша</a></span></li>
					</ul>
				</li>
				<li><span class="file"><a target="content" href="content.php?module=logout">Выход</a></span></li>
				<li><span class="file"><a target="content" href="content.php?module=pcms">О Программе</a></span></li>
			</ul>
		</li>
	</ul>

</body>
</html>