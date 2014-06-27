<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/

class control {
	var $name;
	var $id;
	var $value;
	var $size;
	var $width;
	var $height;
	var $caption;
	var $style;

	function control()
	{
		$this->name="control";
		$this->id="";
		$this->value="";
		$this->caption="";
		$this->size="";
		$this->width="";
		$this->height="";
		$this->style="";
	}

	function show()
	{
		print "control";
	}

	function validate($value)
	{
		return true;
		//метод должен проверять массив constraints объектов типа constraint на предмет валидности ввода
		//и в случае успеха возвращать true
	}

	/// Создает значение для передачи в форму
	function makeformvalue($value)
	{
		$this->value=stripslashes($value);
	}

	/// Создает значение для передачи в SQL
	function makesqlvalue($value)
	{
		return $value;
	}
}

/////////////////////////////

class cms_label extends control {

	var $dummy=0;

	function cms_label($caption)
	{
		control::control();
		$this->caption=$caption;
		$this->width="100%";
	}

	function show()
	{
		?>
		<tr>
			<td colspan="2"><h2><?php echo $this->caption?></h2></td>
		</tr>
		<?php
	}

}

////////////////////////
class cms_edit extends control {

	var $dummy=0;

	function cms_edit($id,$caption,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%"><input type="text" class="text ui-widget-content ui-corner-all" id="<?php echo $this->id?>" name="<?php echo $this->name?>" size="<?php echo $this->size?>" value="<?php echo $this->value?>" style="<?php echo $this->style?>"></td>
		</tr>
		<?php
	}

}

////////////////////////
class cms_password extends control {

	var $dummy=0;

	function cms_password($id,$caption,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%"><input type="password" class="text ui-widget-content ui-corner-all" id="<?php echo $this->id?>" name="<?php echo $this->name?>" size="<?php echo $this->size?>" value="<?php echo $this->value?>" style="<?php echo $this->style?>"></td>
		</tr>
		<?php
	}

}

////////////////////////
class cms_checkbox extends control {

	var $dummy=0;

	function cms_checkbox($id,$caption,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%" align="left"><input type="checkbox" class="text ui-widget-content ui-corner-all" id="<?php echo $this->id?>" name="<?php echo $this->name?>" <?php echo $this->value=="1"?"checked":""?> style="width: 20px;"></td>
		</tr>
		<?php
	}

	// override
	/// Создает значение для передачи в SQL
	function makesqlvalue($value)
	{
		return ($value=="on"?"1":"0");
	}
}

////////////////////////
class cms_combobox extends control {

	var $dummy=0;
	var $values;
	var $values_count=0;

	function cms_combobox($id,$caption)
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
		$this->values=array();
		$this->values_count=0;
	}

	function show()
	{
		?>
		<tr>
			<td align="right" style="padding-bottom: 10px;"><?php echo $this->caption?></td>
			<td width="100%" style="padding-bottom: 10px;">
				<select id="<?php echo $this->id?>" name="<?php echo $this->name?>" class="text ui-widget-content ui-corner-all">
					<?php
					foreach ($this->values as $val)
					{
						if($val["value"]==$this->value)
						{
							?><option value="<?php echo $val["value"]?>" selected><?php echo $val["title"]?></option><?php
						}
						else
						{
							?><option value="<?php echo $val["value"]?>"><?php echo $val["title"]?></option><?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}

	function addvalue($value,$title)
	{
		$this->values[$this->values_count]["value"]=$value;
		$this->values[$this->values_count]["title"]=$title;
		$this->values_count++;
	}

}

////////////////////////
class cms_multibox extends control {

	var $dummy=0;
	var $values;
	var $values_count=0;
	var $value=array();

	function cms_multibox($id,$caption)
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="10";
		$this->values=array();
		$this->value=array();
		$this->values_count=0;
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%">
				<select id="<?php echo $this->id?>[]" name="<?php echo $this->name?>[]" multiple size="<?php echo $this->size?>" class="text ui-widget-content ui-corner-all">
					<?php
					foreach ($this->values as $val)
					{
						if(in_array($val["value"],$this->value))
						{
							?><option value="<?php echo $val["value"]?>" selected><?php echo $val["title"]?></option><?php
						}
						else
						{
							?><option value="<?php echo $val["value"]?>"><?php echo $val["title"]?></option><?php
						}
					}
					?>
				</select>
			</td>
		</tr>
		<?php
	}

	function addvalue($value,$title)
	{
		$this->values[$this->values_count]["value"]=$value;
		$this->values[$this->values_count]["title"]=$title;
		$this->values_count++;
	}

	// override
	/// Создает значение для передачи в форму
	function makeformvalue($value)
	{
		foreach ($value as $key=>$val)
		{
			$this->value[$key]=stripslashes($val[$key]);
		}
	}

	// override
	/// Создает значение для передачи в SQL
	//function makesqlvalue($value)
	//{
	//	return $value;
	//}

}

