<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

switch ($action)
{
	case "insert":
	$form=new cms_dataform();
	$form->action="content.php?module=admins&action=insert&mode=do";

	$form->title="�������������� // ����������";
	$form->addControl(new cms_edit("name","���"));
	$form->addControl(new cms_edit("login","�����"));
	$form->addControl(new cms_password("password","������"));
	$form->addControl(new cms_button("���������"));

	if($mode=="show")
	{
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sql="insert into cms_admin (admin_name, admin_login, admin_password) values(
			'".$form->data["name"]."',
			'".$form->data["login"]."',
			'".sha1($form->data["password"])."')";
			if($db->exec($sql))
			ShowList("������������� ��������");
			else
			ShowList("��������� ������ ��� ���������� ��������������",MB_ICON_ERROR);

		}
		else
		{
			$form->show();
		}
	}
	break;

	case "update":
	$form=new cms_dataform();
	$form->action="content.php?module=admins&action=update&mode=do";
	$form->addControl(new cms_hidden("id",$id));
	$form->title="�������������� // ��������������";
	$form->addControl(new cms_edit("name","���"));
	$form->addControl(new cms_edit("login","�����"));
	$form->addControl(new cms_password("password","������ (��������� ������ ��� ���������)"));
	$form->addControl(new cms_button("���������"));

	if($mode=="show")
	{
		$sql="select * from cms_admin where admin_id='$id'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["name"]->value=$row["admin_name"];
			$form->controls["login"]->value=$row["admin_login"];
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sqlpass="";
			if($form->data["password"]!="")
			$sqlpass="admin_password='".sha1($form->data["password"])."',";

			$sql="update cms_admin set
			".$sqlpass."
			admin_name='".$form->data["name"]."',
			admin_login='".$form->data["login"]."'
			where admin_id='".$form->data["id"]."'";
			if($db->exec($sql))
			ShowList("������ ���������");
			else
			ShowList("��������� ������ ��� ���������� ������",MB_ICON_ERROR);

		}
		else
		{
			$form->show();
		}
	}
	break;

	case "delete":
	$form=new cms_dataform();
	$form->action="content.php?module=admins&action=delete&mode=do";
	$form->title="�������������� // ��������";
	$form->addControl(new cms_hidden("id",$id));
	$form->addControl(new cms_text("name","���"));
	$form->addControl(new cms_button("�������"));

	if($mode=="show")
	{
		$sql="select admin_name
					from cms_admin
					where admin_id='$id'";
		$db->open($sql);
		if(($row=$db->fetch()))
		{
			$form->controls["name"]->value=$row["admin_name"];
		}
		$form->show();
	}
	else if($mode=="do")
	{
		if($form->parse())
		{
			$sql="SELECT COUNT(*) AS cnt FROM cms_admin";
			$db->open($sql);
			$row=$db->fetch();
			if($row["cnt"]<=1)
			{
				ShowList("������ ������� ������������� �������������� �������!",MB_ICON_ERROR);
			}
			else
			{
				//$sql="delete from cms_admin where admin_id='".$form->data["id"]."'";
				$sql="delete from cms_admin where admin_id='".intval($_GET["id"])."'";
				if($db->exec($sql))
				ShowList("������������� ������");
				else
				ShowList("��������� ������ ��� �������� ��������������",MB_ICON_ERROR);
			}

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
	<h1>��������������</h1>
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
			$( "a", ".buttondel" ).click(function() { return confirm('����������� �������� ��������������!'); });
			
			$( "a", ".buttonadd" ).button({
		            icons: {
		                primary: "ui-icon-document"
		            }
			});
		});
	</script>
	<div class="buttonadd"><a href="content.php?module=admins&action=insert&mode=show">�������� ��������������</a></div>
	<br>
	<?php
	$sql="select * from cms_admin order by admin_name";
	$db->open($sql);
	?>
	<table width="100%">
		<tr bgcolor="#aaaaaa" style="font-weight: bold;">
			<td width="5%">�������</td>
			<td width="5%">�������</td>
			<td width="45%">���</td>
			<td width="45%">�����</td>
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
				<td><div class="buttonedit"><a href="content.php?module=admins&action=update&mode=show&id=<?php echo $row["admin_id"]?>">&nbsp;</a></div></td>
				<td><div class="buttondel"><a href="content.php?module=admins&action=delete&mode=do&id=<?php echo $row["admin_id"]?>">&nbsp;</a></div></td>
				<td><?php echo $row["admin_name"]?></td>
				<td><?php echo $row["admin_login"]?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}
?>
