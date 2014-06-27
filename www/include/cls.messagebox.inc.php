<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
// PCMS MessageBox class. Version 2.0

define("MB_ICON_OK",		1);
define("MB_ICON_ERROR",		2);
define("MB_ICON_WARNING",	3);
define("MB_ICON_QUESTION",	4);

class CMessageBox {
	
	var $Text;
	var $Title;
	var $Icon;
	var $Buttons;

	function __construct($text="")
	{
	$this->Text=$text;
	$this->Title="PCMS Application";
	$this->Icon=0;
	$this->Buttons="";
	}
	
	function Show()
	{
	if($this->Icon==MB_ICON_ERROR){
		?>
		<div class="ui-widget">
			<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
				<?php echo $this->Text;?></p>
			</div>
		</div>
		<?php
		}else{
		?>
		<div class="ui-widget">
			<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
				<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span> 
				<?php echo $this->Text;?></p>
			</div>
		</div>
		<?php
		}
	}
}

?>