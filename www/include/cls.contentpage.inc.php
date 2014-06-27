<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
// Content page class. Version 1.0

class content_page {

	var $form;
	var $action;
	var $mode;

	var $FormCreate;
	var $ActionHandler;
	var $OnShowInsert;
	var $OnDoInsert;
	var $OnShowUpdate;
	var $OnDoUpdate;
	var $OnShowDelete;
	var $OnDoDelete;
	var $OnShowList;


	function content_page($action, $mode)
	{
		$this->FormCreate='DefaultFormCreate';
		$this->ActionHandler='DefaultActionHandler';
		$this->OnShowInsert='DefaultShowInsert';
		$this->OnDoInsert='DefaultDoInsert';
		$this->OnShowUpdate='DefaultShowUpdate';
		$this->OnDoUpdate='DefaultDoUpdate';
		$this->OnShowDelete='DefaultShowDelete';
		$this->OnDoDelete='DefaultDoDelete';
		$this->OnShowList='DefaultShowList';

		$this->action=$action;
		$this->mode=$mode;
		
		$this->FormCreate='DefaultFormCreate';
		$this->ActionHandler='DefaultActionHandler';

	}

	function show()
	{
		$FormCreate=$this->FormCreate;
		$FormCreate($this);
		$ActionHandler=$this->ActionHandler;
		$ActionHandler($this);
	}

}

	function DefaultActionHandler($obj)
	{

		switch ($this->action)
		{
			case "insert":
			if($obj->mode=="show")
			{
				$obj->OnShowInsert();
			}
			else if($obj->mode=="do")
			{
				$obj->OnDoInsert();
			}
			break;

			case "update":
			if($obj->mode=="show")
			{
				$obj->OnShowUpdate();
			}
			else if($obj->mode=="do")
			{
				$obj->OnDoUpdate();
			}
			break;

			case "delete":
			if($obj->mode=="show")
			{
				$obj->OnShowDelete();
			}
			else if($obj->mode=="do")
			{
				$obj->OnDoDelete();
			}
			break;

			default://list
			$OnShowList=$obj->OnShowList();
			$OnShowList();
		}

	}

	function DefaultFormCreate($obj)
	{
		$obj->form=new cms_dataform();
		echo "hello";
	}

	function DefaultShowInsert()
	{

	}

	function DefaultDoInsert()
	{

	}

	function DefaultShowUpdate()
	{

	}

	function DefaultDoUpdate()
	{

	}

	function DefaultShowDelete()
	{

	}

	function DefaultDoDelete()
	{

	}

	function DefaultShowList()
	{
	echo "show listing";
	}

?>
