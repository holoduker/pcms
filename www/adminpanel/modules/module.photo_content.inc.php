<?php
// PCMS Project. Version 1.0
// CMS Navigation page. Version 1.0
// Copyright (c) Roustam Shabaev. 2006-2011
// All rights reserved.

if (empty($id))$id=$_GET["id"];
if (empty($id))$id="";
$id =safevar($id);
$pid=$_POST["pid"];
if (empty($pid))$pid=$_GET["pid"];
if (empty($pid))$pid="";
$pid=safevar($pid);

function ShowList($msg=null,$msgtype=MB_ICON_OK)
{
	global $db, $id;
	if($msg)
	{
		$mb=new CMessageBox($msg);
		$mb->Icon=$msgtype;
		$mb->Show();
	}
	
	if($id=="")
	{
		$mb=new CMessageBox("Выберите галерею в списке слева, щелкнув по ее названию");
		$mb->Icon=MB_ICON_OK;
		$mb->Show();
	}
	else
	{
		?>
		<h1>Фотографии в фотогалерее</h1>
		<script type="text/javascript">
			$(function() {
				$( "a", ".buttonup" ).button({
		        	    icons: {
		                	primary: "ui-icon-arrowthick-1-n", text: false
			            }
				});
				
				$( "a", ".buttondown" ).button({
			            icons: {
			                primary: "ui-icon-arrowthick-1-s", text: false
			            }
				});

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
				$( "a", ".buttondel" ).click(function() { return confirm('Подтвердите удаление фотографии!'); });
				
				$( "a", ".buttonadd" ).button({
		        	    icons: {
		                primary: "ui-icon-document"
			            }
				});
			});
		</script>
		<div class="buttonadd"><a href="content.php?module=photo_content&action=insert&mode=show&id=<?php echo $id ?>">Добавить фото</a></div><br>
		<?php
		$sql="SELECT photo_id, photo_name, photo_smallpic, gal_name, gal_folder
	        	FROM cms_photo
	        	LEFT OUTER JOIN cms_photo_gallery ON gal_id=photo_gallery_id
        		WHERE photo_gallery_id='".$id."' ORDER BY photo_order";

		$first=true;
		$db->open($sql);
		$iterator=0;
		while(($row=$db->fetch()))
		{
			if ($first)
			{
				?>
				<h1>Галерея: <?php echo $row["gal_name"];?></h1><br><br>
				<table width="100%">
					<tr bgcolor="#aaaaaa" style="font-weight: bold;">
					<td width="5%">Править</td>
					<td width="5%">Удалить</td>
					<td width="5%">Вниз</td>
					<td width="5%">Вверх</td>
					<td width="20%">Превью</td>
					<td width="60%">Название</td>
					</tr>
				<?php
				$first=false;
			}
			if($iterator==1)$style="background-color: #ffffee;";
			else $style="background-color: #ffffdd;";
			$iterator=1-$iterator;
		      	?>
			<tr style="<?php echo $style?>">
				<td><div class="buttonedit"><a href="content.php?module=photo_content&action=update&mode=show&id=<?php echo $id?>&pid=<?php echo $row["photo_id"]?>">&nbsp;</a></div></td>
				<td><div class="buttondel"><a href="content.php?module=photo_content&action=delete&mode=do&id=<?php echo $id?>&pid=<?php echo $row["photo_id"]?>">&nbsp;</a></div></td>
				<td><div class="buttondown"><a href="content.php?module=photo_content&action=update&mode=down&id=<?php echo $id?>&pid=<?php echo $row["photo_id"]?>">&nbsp;</a></div></td>
				<td><div class="buttonup"><a href="content.php?module=photo_content&action=update&mode=up&id=<?php echo $id?>&pid=<?php echo $row["photo_id"]?>">&nbsp;</a></div></td>
				<td><img src="/pics/photo/<?php echo $row["gal_folder"]."/".$row["photo_smallpic"]?>"></td>
				<td><?php echo $row["photo_name"]?></td>
			</tr>
	      	<?php
		}
		if(!$first)echo "</table>";
	}

}

