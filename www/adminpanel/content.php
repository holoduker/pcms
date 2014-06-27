<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
/**
* CMS Content Page
*/

ob_start("ob_gzhandler");
include_once('../include/sub.initcms.inc.php');
define("CONTENT_PAGE_CALL",1);

$action=$_POST["action"];
if(empty($action))$action=$_GET["action"];
if(empty($action))$action="list";
$action=htmlspecialchars($action,ENT_QUOTES,"cp1251");
if (!get_magic_quotes_gpc())
$action=addslashes($action);

$mode=$_POST["mode"];
if(empty($mode))$mode=$_GET["mode"];
if(empty($mode))$mode="show";
$mode=htmlspecialchars($mode,ENT_QUOTES,"cp1251");
if (!get_magic_quotes_gpc())
$mode=addslashes($mode);

$id=$_POST["id"];
if(empty($id))$id=$_GET["id"];
if(empty($id))$id="";
$id=htmlspecialchars($id,ENT_QUOTES,"cp1251");
if (!get_magic_quotes_gpc())
$id=addslashes($id);

if(isset($_GET['module']) && !empty($_GET['module']) && $_GET['module']!='')$module=$_GET['module'];
else $module='error';

if(!file_exists('modules/module.'.$module.'.inc.php'))$module='error';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta content="text/html; charset=windows-1251" http-equiv=Content-Type>
	<title>site :: pCMS 2 :: Вход в систему управления контентом</title>

	<link rel="stylesheet" type="text/css" href="/css/admin.css" title="style">

	<link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js" type="text/javascript"></script> 

	<script language="javascript" type="text/javascript" src="/lib/tinymce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript" src="/lib/tinymce/enable_tinymce.js"></script>

	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="Robots" content="noindex, nofollow">
</head>
<body>
<?php

include('modules/module.'.$module.'.inc.php');

?>
</body></html>
<?php
ob_end_flush();
?>