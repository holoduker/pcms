<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/

define("CONTENTBOX_NORMAL",		0x0001);
define("CONTENTBOX_FLOWER",		0x0002);
define("CONTENTBOX_WHITE",		0x0003);

define("SHOWMODE_LIST",				0x0001);
define("SHOWMODE_SHORT",			0x0002);
define("SHOWMODE_DETAIL",			0x0003);

class CPageComponent
{
	var $Title;
	var $BackImage;
	var $Style;
	var $ContentBoxType;
	var $ModuleClass;
	var $Mode;
	var $DataID;
	var $ModuleClassCreated;
	var $Module;
	var $ForceNewModuleClass;
	
	function CPageComponent()
	{
		$this->Title="";
		$this->BackImage="";
		$this->Style="width: 100%;";
		$this->ContentBoxType=CONTENTBOX_NORMAL;
		$this->ModuleClass="CModule";
		$this->Mode=SHOWMODE_LIST;
		$this->DataID="";
		$this->ModuleClassCreated=false;
		$this->Module=null;
		$this->ForceNewModuleClass=false;
	}
	
	function ShowContentBox()
	{
		$this->CreateModuleClass();
		if($this->Title!="")echo "<h1>".$this->Title."</h1>";
		$this->Module->ShowModule();

		//switch($this->ContentBoxType)
		//{
		//	case CONTENTBOX_NORMAL:
		//
		//	ShowContentBoxNormal($this->Title, $this->Module, $this->BackImage, $this->Style);
		//	break;
		//}
	}
	
	function CreateModuleClass()
	{
		if(!$this->ModuleClassCreated || $this->ForceNewModuleClass)
		{
			$this->Module=eval("return new ".$this->ModuleClass."(".$this->Mode.",\"".$this->DataID."\");");
			$this->ModuleClassCreated=true;
		}
		else 
		{
			$this->Module->Mode=$this->Mode;
			$this->Module->DataID=$this->DataID;
		}
	}
}
?>