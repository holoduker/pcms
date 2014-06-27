<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/
// PCMS authorization and authentification class. Version 1.0

//if(!defined("IN_CMS"))die("Invalid script call");

class auth
{

	function login($login,$password)
	{
		global $db;

		if($login=='' || $password=='') return 0;

		$sql=sprintf("SELECT admin_id FROM cms_admin WHERE STRCMP(admin_login,'%s')=0 AND
									 STRCMP(admin_password,SHA('%s'))=0",trim($login),trim($password));
		
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$id=$row["admin_id"];
			session_regenerate_id();
			$session=sha1(uniqid(rand()));
				$sql="DELETE FROM cms_admin_session WHERE cas_date<(DATE_SUB(NOW(),INTERVAL 1 HOUR))";
			$db->exec($sql);
				$sql=sprintf("INSERT INTO cms_admin_session SET cas_admin_id=%d,cas_session='%s'",$id,$session);
			$db->exec($sql);
				return $session;
		}
		else return 0;
	}

	// без авторизации, только аутентификация
	function logged($session,$module="all")
	{
		global $db;
		
		if(empty($session)) return 0;
		if(empty($module))$module="cms_navigation";
		$ret=0;

		$sql="DELETE FROM cms_admin_session WHERE cas_date<(DATE_SUB(NOW(),INTERVAL 1 HOUR))";
		$db->exec($sql);

		$sql=sprintf("SELECT cas_admin_id FROM cms_admin_session WHERE cas_session='%s'",$session);
		$db->open($sql);
		$row=$db->fetch();
		$ret=$row["cas_admin_id"];
		// обновляем данные для продления сессии, через час бездействия сессия истечет
		$sql=sprintf("UPDATE cms_admin_session SET cas_date=NOW() WHERE cas_session='%s'",$session);
		$db->exec($sql);
		return $ret;// удалить эту строку, если включаем авторизацию ниже
		
		/**
		 * @todo Аудит!!! Время логина, логофа, действия (авторизация объектов, SQL-запросы, user-defined) - успех/отказ
		 */
		// авторизация - проверяем доступность объектов данному юзеру
		// в данной версии не реализуется
		//$sql="SELECT acs_access FROM cms_permission LEFT JOIN cms_module ON acs_object=module_id WHERE acs_user='$ret' AND module_name='$module'";
		//if($GLOBALS['db']->open($sql))
		//{
		//	$permission=$GLOBALS['db']->fieldvalues["acs_access"];
		//	if($permission=='1')return $ret;
		//	else return 0;
		//}
		//else return 0;

		return 0;
	}


	function logout($session)
	{
		global $db;
		
		if(empty($session)) return true;

		$sql=sprintf("DELETE FROM cms_admin_session WHERE cas_date<(DATE_SUB(NOW(),INTERVAL 1 HOUR)) OR cas_session='%s'",$session);
		$db->exec($sql);
		return true;
	}

}

?>