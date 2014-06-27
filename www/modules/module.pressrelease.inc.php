<?php
class CModulePressrelease extends CModule
{
	function ShowList()
	{
	}
	
	function DoListAction()
	{
		
	}

	/**
	 * 
	 * Показывает только текст релиза
	 */
	function ShowShort()
	{
		global $db;
		$sql="select pr_text_".LANG." AS pr_text
				from cms_pressrelease
				where pr_id='".$this->DataID."'";
		$db->open($sql);
		$row=$db->fetch();
		echo sitestr($row["pr_text"]);
	}
	
	function DoShortAction()
	{
		
	}
	
	function ShowDetail()
	{
		global $db;
		$sql="select pr_title_".LANG." AS pr_title, pr_text_".LANG." AS pr_text, pr_pic
				from cms_pressrelease
				where pr_id='".$this->DataID."'";
		$db->open($sql);
		$row=$db->fetch();
		?>
		<h1><?php echo sitestr($row["pr_title"]);?></h1>
		<?php 
		if($row["pr_pic"]!="")echo "<img src=\"/pics/pr/".$row["pr_pic"]."\" class=\"cI\" alt=\"\"/>";
		echo sitestr($row["pr_text"]);
	}
	
	function DoDetailAction()
	{
		
	}
}
?>