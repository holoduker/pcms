<?php
include_once("modules/module.clients.inc.php");

$SiteTitle=$Lang["MainMenuClients"];
$CacheThis=true;
?>
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
<tr>
	<td width="100%" style="line-height: 140%; padding: 15px;" valign="top">
		<h1><?php echo $Lang["ClientsOur"]?></h1>

	<?php
	$page=new CPageComponent();
	$page->ModuleClass="CModuleClients";
	$page->DataID="1";
	$page->Mode=SHOWMODE_LIST;
	$page->ShowContentBox();
	?>
	</td></tr>
<tr>
	<td width="100%" style="line-height: 140%; padding: 15px;" valign="top">
		<h1><?php echo $Lang["ClientsPast"]?></h1>
		<?php
		$page=new CPageComponent();
		$page->ModuleClass="CModuleClients";
		$page->DataID="0";
		$page->Mode=SHOWMODE_LIST;
		$page->ShowContentBox();
		?>
	</td>
</tr>
</table>
