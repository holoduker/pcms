<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
// PCMS Database class. Version 2.0

if(!defined("IN_CMS") && !defined("IN_SITE"))die("Invalid script call");

class db {

	var $db;//database resource
	var $stmt;//statements resource
	var $connected;
	var $fieldvalues;
	var $fieldvalues_all;
	var $reccount;
	var $affected;
	var $cursorposition;
	var $eof;
	var $bof;

	function db()
	{
		$this->db=null;
		$this->stmt=null;
		$this->connected=false;
		$this->fieldvalues=array();
		$this->fieldvalues_all=array();
		$this->reccount=-1;
		$this->affected=-1;
		$this->cursorposition=-1;
		$this->eof=true;
		$this->bof=true;
	}

	function connect($srv,$usr,$psw,$db)
	{

		$this->db=@mysql_connect($srv,$usr,$psw);
		if(!$this->db) return false;
		if(!@mysql_select_db($db,$this->db)) return false;
		$this->connected=true;
		$this->exec("SET NAMES cp1251");
		return true;
	}

	function open($sql)
	{
		if ($sql=='' || !$this->connected) return false;
		$this->fieldvalues=array();
		$this->fieldvalues_all=array();
		$this->reccount=0;
		$this->affected=-1;
		$i=0;
		$this->stmt=@mysql_query($sql,$this->db);
	}

	function exec($sql)
	{
		if ($sql=='' || !$this->connected) return false;

		$this->reccount=-1;
		$this->affected=0;
		$this->cursorposition=-1;
		$this->eof=true;
		$this->bof=true;

		$rs="";
		$rs=@mysql_query($sql,$this->db);
		if($rs)
		{
			$this->affected=mysql_affected_rows($this->db);
			return true;
		}
		else
			return false;
	}

	function fetch()
	{
		$this->fieldvalues=mysql_fetch_array($this->stmt);
		return $this->fieldvalues;
	}

	function fetch_all()
	{
		if($this->stmt)
		{
			$i=0;
			while (($row = mysql_fetch_array($this->stmt)))
			{
				$this->fieldvalues_all[$i]=$row;
				$i++;
			}
			mysql_free_result($this->stmt);
			$this->reccount=$i;
			$this->cursorposition=0;
			if($this->reccount==0)
				$this->eof=true;
			else	
				$this->eof=false;
			$this->bof=true;
			$this->fieldvalues=$this->fieldvalues_all[0];
			return true;
		}
		return false;
	}

	function first()
	{
		if (!$this->connected) return false;
		$this->cursorposition=0;
			if($this->reccount==0)
				$this->eof=true;
			else	
				$this->eof=false;
			$this->bof=true;
		$this->fieldvalues=$this->fieldvalues_all[0];
	}

	function next()
	{
		if (!$this->connected) return false;
		if($this->cursorposition!=-1 && $this->cursorposition<$this->reccount-1)
		{
			$this->cursorposition++;
			$this->bof=false;
			$this->fieldvalues=$this->fieldvalues_all[$this->cursorposition];
			return true;
		}
		else
		{
			$this->eof=true;
			return false;
		}
	}

	function prev()
	{
		if (!$this->connected) return false;
		if($this->cursorposition>0)
		{
			$this->cursorposition--;
			$this->eof=false;
			$this->fieldvalues=$this->fieldvalues_all[$this->cursorposition];
			return true;
		}
		else
		{
			$this->bof=true;
			return false;
		}
	}

	function gotorec($newpos)
	{
		if (!$this->connected) return false;
		if($newpos>=0 && $newpos<$this->reccount && $this->cursorposition!=-1)
		{
			$this->cursorposition=$newpos;
			$this->eof=false;
			$this->bof=false;
			$this->fieldvalues=$this->fieldvalues_all[$this->cursorposition];
			return true;
		}
		else return false;

	}

	function close()
	{
		$this->reccount=-1;
		$this->affected=-1;
		$this->cursorposition=-1;
		$this->eof=true;
		$this->bof=true;
		$this->fieldvalues=array();
		$this->fieldvalues_all=array();
	}

	function lastid()
	{
		if($this->connected && $this->affected>=0 && $this->reccount==-1)
		return mysql_insert_id($this->db);
		else
		return 0;
	}

}
?>