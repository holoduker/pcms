<?php
// PCMS Project. Version 1.0
// CMS Navigation page. Version 1.0
// Copyright (c) Roustam Shabaev. 2006
// All rights reserved.

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
	<h1>Фотогалереи</h1>
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
			$( "a", ".buttondel" ).click(function() { return confirm('Подтвердите удаление выбранной галереи и всех фотографий из нее!'); });
			
			$( "a", ".buttonadd" ).button({
		            icons: {
		                primary: "ui-icon-document"
		            }
			});
		});
	</script>
	<div class="buttonadd"><a href="content.php?module=photo_menu&action=insert&mode=show">Создать новую галерею</a></div><br>
	<?php
	$sql="SELECT gal_id, gal_name, gal_order, IF(gal_showmain,'+','-') AS showmain FROM cms_photo_gallery ORDER BY gal_order";
  	echo "<table border=0 cellspacing=2 cellpadding=5 bgcolor=#ffffff>";
	$db->open($sql);
	$db->open($sql);
	?>
	<table width="100%">
		<tr bgcolor="#aaaaaa" style="font-weight: bold;">
			<td width="5%">Править</td>
			<td width="5%">Удалить</td>
			<td width="85%">Название</td>
			<td width="5%">Показывать в общем списке</td>
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
				<td><div class="buttonedit"><a href="content.php?module=photo_menu&action=update&id=<?php echo $row["gal_id"];?>">&nbsp;</a></div></td>
				<td><div class="buttondel"><a href="content.php?module=photo_menu&action=delete&mode=do&id=<?php echo $row["gal_id"];?>">&nbsp;</a></div></td>
				<td><a href="content.php?module=photo_content&action=list&id=<?php echo $row["gal_id"];?>" target="photo_content"><?php echo $row["gal_name"]?></a></td>
				<td><?php echo $row["showmain"]?></td>
			</tr>
			<?php
		}
	echo "</table>";
}

if($action=="insert")
{
	$form=new cms_dataform();
	$form->action="content.php?module=photo_menu&action=insert&mode=do";

	$form->title="Фотогалерея // Добавление";
	$form->addControl(new cms_edit("name","Название галереи"));
	$form->addControl(new cms_checkbox("showmain","Показывать в общем списке?"));
	$form->addControl(new cms_edit("order","Порядок"));
	$form->addControl(new cms_button("Сохранить"));

	if($mode=="show")
	{
		$form->show();

	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$folder=substr(urlTranslit($form->data["name"]),0,100);
			mkdir("../pics/photo/".$folder);
			chmod("../pics/photo/".$folder,0777);
			clearCache("photo");
			$sql="INSERT INTO cms_photo_gallery (gal_name, gal_folder, gal_order, gal_showmain) VALUES('".$form->data["name"]."', '".$folder."', '".$form->data["order"]."', '".$form->data["showmain"]."')";
			if($db->exec($sql))
			ShowList("Галерея успешно добавлена");
			else
			ShowList("Произошла ошибка при добавлении",MB_ICON_ERROR);
		}

	}
}
else if($action=="update")
{
	$form=new cms_dataform();
	$form->action="content.php?module=photo_menu&action=update&mode=do";

	$form->title="Фотогалерея // Редактирование";
	$form->addControl(new cms_hidden("id",safevar($_GET["id"])));
	$form->addControl(new cms_edit("name","Название галереи"));
	$form->addControl(new cms_checkbox("showmain","Показывать в общем списке?"));
	$form->addControl(new cms_edit("order","Порядок"));
	$form->addControl(new cms_button("Сохранить"));

	if($mode=="show")
	{
    $sql="SELECT * FROM cms_photo_gallery WHERE gal_id='".safevar($_GET["id"])."'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["name"]->value=$row["gal_name"];
			$form->controls["order"]->value=$row["gal_order"];
			$form->controls["showmain"]->value=$row["gal_showmain"];
		}
		$form->show();

	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			clearCache("photo");
			$sql="UPDATE cms_photo_gallery SET
				gal_name='".$form->data["name"]."', 
				gal_order='".$form->data["order"]."',
				gal_showmain='".$form->data["showmain"]."'
				WHERE gal_id='".$form->data["id"]."'";
			if($db->exec($sql))
			ShowList("Галерея успешно обновлена");
			else
			ShowList("Произошла ошибка при обновлении",MB_ICON_ERROR);
		}

	}
}
else if($action=="delete")
{
	$form=new cms_dataform();
	$form->action="content.php?module=photo_menu&action=delete&mode=do";

	$form->title="Фотогалерея // Удаление";
	$form->addControl(new cms_edit("name","Название галереи"));
	$form->addControl(new cms_hidden("id",safevar($_GET["id"])));
	$form->addControl(new cms_button("Удалить"));

	if($mode=="show")
	{
		$sql="SELECT gal_name FROM cms_photo_gallery WHERE gal_id='".safevar($_GET["id"])."'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["name"]->value=$row["gal_name"];
		}
		$form->show();

	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			clearCache("photo");
      			// Удаляем фотки из галереи
			$sql="SELECT p.photo_smallpic, p.photo_bigpic, g.gal_folder
				FROM cms_photo p
				LEFT OUTER JOIN cms_photo_gallery g ON p.photo_gallery_id=g.gal_id
				WHERE g.gal_id='".safevar($_GET["id"])."'";
			$db->open($sql);
			while(($row=$db->fetch()))
			{
				$folder=$row["gal_folder"];
				if($row["photo_smallpic"]!="")unlink("../pics/photo/".$row["gal_folder"]."/".$row["photo_smallpic"]);
				if($row["photo_bigpic"]!="")unlink("../pics/photo/".$row["gal_folder"]."/".$row["photo_bigpic"]);
			}
			// ниже нужно, если мы удаляем галерею без фоток (тогда запрос выше пустой)
			if($folder=="")
			{
				$sql="SELECT gal_folder FROM cms_photo_gallery WHERE gal_id='".safevar($_GET["id"])."'";
				$db->open($sql);
				if(($row=$db->fetch()))
				{
					$folder=$row["gal_folder"];
				}       
			}
			rmdir("../pics/photo/".$folder);

			$sql="DELETE FROM cms_photo_gallery WHERE gal_id='".safevar($_GET["id"])."'";
			if($db->exec($sql))
			{
				$sql="DELETE FROM cms_photo WHERE photo_gallery_id='".safevar($_GET["id"])."'";
				$db->exec($sql);

				ShowList("Галерея вместе со всеми фотографиями успешно удалена");
			}
			else
			ShowList("Произошла ошибка при удалении, однако файлы уже могут быть удалены",MB_ICON_ERROR);
		}

	}
}
else
{
	ShowList();
}
?>
