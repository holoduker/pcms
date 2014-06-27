<div style="padding: 15px 15px 15px 15px;">
<?php
include_once("modules/module.projects.inc.php");
$CacheThis=true;

if(isset($_GET["id"]))
{
	$page=new CPageComponent();
	$page->ModuleClass="CModuleProjects";
	$page->DataID=intval($_GET["id"]);
	$page->Mode=SHOWMODE_DETAIL;
	$page->ShowContentBox();
}
else
{
	$page=new CPageComponent();
	$page->ModuleClass="CModuleProjects";
	$page->Mode=SHOWMODE_LIST;
	$page->ShowContentBox();
}
?>
</div>
