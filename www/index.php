<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
require('include/sub.initsite.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title>%SITETITLE%</title>

	<meta http-equiv="Content-Language" content="<?php echo $Lang["SiteLanguage"]?>"/>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

	<meta name="keywords" content=""/>
	<meta name="description" content="<?php echo $Lang["SiteTitle"]?>"/>
	<meta name="Copyright" content="(c) Copyright. 2012. All rights reserved"/>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	

	<!--link rel="shortcut icon" type="image/ico" href="/favicon.ico" -->
	<link rel="stylesheet" type="text/css" href="/css/main.css?6" title="style" media="all"/>

	%NEEDPRETTYPHOTO%
	
	<meta http-equiv="pragma" content="no-cache"/>
	<meta http-equiv="cache-control" content="no-cache"/>
	<meta name="Robots" content="index, all"/>
	<meta name="Revisit" content="7 days"/>
</head>
<body>
	<div id="langSection">
		<?php if(LANG=="ru"){?><a href="/en/">English</a> | Русский<?php }else {?>
                    English | <a href="/ru/">Русский</a><?php }?>
	</div>
	<div id="topTitle">&nbsp;<?php echo $Lang["TopTitle"]?></div>
	<?php include('pages/page.'.$p.$r.'inc.php'); ?>
</body>
</html>
<?php
ob_end_flush();
ob_end_flush();
?>