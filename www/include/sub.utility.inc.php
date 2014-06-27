<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/

function safevar($value)
{
	$str=htmlspecialchars($value,ENT_QUOTES,"cp1251");
	if (!get_magic_quotes_gpc())
	$str=mysql_real_escape_string($str);
	if(strtolower($str)==str_replace(array("select", "drop", "update", "--", "insert",  "delete", "replace"),"",strtolower($str)))
		return $str;
	else
		return "";
}

function sitestr($string)
{
	return html_entity_decode($string,ENT_QUOTES,"cp1251");
}


/**
* @desc �������� email � ��������� ����� � ������� ���������
* @param string $to ����� ����������
* @param string $subg ���� ������
* @param string $msg ����� ���������
* @return bool ������, ���� ��������� �������
*/
function SendEmail($to, $subj, $msg)
{
	$header="Return-Path: <somemail@example.com>\r\nFrom: somemail@example.com <somemail@example.com>\r\nReply-To: <somemail@example.com>\r\nContent-Type: text/html; charset=\"koi8-r\"\r\nContent-Language: ru\r\nContent-Transfer-Encoding: 8bit\r\n";
	$message='
<html>
<head>
<title>somemail@example.com</title>
</head>
<body leftmargin=20>
<p align="justify" style="font-family: Times New Roman, serif; font-size: 14px; color: #000000">
'.$msg.'
<br><br>
� ���������,<br>
somemail@example.com
</p>
</body>
</html>';

	$message=convert_cyr_string($message,'w','k');
	$subj=convert_cyr_string($subj,'w','k');
	$header=convert_cyr_string($header,'w','k');
	return mail($to,$subj,$message,$header);
}

// Anti-spam filter stub
function SpamTestClear($param1,$param2,$param3)
{
		return true;
}

function clearCache($module)
{
	$files=scandir("../cache/".$module);
	foreach($files as $file)
	{
		if($file!="." && $file!="..")unlink("../cache/".$module."/".$file);
	}

}

function urlTranslit($str)
{
	$tr = array(
		"�"=>"a","�"=>"b","�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"e","�"=>"j","�"=>"z","�"=>"i",
		"�"=>"y","�"=>"k","�"=>"l","�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r","�"=>"s","�"=>"t",
		"�"=>"u","�"=>"f","�"=>"h","�"=>"ts","�"=>"ch","�"=>"sh","�"=>"sch","�"=>"","�"=>"yi","�"=>"",
		"�"=>"e","�"=>"yu","�"=>"ya","�"=>"a","�"=>"b","�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"e","�"=>"j",
		"�"=>"z","�"=>"i","�"=>"y","�"=>"k","�"=>"l","�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
		"�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h","�"=>"ts","�"=>"ch","�"=>"sh","�"=>"sch","�"=>"y",
		"�"=>"yi","�"=>"","�"=>"e","�"=>"yu","�"=>"ya", 
        	" "=> "-","~"=> "","`"=> "","!"=> "","@"=> "","#"=> "","$"=> "","%"=> "","^"=> "","&"=> "","*"=> "","("=> "",
        	")"=> "","_"=> "","="=> "","+"=> "","\\"=> "","|"=> "","{"=> "","}"=> "","["=> "","]"=> "",":"=> "",";"=> "",
		"'"=> "","\""=> "",","=> "","<"=> "","."=> "",">"=> "","?"=> "","/"=> ""
	);                                                 
	return strtr($str,$tr);
}

?>