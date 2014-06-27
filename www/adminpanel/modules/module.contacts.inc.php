<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

define("MODULETITLE","��������");
define("MODULENAME","contacts");
define("CACHENAME","contacts");
define("MODULEID","2");

switch ($action)
{
	case "update":
	$form=new cms_dataform();
	$form->action="content.php?module=".MODULENAME."&action=update&mode=do";
	$form->title=MODULETITLE;
	$fulltext_control=new cms_text("text_ru","����� (ru)");
	$fulltext_control->wysiwyg=true;
	$fulltext_control->rows=20;
	$form->addControl($fulltext_control);
	$fulltext_control=new cms_text("text_en","����� (en)");
	$fulltext_control->wysiwyg=true;
	$fulltext_control->rows=20;
	$form->addControl($fulltext_control);
	$img=new cms_file_image("pic","����");
	$img->path="pics/pr/";
	$form->addControl($img);
	$form->addControl(new cms_button("���������"));

	if($mode=="show")
	{
		$sql="select pr_text_ru, pr_text_en, pr_pic
			from cms_pressrelease
			where pr_id=".MODULEID;
		$db->open($sql);
		if(($row=$db->fetch()))
		{
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
			if($res==0)//������
			{
				print("�� ������� ��������� ����");
				$form->show();
				return;
			}
			else if($res==2)//���������
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
				pr_text_ru='".$form->data["text_ru"]."',
				pr_text_en='".$form->data["text_en"]."'
				where pr_id='".MODULEID."'";
			if($db->exec($sql))
			{
				$messagebox=new CMessageBox("������ ���������");
				$messagebox->Icon=MB_ICON_OK;
				$messagebox->Show();
			}
			else
			{
				$messagebox=new CMessageBox("��������� ������ ��� ����������");
				$messagebox->Icon=MB_ICON_ERROR;
				$messagebox->Show();
			}
		}
		$form->show();
	}
break;

}

?>