<?php
class CModuleProjects extends CModule
{
	function ShowList()
	{
		global $db, $SiteTitle, $NeedPrettyPhoto, $Lang;
		$NeedPrettyPhoto=true;
		echo '<h1>'.$Lang["MainMenuProjects"].'</h1>';
		$SiteTitle=$Lang["MainMenuProjects"];
		$pr_id=0;
		?>
		<table width="100%" cellspacing="0" cellpadding="0" align="center">
		<?php
		$sql="SELECT p.pr_id, p.pr_title_".LANG." AS pr_title, p.pr_pic, g.gal_folder, f.photo_bigpic, f.photo_name 
				FROM cms_project p, cms_photo_gallery g, cms_photo f
				WHERE p.pr_gallery=g.gal_id AND g.gal_id=f.photo_gallery_id
				ORDER BY pr_date DESC, pr_id DESC, f.photo_name";
		$db->open($sql);
		while(($row=$db->fetch()))
		{
			if($pr_id!=$row["pr_id"])
			{
				$pr_id=$row["pr_id"];
				?>
				<tr>
				<td align="center" valign="top">
					<table width="880" cellpadding="0" cellspacing="10" align="left">
					<tr><td width="880" valign="middle" style="padding-bottom: 0px; text-align: center;">
					<?php if($row["pr_pic"]!=""){?>
					<div class="cProjectBlock">
					<table width="840" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td align="center" valign="middle">
					<div class="cProjectLogo">
					<table width="820" border="0">
					<tr><td valign="middle" width="280" align="center" height="140" >
					<div align="center"><a href="/pics/photo/<?php echo $row["gal_folder"]?>/<?php echo $row["photo_bigpic"]?>" rel="prettyPhoto[g<?php echo $row["pr_id"]?>]" title="<?php echo htmlspecialchars($row["photo_name"],ENT_QUOTES,"cp1251")?>"><img src="/pics/projects/<?php echo $row["pr_pic"]?>" border="0" class="cI" style="padding: 10px 0px 10px 0px;" alt="<?php echo htmlspecialchars($row["pr_title"],ENT_QUOTES,"cp1251")?>" /></a></div>
					</td><td valign="middle" style="padding-right: 10px;">
					<h3 style="font-size: 10pt; font-weight: normal; margin-top: 5px;"><?php echo sitestr($row["pr_title"])?></h3>
					</td></tr></table>
					</div>
					</td></tr></table>
					</div>
					<?php }?>
					</td></tr>
					</table>
				</td>
				</tr>
				<?php
			}
			else
			{   // добавляем остальные картинки для галереи
				?><tr><td><div style="display: none;"><a href="/pics/photo/<?php echo $row["gal_folder"]?>/<?php echo $row["photo_bigpic"]?>" rel="prettyPhoto[g<?php echo $row["pr_id"]?>]" title="<?php echo htmlspecialchars($row["photo_name"],ENT_QUOTES,"cp1251")?>"><img alt="<?php echo htmlspecialchars($row["pr_title"],ENT_QUOTES,"cp1251")?>" src="/i/spacer.gif" width="1" height="1" border="0"/></a></div></td></tr><?php
			}
		}
		?>
		</table>
		<script type="text/javascript">
		
		$(function() {
		
			$('.cProjectLogo').hover(function() {
		        $(this).stop(false,true).animate({'width':'+=8px', 'height':'+=6px', 'top':'0px', 'left':'0px'}, {duration:100}).addClass("cBigShadow2");
		        $(this).find(".cI").stop(false,true).animate({'width':'+=12px', 'height':'+=6px', 'top':'-=2px', 'left':'-=2px'}, {duration:100});
		    },
		    function() {
		 
		        $(this).stop(false,true).animate({'width':'-=8px', 'height':'-=6px', 'top':'4px', 'left':'4px'}, {duration:50}).removeClass("cBigShadow2");    
		        $(this).find(".cI").stop(false,true).animate({'width':'-=12px', 'height':'-=6px', 'top':'+=2px', 'left':'+=2px'}, {duration:50});
		    });

		});
		
	    $("a[rel^='prettyPhoto']").prettyPhoto({
			deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
			social_tools:false
		    });
	    
		</script>

		<?php
	}
	
	function DoListAction()
	{
	}
	
	function ShowShort()
	{
		
	}
	
	function DoShortAction()
	{
		
	}
	
	function ShowDetail()
	{
	}
	
	function DoDetailAction()
	{
		
	}
	
	function ShowPhotoGallery($gid)
	{
	}
	
}?>