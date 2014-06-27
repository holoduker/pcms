<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

switch ($action)
{
	case "insert":
	$form=new cms_dataform();
	$form->action="content.php?module=projects&action=insert&mode=do";

	$form->title="Проекты // Добавление";
	$form->addControl(new cms_edit("title_ru","Заголовок (ru)"));
	$form->addControl(new cms_edit("title_en","Заголовок (en)"));
	$form->addControl(new cms_datetime("date","Дата события"));
	$text_control=new cms_text("shorttext","Короткий текст (анонс)");
	$text_control->wysiwyg=false;
	$text_control->rows=20;
	$form->addControl($text_control);
	$text_control=new cms_text("text","Полный текст");
	$text_control->wysiwyg=true;
	$text_control->rows=20;
	$form->addControl($text_control);
	$form->addControl(new cms_file_image("pic","Изображение"));
	$cb=new cms_combobox("photo","Фотогалерея");
	$cb->addvalue("0"," -- Не выбрано --");
	$sql='SELECT gal_id, gal_name
		FROM cms_photo_gallery
		ORDER BY gal_name
		';
	$db->open($sql);
	while(($row=$db->fetch()))
	{
		$cb->addvalue($row["gal_id"],$row["gal_name"]);
	}
	$form->addControl($cb);
	$form->addControl(new cms_button("Сохранить"));

	if($mode=="show")
	{
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$ctrl2=$form->controls['pic'];
			$ctrl2->save('pics/projects','projects');
			$ctrl2->path="../pics/projects/";
			$ctrl2->fitImage(212,88);
			clearCache("projects");
			$sql="insert into cms_project (pr_title_ru, pr_title_en, pr_date, pr_pic, pr_shorttext, pr_text, pr_gallery) values(
			'".$form->data["title_ru"]."',
			'".$form->data["title_en"]."',
			'".$form->data["date"]."',
			'".$ctrl2->value."',
			'".$form->data["shorttext"]."',
			'".$form->data["text"]."',
			'".$form->data["photo"]."'
			)";
			if($db->exec($sql))
			ShowList("Проект добавлен");
			else
			ShowList("Произошла ошибка при добавлении проекта",MB_ICON_ERROR);

		}
		else
		{
			$form->show();
		}
	}
	break;

	case "update":
	$form=new cms_dataform();
	$form->action="content.php?module=projects&action=update&mode=do";
	$form->addControl(new cms_hidden("id",$id));
	$form->title="Проекты // Редактирование";
	$form->addControl(new cms_edit("title_ru","Заголовок (ru)"));
	$form->addControl(new cms_edit("title_en","Заголовок (en)"));
	$form->addControl(new cms_datetime("date","Дата события"));
	$text_control=new cms_text("shorttext","Короткий текст (анонс)");
	$text_control->wysiwyg=false;
	$text_control->rows=20;
	$form->addControl($text_control);
	$text_control=new cms_text("text","Полный текст");
	$text_control->wysiwyg=true;
	$text_control->rows=20;
	$form->addControl($text_control);
	$form->addControl(new cms_file_image("pic","Изображение"));
	$cb=new cms_combobox("photo","Фотогалерея");
	$cb->addvalue("0"," -- Не выбрано --");
	$sql='SELECT gal_id, gal_name
		FROM cms_photo_gallery
		ORDER BY gal_name
		';
	$db->open($sql);
	while(($row=$db->fetch()))
	{
		$cb->addvalue($row["gal_id"],$row["gal_name"]);
	}
	$form->addControl($cb);
	$form->addControl(new cms_button("Сохранить"));
	
	if($mode=="show")
	{
		$sql="select * from cms_project where pr_id='$id'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["title_ru"]->value=$row["pr_title_ru"];
			$form->controls["title_en"]->value=$row["pr_title_en"];
			$form->controls["date"]->makeformvalue($row["pr_date"]);
			$form->controls["shorttext"]->value=$row["pr_shorttext"];
			$form->controls["text"]->value=$row["pr_text"];
			$form->controls["pic"]->value=$row["pr_pic"];
			$form->controls["pic"]->path="pics/projects/";
			$form->controls["photo"]->value=$row["pr_gallery"];
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sqlfile2="";
			$ctrl2=$form->controls['pic'];
			$res=$ctrl2->save('pics/projects','projects');
			$ctrl2->path="../pics/projects/";
			$ctrl2->fitImage(212,88);
			if($res==0)//ошибка
			{
				print("Не удалось загрузить рисунок");
				$form->show();
				return;
			}
			else if($res==2)//сохранено
			{
				$sql="select pr_pic from cms_project where pr_id='".$form->data["id"]."'";
				$db->open($sql);
				if(($row=$db->fetch()))
				{
					if($row["pr_pic"]!="")
					unlink('../pics/projects/'.$row["pr_pic"]);
				}
				$sqlfile2="pr_pic='".$ctrl2->value."',";
			}
			clearCache("projects");
			$sql="update cms_project set
			pr_title_ru='".$form->data["title_ru"]."',
			pr_title_en='".$form->data["title_en"]."',
			pr_date='".$form->data["date"]."',
			".$sqlfile2."
			pr_text='".$form->data["text"]."',
			pr_shorttext='".$form->data["shorttext"]."',
			pr_gallery='".$form->data["photo"]."'
			where pr_id='".$form->data["id"]."'";
			if($db->exec($sql))
			ShowList("Проект обновлен");
			else
			ShowList("Произошла ошибка при обновлении проекта",MB_ICON_ERROR);

		}
		else
		{
			$form->show();
		}
	}
	break;

	case "delete":
	$form=new cms_dataform();
	$form->action="content.php?module=projects&action=delete&mode=do";
	$form->title="Проекты // Удаление";
	$form->addControl(new cms_hidden("id",$id));
	$form->addControl(new cms_text("title","Заголовок"));
	$form->addControl(new cms_button("Удалить"));

	if($mode=="show")
	{
		$sql="select pr_title
					from cms_project
					where pr_id='$id'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["title"]->value=$row["pr_title"];
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sql="select pr_pic, pr_bigpic from cms_project where pr_id='".intval($_GET["id"])."'";
			$db->open($sql);
			if(($row=$db->fetch()))
			{
				if($row["pr_pic"]!="")
				unlink('../pics/projects/'.$row["pr_pic"]);
			}
			clearCache("projects");
			//$sql="delete from cms_project where pr_id='".$form->data["id"]."'";
			$sql="delete from cms_project where pr_id='".intval($_GET["id"])."'";
			if($db->exec($sql))
			ShowList("Проект удален");
			else
			ShowList("Произошла ошибка при удалении проекта",MB_ICON_ERROR);

		}
	}
	break;


	default:
	ShowList("");
}


