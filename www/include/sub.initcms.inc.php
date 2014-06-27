<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
define("IN_CMS",1);
//ini_set("magic_quotes_gpc","0");
ini_set("default_charset","windows-1251");

session_start();

include_once('sub.utility.inc.php');
include_once('cls.db.inc.php');
include_once('cls.auth.inc.php');
include_once('cls.form.inc.php');
include_once('cls.messagebox.inc.php');
include_once('cls.contentpage.inc.php');

define("DB_HOST","");
define("DB_USER","");
define("DB_PSWD","");
define("DB_NAME","");

$db=new db();

$db->connect(DB_HOST,DB_USER,DB_PSWD,DB_NAME);

$auth=new auth();

if(isset($_SESSION["sitesession"]))$session=$_SESSION["sitesession"];
else $session="";

if(defined("STARTPAGE"))return;
if(!$auth->logged($session))
{
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
	</head>
	<body>
	<?php
	$mb=new CMessageBox("Доступ запрещен или закончилась рабочая сессия.<br><br><a href='/adminpanel/' target='_top'>Повторный вход &rarr;</a>");
	$mb->Icon=MB_ICON_ERROR;
	$mb->Show();
	die();
}
?>