if ($action=="insert")
{
	$form        =new cms_dataform();
	$form->action="content.php?module=photo_content&action=insert&mode=do";

	$form->title="Фотогалерея // Добавление фотографии";
	$form->addControl(new cms_edit("name", "Заголовок"));
	$form->addControl(new cms_file_image("pic", "Фотография"));
	$form->addControl(new cms_hidden("id", $id));
	$form->addControl(new cms_button("Сохранить"));

	if ($mode=="show")
	{
		$form->show();
	}
	else if($mode=="do")
	{
		if ($form->parse())
		{
			$sql="SELECT gal_folder FROM cms_photo_gallery where gal_id='".$form->data["id"]."'";
			$folder="";
			
			$db->open($sql);
			if (($row=$db->fetch()))
			{
				$folder=$row["gal_folder"];
			}

			$sqlfile1="'',";
			$sqlfile2="'',";

			$ctrl=$form->controls['pic'];
			if($ctrl->save('pics/photo/'.$folder, 'pic')!=2)
				ShowList("Вы не выбрали фотографию для загрузки!",MB_ICON_ERROR);
			else
			{
				clearCache("photo");
				copy('../pics/photo/'.$folder.'/'.$ctrl->value,'../pics/photo/'.$folder.'/big'.$ctrl->value);
				chmod('../pics/photo/'.$folder.'/big'.$ctrl->value,0777);
				$ctrl->path="../pics/photo/".$folder."/";
				if(!$ctrl->createThumbnail(100,80))
				{
					ShowList("Произошла ошибка при добавлении фотографии: слишком большое разрешение. Загружайте фото с разрешением не более 10МПикс",MB_ICON_ERROR);
					return;
				}
				
				$sqlfile1="'".$ctrl->value."',";
				$ctrl->path="../pics/photo/".$folder."/big";
				$ctrl->fitImage(800,600);
				$sqlfile2="'big".$ctrl->value."',";
				$sql="INSERT INTO cms_photo (photo_smallpic, photo_bigpic, photo_name, photo_gallery_id)
			            VALUES(
					$sqlfile1
					$sqlfile2
	                  		'".$form->data["name"]."',
	       		          	'".$form->data["id"]."'
       			           )";

				$res=$db->exec($sql);
				if($res)
				{
					$newid=$db->lastid();
					$db->exec("UPDATE cms_photo SET photo_order='".$newid."' WHERE photo_id='".$newid."'");
					ShowList("Фотография успешно добавлена");
				}
				else ShowList("Произошла ошибка при добавлении фотографии",MB_ICON_ERROR);
			}
		}
	}
}
else if($action=="update")
{

	if ($mode=="up")
	{
		clearCache("photo");
		clearCache("theatre");
		$sql="SELECT photo_order
        	FROM cms_photo
        	WHERE photo_gallery_id=".$id." AND photo_id='".$pid."'";
		$db->open($sql);
		if (($row=$db->fetch()))
		{
			$thisorder=$row["photo_order"];
			$thisid=$pid;		
		}
		
		$sql="SELECT photo_order, photo_id
        	FROM cms_photo
        	WHERE photo_gallery_id=".$id." AND photo_order<".$thisorder." ORDER BY photo_order DESC LIMIT 1";
		$sql1="";$sql2="";
		$db->open($sql);
		if (($row=$db->fetch()))
		{
			$neworder=$row["photo_order"];
			$newid=$row["photo_id"];
			$sql1="UPDATE cms_photo SET photo_order='".$neworder."' WHERE photo_id='".$thisid."'";
			$sql2="UPDATE cms_photo SET photo_order='".$thisorder."' WHERE photo_id='".$newid."'";
		}
		if($sql1!="")
		{
			$db->exec($sql1);
			$db->exec($sql2);
		}
		ShowList();
		return;
	}
	elseif ($mode=="down")
	{
		clearCache("photo");
		$sql="SELECT photo_order
        	FROM cms_photo
        	WHERE photo_gallery_id=".$id." AND photo_id='".$pid."'";
		$db->open($sql);
		if (($row=$db->fetch()))
		{
			$thisorder=$row["photo_order"];
			$thisid=$pid;		
		}
		
		$sql="SELECT photo_order, photo_id
        	FROM cms_photo
        	WHERE photo_gallery_id=".$id." AND photo_order>".$thisorder." ORDER BY photo_order ASC LIMIT 1";
		$sql1="";$sql2="";
		$db->open($sql);
		if (($row=$db->fetch()))
		{
			$neworder=$row["photo_order"];
			$newid=$row["photo_id"];
			$sql1="UPDATE cms_photo SET photo_order='".$neworder."' WHERE photo_id='".$thisid."'";
			$sql2="UPDATE cms_photo SET photo_order='".$thisorder."' WHERE photo_id='".$newid."'";
		}
		if($sql1!="")
		{
			$db->exec($sql1);
			$db->exec($sql2);
		}
		ShowList();
		return;
	}

	$form        =new cms_dataform();
	$form->action="content.php?module=photo_content&action=update&mode=do";

	$form->title="Фотогалерея // Редактирование названия фотографии";
	$form->addControl(new cms_edit("name", "Название"));
	$form->addControl(new cms_file_image("pic", "Фото (только просмотр, чтобы обновить, используйте ДОБАВЛЕНИЕ фото)"));
	$form->addControl(new cms_hidden("id", $id));
	$form->addControl(new cms_hidden("pid", $pid));
	$form->addControl(new cms_button("Сохранить"));

	if ($mode=="show")
	{
		$sql="SELECT photo_name, photo_smallpic, gal_folder
                FROM cms_photo
                LEFT OUTER JOIN cms_photo_gallery ON gal_id=photo_gallery_id
                WHERE photo_id='".$pid."'";
		$folder="";
		$db->open($sql);
		if (($row=$db->fetch()))
		{
			$form->controls["name"]->value   =$row["photo_name"];
			$form->controls["pic"]->value	 =$row["photo_smallpic"];
			$form->controls["pic"]->path="pics/photo/".$row["gal_folder"]."/";
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if ($form->parse())
		{
			clearCache("photo");
			clearCache("theatre");
			$sql="UPDATE cms_photo SET
			photo_name='".$form->data["name"]."'
			WHERE photo_id='".$form->data["pid"]."'";
			if ($db->exec($sql))ShowList("Фотография успешно обновлена");
			else ShowList("Произошла ошибка при обновлении фотографии",MB_ICON_ERROR);
		}
	}
}
else if($action=="delete")
{
	$form=new cms_dataform();
	$form->action="content.php?module=photo_content&action=delete&mode=do";

	$form->title="Фотогалерея // Удаление фотографии";
	$form->addControl(new cms_edit("name", "Заголовок"));
	$form->addControl(new cms_hidden("id", $id));
	$form->addControl(new cms_hidden("pid", $pid));
	$form->addControl(new cms_button("Удалить"));

	if ($mode=="show")
	{
	}
	else if($mode=="do")
	{
		if ($form->parse())
		{
			$sql="SELECT gal_folder FROM cms_photo_gallery WHERE gal_id='".$id."'";
			$folder="";
			$db->open($sql);
			if (($row=$db->fetch()))
			{
				$folder=$row["gal_folder"];
			}
			                
			$sql="SELECT photo_smallpic, photo_bigpic FROM cms_photo WHERE photo_id='".$pid."'";
			$db->open($sql);
			if(($row=$db->fetch()))
			{
				if($row["photo_smallpic"]!="")
				unlink('../pics/photo/'.$folder.'/'.$row["photo_smallpic"]);
				if($row["photo_bigpic"]!="")
				unlink('../pics/photo/'.$folder.'/'.$row["photo_bigpic"]);
			}
			clearCache("photo");
			clearCache("theatre");
			$sql="DELETE FROM cms_photo WHERE photo_id='".$pid."'";
			if ($db->exec($sql))ShowList("Фотография успешно удалена");
			else ShowList("Произошла ошибка при удалении фотографии",MB_ICON_ERROR);

			
		}
	}
}
else
{
	ShowList();
}
?>
