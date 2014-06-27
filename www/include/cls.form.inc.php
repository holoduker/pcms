<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
// PCMS Form class. Version 1.0

include_once('cls.control.inc.php');

class cms_form extends control {

	var $method;
	var $enctype;
	var $action;
	var $controls;
	var $data;
	var $title;
	

	function cms_form($action="")
	{
		$this->method='post';
		$this->enctype='multipart/form-data';
		$this->action=$action;
		$this->controls=array();
		$this->data=array();
		$this->title="";
	}

	function show()
	{
		?>
		<form method="<?php echo $this->method?>" action="<?php echo $this->action?>" enctype="<?php echo $this->enctype?>">
		<table width="90%" class="clsControlLabel">
		<tr><td colspan="2"><h1><?php echo $this->title; ?></h1></td></tr>
		<?php
		foreach ($this->controls as $control)
		{
			$control->show();
		}
		?>
		</table>
		</form>
		<?php
	}

	function parse($specialchars=true)
	{     
		$success=true;
		foreach ($this->controls as $i => $control)
		{
			$id=$control->id;
			if(is_array($_POST[$id]))
			{
				$value=array();
				foreach ($_POST[$id] as $key => $val)
				{
					if($specialchars)
					$value[$key]=htmlspecialchars($val,ENT_QUOTES,"cp1251");
					else
					$value[$key]=$val;
					if (!get_magic_quotes_gpc())
					$value[$key]=addslashes($value[$key]);
				}
			}
			else 
			{
				if($specialchars)
				$value=htmlspecialchars($_POST[$id],ENT_QUOTES,"cp1251");
				else
				$value=$_POST[$id];
				if(!empty($_FILES[$id]))
				$value=$_FILES[$id]["name"];
				if (!get_magic_quotes_gpc())
				$value=addslashes($value);
			}
			
			if($this->controls[$i]->validate($value))
			{ 
				$this->controls[$i]->makeformvalue($value);
				$this->data[$id]=$this->controls[$i]->makesqlvalue($value);
			}
			else $success=false;
			
		}
		return $success;
	}

	function addControl($control)
	{
		if($control->id!="")
		$this->controls[$control->id]=$control;
		else
		$this->controls[]=$control;
	}
	
}

class cms_dataform extends cms_form {
	
	var $tableprefix;
	var $tablename;
	
	function cms_dataform($action="")
	{
		cms_form::cms_form($action);
		$this->tableprefix="";
		$this->tablename="";
	}

	function showlist()
	{
		
	}
	
	function insert()
	{
		
	}
	
	function update()
	{
		
	}
	
	function delete()
	{
		
	}
	
}

?>