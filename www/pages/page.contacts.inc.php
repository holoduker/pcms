<?php
include_once("modules/module.pressrelease.inc.php");

$SiteTitle=$Lang["MainMenuAbout"];
$CacheThis=true;
?>
<div style="padding: 15px 15px 15px 15px;">
<?php 
$page=new CPageComponent();
$SiteTitle=$page->Title;
$page->ModuleClass="CModulePressrelease";
$page->Mode=SHOWMODE_DETAIL;
$page->DataID="2";
$page->ShowContentBox();
?>
</div>