////////////////////////
class cms_hidden extends control {

	var $dummy=0;

	function cms_hidden($id,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
	}

	function show()
	{
		?>
		<input type="hidden" id="<?php echo $this->id?>" name="<?php echo $this->name?>" value="<?php echo $this->value?>">
		<?php
	}

}

////////////////////////
class cms_file extends control {

	var $dummy=0;

	function cms_file($id,$caption,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%"><input type="file" class="text ui-widget-content ui-corner-all" id="<?php echo $this->id?>" name="<?php echo $this->name?>" size="<?php echo $this->size?>" value="<?php echo $this->value?>"><?php $this->showfile(); ?></td>
		</tr>
		<?php
	}

	function save($folder,$prefix)
	{
		//возвращает 0-ошибка сохранения, 1-нет файла,2-сохранено
		if($_FILES[$this->id]['name'])
		{
			preg_match ("/\.(\w+)$/i",$_FILES[$this->id]['name'],$ext);
			$newname=$prefix.'-'.date("dmYHis").'.'.$ext[1];
			$this->value=$newname;
			if(move_uploaded_file($_FILES[$this->id]['tmp_name'],'../'.$folder.'/'.$newname))
			return 2;
			else
			return 0;
		}
		else
		{
			$this->value="";
			return 1;
		}
	}


	function showfile()
	{
		if($this->value!="")
		{
			echo "<br>Прикреплен файл: [".$this->value."]<br>";
		}
	}

}

////////////////////////
class cms_file_image extends cms_file {

	var $dummy=0;
	var $path="";
	var $JPEGQuality=90;

	function showfile()
	{
		if($this->value!="")
		{
			echo "<img src=\"/".$this->path.$this->value."\" border=\"0\" align=\"left\"><br>";
		}
	}

	function createThumbnail($width,$height)
	{
		// получаем исходные размеры
		list($src_width, $src_height, $src_type) = getimagesize($this->path.$this->value);

		if($src_width*$src_height>15000000)return false;

		//загружаем рисунок
		switch($src_type)
		{
			case IMAGETYPE_GIF:$im_src=@imagecreatefromgif($this->path.$this->value);break;
			case IMAGETYPE_JPEG:$im_src=@imagecreatefromjpeg($this->path.$this->value);break;
			case IMAGETYPE_PNG:$im_src=@imagecreatefrompng($this->path.$this->value);break;
			default: return false;
		}

		//создаем объект для нового рисунка-thumbnail
		$im_dst2=imagecreatetruecolor($width, $height);

		if($src_width>$src_height) //лежачая картинка
		{
			//определяем новую ширину пропорционально высоте
			$width_temp = (int) (($height / $src_height) * $src_width);

	            	// проверяем, что width_temp не стало меньше width,
        	    	// потому что в этом случае нужно взять стратегию для стоячей картинки,
			if($width_temp<$width)
			{
				//определяем новую высоту пропорционально ширине
				$height_temp = (int) (($width / $src_width) * $src_height);
				//создаем объект для временного рисунка-thumbnail
				$im_dst_temp=imagecreatetruecolor($width, $height_temp);
				// уменьшаем до нужной ibhbys
				imageCopyResampled($im_dst_temp,$im_src,0,0,0,0, $width, $height_temp, $src_width, $src_height);
				//обрезаем верх и низ
				imageCopy($im_dst2,$im_dst_temp,0,0,0, 0, $width, $height_temp);
				imageDestroy($im_dst_temp);
			}
			else
			{
				//создаем объект для временного рисунка-thumbnail
				$im_dst_temp=imagecreatetruecolor($width_temp, $height);
				// уменьшаем до нужной высоты
				imageCopyResampled($im_dst_temp, $im_src, 0,0,0,0, $width_temp, $height, $src_width, $src_height);
				//обрезаем бока
				imageCopy($im_dst2,$im_dst_temp,0,0,(int)(($width_temp-$width)/2),0,$width_temp,$height);
				imageDestroy($im_dst_temp);
			}
		}
		else
		{
			//определяем новую высоту пропорционально ширине
			$height_temp = (int) (($width / $src_width) * $src_height);
			
	            	// проверяем, что height_temp не стало меньше height,
        	    	// потому что в этом случае нужно взять стратегию для лежачей картинки,
			if($height_temp<$height)
			{
				//определяем новую ширину пропорционально высоте
				$width_temp = (int) (($height / $src_height) * $src_width);
				//создаем объект для временного рисунка-thumbnail
				$im_dst_temp=imagecreatetruecolor($width_temp, $height);
				// уменьшаем до нужной высоты
				imageCopyResampled($im_dst_temp, $im_src, 0,0,0,0, $width_temp, $height, $src_width, $src_height);
				//обрезаем бока
				imageCopy($im_dst2,$im_dst_temp,0,0,(int)(($width_temp-$width)/2),0,$width_temp,$height);
				imageDestroy($im_dst_temp);
			}
			else
			{
				//создаем объект для временного рисунка-thumbnail
				$im_dst_temp=imagecreatetruecolor($width, $height_temp);
				// уменьшаем до нужной ibhbys
				imageCopyResampled($im_dst_temp,$im_src,0,0,0,0, $width, $height_temp, $src_width, $src_height);
				//обрезаем верх и низ
				imageCopy($im_dst2,$im_dst_temp,0,0,0, 0, $width, $height_temp);
				imageDestroy($im_dst_temp);
			}
		}

		//сохраняем картинку
		imageJPEG($im_dst2, $this->path.$this->value,$this->JPEGQuality);

		//очистка
		imageDestroy($im_dst2);
		imageDestroy($im_src);

		return true;
	}
	
