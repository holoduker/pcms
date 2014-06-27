<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

define("MODULETITLE","О компании");
define("MODULENAME","about");
define("CACHENAME","about");
define("MODULEID","1");

switch ($action)
{
	case "update":
	$form=new cms_dataform();
	$form->action="content.php?module=".MODULENAME."&action=update&mode=do";
	$form->title=MODULETITLE;
	$form->addControl(new cms_edit("title_ru","Заголовок (ru)"));
	$form->addControl(new cms_edit("title_en","Заголовок (en)"));
	$fulltext_control=new cms_text("text_ru","Текст (ru)");
	$fulltext_control->wysiwyg=true;
	$fulltext_control->rows=20;
	$form->addControl($fulltext_control);
	$fulltext_control=new cms_text("text_en","Текст (en)");
	$fulltext_control->wysiwyg=true;
	$fulltext_control->rows=20;
	$form->addControl($fulltext_control);
	$img=new cms_file_image("pic","Фото");
	$img->path="pics/pr/";
	$form->addControl($img);
	$form->addControl(new cms_button("Сохранить"));

	if($mode=="show")
	{
		$sql="select pr_title_ru, pr_title_en, pr_text_ru, pr_text_en, pr_pic
			from cms_pressrelease
			where pr_id=".MODULEID;
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["title_ru"]->value=$row["pr_title_ru"];
			$form->controls["title_en"]->value=$row["pr_title_en"];
			$form->controls["text_ru"]->value=$row["pr_text_ru"];
			$form->controls["text_en"]->value=$row["pr_text_en"];
			$form->controls["pic"]->value=$row["pr_pic"];
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sqlfile2="";
			$ctrl2=$form->controls['pic'];
			$res=$ctrl2->save('pics/pr/','pic');
			$ctrl2->path="../pics/pr/";
			$ctrl2->fitImage(200,400);
			if($res==0)//ошибка
			{
				print("Не удалось загрузить фото");
				$form->show();
				return;
			}
			else if($res==2)//сохранено
			{
				$sql="select pr_pic from cms_pressrelease where pr_id='".MODULEID."'";
				$db->open($sql);
				if(($row=$db->fetch()))
				{
					if($row["pr_pic"]!="")
					unlink('../pics/pr/'.$row["pr_pic"]);
				}
				$sqlfile2="pr_pic='".$ctrl2->value."',";
			}
			clearCache(CACHENAME);
			$sql="update cms_pressrelease set
				".$sqlfile2."
				pr_title_ru='".$form->data["title_ru"]."',
				pr_title_en='".$form->data["title_en"]."',
				pr_text_ru='".$form->data["text_ru"]."',
				pr_text_en='".$form->data["text_en"]."'
				where pr_id='".MODULEID."'";
			if($db->exec($sql))
			{
				$messagebox=new CMessageBox("Данные обновлены");
				$messagebox->Icon=MB_ICON_OK;
				$messagebox->Show();
			}
			else
			{
				$messagebox=new CMessageBox("Произошла ошибка при обновлении");
				$messagebox->Icon=MB_ICON_ERROR;
				$messagebox->Show();
			}
		}
		$form->show();
	}
break;

}

?>