function ShowList($msg=null,$msgtype=MB_ICON_OK)
{
	global $db;
	if($msg)
	{
		$mb=new CMessageBox($msg);
		$mb->Icon=$msgtype;
		$mb->Show();
	}
	
	?>
	<h1>Проекты</h1>
	<script type="text/javascript">
		$(function() {
			$( "a", ".buttonedit" ).button({
		            icons: {
		                primary: "ui-icon-pencil", text: false
		            }
			});
			
			$( "a", ".buttondel" ).button({
		            icons: {
		                primary: "ui-icon-close", text: false
		            }
			});
			$( "a", ".buttondel" ).click(function() { return confirm('Подтвердите удаление проекта!'); });
			
			$( "a", ".buttonadd" ).button({
		            icons: {
		                primary: "ui-icon-document"
		            }
			});
		});
	</script>
	<div class="buttonadd"><a href="content.php?module=projects&action=insert&mode=show">Добавить проект</a></div>
	<br>
	<?php
	$sql="select pr_id, pr_title_ru, pr_title_en, DATE_FORMAT(pr_date,'%d.%m.%Y') AS prdate from cms_project order by pr_date desc, pr_title_ru";
	$db->open($sql);
	?>
	<table width="100%">
		<tr bgcolor="#aaaaaa" style="font-weight: bold;">
			<td width="5%">Править</td>
			<td width="5%">Удалить</td>
			<td width="10%">Дата</td>
			<td width="40%">Заголовок (ru)</td>
			<td width="40%">Заголовок (en)</td>
		</tr>
		<?php
		$iterator=0;
		while(($row=$db->fetch()))
		{
			if($iterator==1)$style="background-color: #ffffee;";
			else $style="background-color: #ffffdd;";
			$iterator=1-$iterator;
			?>
			<tr style="<?php echo $style?>">
				<td><div class="buttonedit"><a href="content.php?module=projects&action=update&mode=show&id=<?php echo $row["pr_id"]?>">&nbsp;</a></div></td>
				<td><div class="buttondel"><a href="content.php?module=projects&action=delete&mode=do&id=<?php echo $row["pr_id"]?>">&nbsp;</a></div></td>
				<td><?php echo $row["prdate"]?></td>
				<td><?php echo $row["pr_title_ru"]?></td>
				<td><?php echo $row["pr_title_en"]?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}
?>