	function fitImageToWidth($width)
	{
		// получаем исходные размеры
		list($src_width, $src_height, $src_type) = getimagesize($this->path.$this->value);

		if($src_width*$src_height>15000000)return false;
		
		//определяем новую высоту пропорционально ширине
		$height = (int) (($width / $src_width) * $src_height);

		//загружаем рисунок
		switch($src_type)
		{
			case IMAGETYPE_GIF:$im_src=@imagecreatefromgif($this->path.$this->value);break;
			case IMAGETYPE_JPEG:$im_src=@imagecreatefromjpeg($this->path.$this->value);break;
			case IMAGETYPE_PNG:$im_src=@imagecreatefrompng($this->path.$this->value);break;
			default: return false;
		}
		
		//создаем объект для нового рисунка
		$im_dst=imagecreatetruecolor($width, $height);

		// собственно уменьшаем
		imageCopyResampled($im_dst,$im_src, 0,0,0,0, $width, $height, $src_width, $src_height);

		// это опция - не увеличивать маленькую картинку (по ширине)
		if($src_width>$width)
		{
			//сохраняем картинку
			imageJPEG($im_dst, $this->path.$this->value,$this->JPEGQuality);
		}
		else
		{
			//сохраняем исходную картинку
			imageJPEG($im_src, $this->path.$this->value,$this->JPEGQuality);
		}

		//очистка
		imageDestroy($im_src);
		imageDestroy($im_dst);

		return true;
	}

	function fitImageToHeight($height)
	{
		// получаем исходные размеры
		list($src_width, $src_height, $src_type) = getimagesize($this->path.$this->value);
		
		if($src_width*$src_height>15000000)return false;

		//определяем новую ширину пропорционально высоте
		$width = (int) (($height / $src_height) * $src_width);

		//загружаем рисунок
		switch($src_type)
		{
			case IMAGETYPE_GIF:$im_src=@imagecreatefromgif($this->path.$this->value);break;
			case IMAGETYPE_JPEG:$im_src=@imagecreatefromjpeg($this->path.$this->value);break;
			case IMAGETYPE_PNG:$im_src=@imagecreatefrompng($this->path.$this->value);break;
			default: return false;
		}
		
					
		//создаем объект для нового рисунка
		$im_dst=imagecreatetruecolor($width, $height);

		// собственно уменьшаем
		imageCopyResampled($im_dst,$im_src, 0,0,0,0, $width, $height, $src_width, $src_height);

		// это опция - не увеличивать маленькую картинку (по высоте)
		if($src_height>$height)
		{
			//сохраняем картинку
			imageJPEG($im_dst, $this->path.$this->value,$this->JPEGQuality);
		}
		else
		{
			//сохраняем исходную картинку
			imageJPEG($im_src, $this->path.$this->value,$this->JPEGQuality);
		}

		//очистка
		imageDestroy($im_src);
		imageDestroy($im_dst);

		return true;
	}

	function fitImage($width, $height)
	{
		// получаем исходные размеры
		list($src_width, $src_height) = getimagesize($this->path.$this->value);
		if($src_width*$src_height>15000000)return false;

		if($src_width>$src_height)return $this->fitImageToWidth($width);
		else return $this->fitImageToHeight($height);
	}

}

////////////////////////
class cms_text extends control {

	var $rows;
	var $cols;
	var $wysiwyg;

