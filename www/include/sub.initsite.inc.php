<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
define("IN_SITE",1);

//ini_set("magic_quotes_gpc","0");
ini_set("default_charset","windows-1251");

$SiteTitle="";
$SiteKeywords="";
$CacheThis=false;
$NeedLIGHTBOX=false;
$NeedMP3=false;

// L10n Support

// Список доступных локалей
$AvailableLanguages=array("ru","en");

$lang="ru";
if(isset($_SESSION["lang"]))
{
    if(in_array($_SESSION["lang"],$AvailableLanguages))
        $lang=$_SESSION["lang"];
}
if(isset($_GET["lang"]))
{
    if(in_array($_GET["lang"],$AvailableLanguages))
        $lang=$_GET["lang"];
}
define("LANG",$lang);
unset($locale);

require_once('language/'.LANG.'.inc.php');
// L10n End

if(isset($_GET['p']) && !empty($_GET['p']) && $_GET['p']!='')$p=htmlspecialchars($_GET['p'],ENT_QUOTES,"cp1251");
else $p='main';

ob_start("ob_gzhandler");
// кэширование
$pageContent=@file_get_contents("cache/$p/".LANG."/".sha1($_SERVER["QUERY_STRING"]));
if($pageContent)
{
	// set file-date
	header("Last-Modified: " . gmdate("D, d M Y H:i:s", filemtime("cache/$p/".LANG."/".sha1($_SERVER["QUERY_STRING"]))) . " GMT");
	echo $pageContent;
	ob_end_flush();
	exit();
}
 
session_start();
ob_start("myob_handler");

if(!file_exists('pages/page.'.$p.'.inc.php'))$p='404';

if(isset($_GET['r']) && !empty($_GET['r']) && $_GET['r']!='')$r='.'.htmlspecialchars($_GET['r'],ENT_QUOTES,"cp1251").'.';
else $r='.';

if(!file_exists('pages/page.'.$p.$r.'inc.php')){$p='404';$r='.';}


// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");

require_once('sub.utility.inc.php');
require_once('cls.db.inc.php');
require_once('cls.auth.inc.php');
//require_once('cls.messagebox.inc.php');
require_once('cls.module.inc.php');
require_once('cls.pagecomponent.inc.php');

define("DB_HOST","");
define("DB_USER","");
define("DB_PSWD","");
define("DB_NAME","");

$db=new db();
$db->connect(DB_HOST,DB_USER,DB_PSWD,DB_NAME);

$AllowEdit=false;
$session="";
if(isset($_SESSION["sitesession"]))
{
	$session=$_SESSION["sitesession"];
	$auth=new auth();
	if($auth->logged($session))$AllowEdit=true;
}

function myob_handler($buffer)
{
	global $SiteTitle, $SiteKeywords, $CacheThis, $p, $NeedPrettyPhoto, $Lang;
	if($SiteTitle!="")
	$SiteTitle=$Lang["SiteTitle"]." [".$SiteTitle."]";
	else
	$SiteTitle=$Lang["SiteTitle"];
	
	//$SiteKeywords.="";
	$SiteTitle=substr($SiteTitle,0,780);
	$str=str_replace("%SITETITLE%", $SiteTitle, $buffer);
	//$str=str_replace("%SITEKEYWORDS%", $SiteKeywords, $str);
	if($NeedPrettyPhoto)
	{
		$gallery='<link rel="stylesheet" href="/lib/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
			<script src="/lib/prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>';
		$str=str_replace("%NEEDPRETTYPHOTO%", $gallery, $str);
	}
	else $str=str_replace("%NEEDPRETTYPHOTO%", "", $str);

	// Выполнить кэширование этой страницы
	if($CacheThis)
	{
		//file_put_contents("cache/$p/".LANG."/".sha1($_SERVER["QUERY_STRING"]), $str, LOCK_EX);
	}

	return $str;
}
?>