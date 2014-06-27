<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/

class CModule
{
	var $Mode;
	var $DataID;
	
	function CModule($mode=SHOWMODE_LIST,$dataid="")
	{
		$this->Mode=$mode;
		$this->DataID=$dataid;
	}
	
	function ShowModule()
	{
		switch($this->Mode)
		{
			case SHOWMODE_LIST:
				$this->DoListAction();
				$this->ShowList();
				break;
			case SHOWMODE_SHORT:
				$this->DoShortAction();
				$this->ShowShort();
				break;
			case SHOWMODE_DETAIL:
				$this->DoDetailAction();
				$this->ShowDetail();
				break;
		}
	}
	
	function ShowList()
	{

	}
	
	function DoListAction()
	{
		
	}
	
	function ShowShort()
	{
		
	}
	
	function DoShortAction()
	{
		
	}
	
	function ShowDetail()
	{
		
	}
	
	function DoDetailAction()
	{
		
	}
}

?>