	function cms_text($id,$caption,$value="")
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=$value;
		$this->width="100%";
		$this->caption=$caption;
		$this->size="50";
		$this->rows=10;
		$this->cols=50;
		$this->wysiwyg=false;
	}

	function show()
	{
		?>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td width="100%"><textarea id="<?php echo $this->id?>" name="<?php echo $this->name?>" cols="<?php echo $this->cols?>" rows="<?php echo $this->rows?>" <?php echo $this->wysiwyg?"class=clsRichFormControl":""?>><?php echo $this->value?></textarea></td>
		</tr>
		<?php
	}

}

////////////////////////
class cms_button extends control {

	var $type;
	function cms_button($caption,$value="",$id="button1",$type="submit")
	{
		// for this control caption=value
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->caption=$caption;
		$this->value=stripslashes($caption);
		$this->width="100%";
		$this->type=$type;
	}

	function show()
	{
		?>
		<script>
			$(function() {
			$( ".button_<?php echo $this->id ?> input" ).button();
		});
		</script>
		<tr>
			<td align="right"></td>
			<td width="100%"><div class="button_<?php echo $this->id ?>"><input type="<?php echo $this->type?>" value="<?php echo $this->caption?>" id="<?php echo $this->id?>" name="<?php echo $this->name?>" style="width: 150px;"></div></td>
		</tr>
		<?php
	}

}
////////////////////////


class cms_link_button extends control {

	var $type;
	var $url;
	var $target;
	function cms_link_button($caption,$value="",$id="buttonlink1",$url="",$target="")
	{
		// for this control caption=value
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->caption=$caption;
		$this->value=stripslashes($caption);
		$this->width="100%";
		$this->url=$url;
		$this->target=$target;
	}

	function show()
	{
		?>
		<tr>
			<td align="right"></td>
			<td width="100%">
				<script type="text/javascript">
					$(function() {
						$( "a", ".cls_<?php echo $this->id; ?>" ).button();
		        	
						$( "a", ".cls_<?php echo $this->id; ?>" ).button();
					});
				</script>
				<div class="cls_<?php echo $this->id; ?>"><a href="<?php echo $this->url; ?>" target="<?php echo $this->target; ?>"><?php echo $this->caption; ?></a></div>
			</td>
		</tr>
		<?php
	}

}
////////////////////////


class node {
	var $caption;
	var $href;
	var $target;
	var $items;

	function node($caption,$href,$target="content")
	{
		$this->caption=$caption;
		$this->items=array();
		$this->href=$href;
		$this->target=$target;
	}

	function add($node)
	{
		$this->items[]=$node;
	}

	function show()
	{
		print "<a href=\"".$this->href."\" target=\"".$this->target."\">".$this->caption."</a><br>";
		print "<div style=\"position: relative; left: 10px; height: 1px;\">";
		//now list all children
		foreach($this->items as $node)
		{
			$node->show();
		}
		print "</div>";
	}
}


////////////////////////
class cms_datetime extends control {

	var $dummy=0;
	var $day;
	var $month;
	var $year;

	function cms_datetime($id,$caption)
	{
		control::control();
		$this->name=$id;
		$this->id=$id;
		$this->value=date("d.m.Y");
		$this->size="";
		$this->width="100%";
		$this->caption=$caption;
		$this->day=date("j");
		$this->month=date("n");
		$this->year=date("Y");
	}

	function show()
	{
		?>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/i18n/jquery.ui.datepicker-ru.js"></script>
		<script>
			$(function() {
			$( "#<?php echo $this->id; ?>" ).datepicker({			
				showOn: "both",
				buttonImage: "/i/calendar.gif",
				buttonImageOnly: true
			});
		});
		</script>
		<tr>
			<td align="right"><?php echo $this->caption?></td>
			<td><input style="width: 200px;" type="text" class="text ui-widget-content ui-corner-all" id="<?php echo $this->id; ?>" name="<?php echo $this->name; ?>" value="<?php echo $this->value; ?>">
			</td>
		</tr>
		<?php
	}

	function makeformvalue($value)
	{
		$date=date_parse_from_format("Y-m-d H:i:s",$value);
		$this->value=sprintf("%02d.%02d.%04d",$date["day"],$date["month"],$date["year"]);

		//$this->day=safevar($_POST[$this->id."_day"]);
		//$this->month=safevar($_POST[$this->id."_month"]);
		//$this->year=safevar($_POST[$this->id."_year"]);
	}

	//
	function makesqlvalue($value) 
	{                                          
		//return $this->year."-".$this->month."-".$this->day;
		$date=date_parse_from_format("d.m.Y",$value);
		return $date["year"]."-".$date["month"]."-".$date["day"];
	}

}

////////////////////////
?>
