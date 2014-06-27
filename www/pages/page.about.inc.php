<?php
include_once("modules/module.pressrelease.inc.php");

$SiteTitle=$Lang["MainMenuAbout"];
$CacheThis=true;
?>
		<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
		<tr>
			<td width="70%" style="line-height: 140%; padding: 15px;" valign="top">

				<?php 
				$page=new CPageComponent();
				$page->ModuleClass="CModulePressrelease";
				$page->Mode=SHOWMODE_DETAIL;
				$page->DataID="1";
				$page->ShowContentBox();
				?>

				<br/><br/>

			</td>
			<td width="30%" bgcolor="#cdcdcd" valign="bottom" style="padding: 15px; line-height: 140%;">
				<table width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr><td valign="top" style="font-size: 12pt; line-height: 150%">
				&nbsp;
				</td></tr><tr><td valign="bottom">
					<h1 style="color: #555;">&nbsp;</h1>

						<?php 
						$page=new CPageComponent();
						$page->ModuleClass="CModulePressrelease";
						$page->Mode=SHOWMODE_SHORT;
						$page->DataID="3";
						$page->ShowContentBox();
						?>
						
				</td></tr></table>

			</td>
		</tr>
		</table>
