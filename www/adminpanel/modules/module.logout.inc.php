<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

$auth = new auth();
$auth->logout($_SESSION["sitesession"]);
unset($_SESSION["sitesession"]);
?>
<script language="JavaScript">
window.open('/adminpanel/','_top');
</script>