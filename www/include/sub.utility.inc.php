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
* @desc отправка email с указанной темой и текстом сообщения
* @param string $to Адрес получателя
* @param string $subg Тема письма
* @param string $msg Текст сообщения
* @return bool истина, если выполнено успешно
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
С уважением,<br>
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
		"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
		"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n","О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
		"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch","Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
		"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j",
		"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
		"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h","ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
		"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
        	" "=> "-","~"=> "","`"=> "","!"=> "","@"=> "","#"=> "","$"=> "","%"=> "","^"=> "","&"=> "","*"=> "","("=> "",
        	")"=> "","_"=> "","="=> "","+"=> "","\\"=> "","|"=> "","{"=> "","}"=> "","["=> "","]"=> "",":"=> "",";"=> "",
		"'"=> "","\""=> "",","=> "","<"=> "","."=> "",">"=> "","?"=> "","/"=> ""
	);                                                 
	return strtr($str,$tr);
}

?>