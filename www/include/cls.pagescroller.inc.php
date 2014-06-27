<?php
/**
* pCMS 2 beta Content Management System
* (c) Rustam Shabaev. 2006-2012
* http://www.pcms.ru
* Support: support@pcms.ru
*/

/**
* @desc Класс, реализующий механизм постраничной прокрутки
*/
class PageScroller {

  var $Page=1;
  var $SqlPage=0;
  var $PageCount=0;
  var $PubPerPage=20;// это сколько документов на странице

  //presets
  var $MsgPagingPrev		= '&#8592предыдущая'; //'&#171';
  var $MsgPagingNext		= 'следующая&#8594'; //'&#187';
  var $PAGE_WINDOW_SIZE 	= 5;// это сколько страниц показывать



  /**
   * @desc выводит строку адреса с соответствующим номером страницы (вид: /news/5)
   * Доступно для страниц вида /page_name_1[/page_name_2..N][/page_no/] 
   * @param int $PageNo - новый номер страницы для перехода
   */
	function ScrollNavigateModRewrite($PageNo)
  {
  	$request=$_SERVER["REQUEST_URI"];
  	$get=explode('/',$request);
  	$retval="http://".$_SERVER["HTTP_HOST"]."/";
  	for($i=1;$i<count($get);$i++)
  	{
  		if(!is_numeric($get[$i]) && !empty($get[$i]))
  			$retval.=$get[$i]."/";
  	}
  	$retval.=$PageNo;
  	return $retval;
  }

  /**
   * @desc выводит строку адреса с соответствующим номером страницы (вид: index.php?module=new&page=2)
   */
  function ScrollNavigate($PageNo)
  {
    $retval=$_SERVER['PHP_SELF']."?";
    foreach ($_GET as $key => $val)
	  {
	    if($key!='page')
		    $retval.="$key=$val&";
	  }
    return $retval."page=".$PageNo;
  }

/**
* @desc выводит область постраничного листания
*
*/
  function ScrollShowOld()
  {
    if($this->PageCount<= 1) return;  // no need to display page browsing menu
	
    $PageWindowNo = (int)(($this->Page-1)/$this->PAGE_WINDOW_SIZE);
?>

<p>
<div class="clsScrollerHeaderText" style="margin-bottom: 10px; margin-top: 40px;">Страницы</div>
<?php
    // [prev]
    if($this->Page>1)
	    {
        // show link to the prev page
	      ?><span class="clsScroller" style="padding-left: 0px;"><a href="<?php echo $this->ScrollNavigateModRewrite($this->Page-1)?>" class="clsScrollerText"><?php echo $this->MsgPagingPrev?></a></span><?php
	    }
?>
<!-- PREVIOUS 10: span class="clsScroller"><a href="" class="clsScrollerText">..</a></span--><?php
    // page navigation limited by page window
    $last_page = $PageWindowNo * $this->PAGE_WINDOW_SIZE + $this->PAGE_WINDOW_SIZE;
    if($last_page>$this->PageCount) $last_page = $this->PageCount;
    // from first page in the page window to the last page in the page window
    // For i=1 to PageCount
    for ($i=$PageWindowNo * $this->PAGE_WINDOW_SIZE + 1;$i<=$last_page;$i++)
	  {
       if($i==$this->Page)
       {
          // disable link to the page (current page)
          ?><span class="clsScrollerCurrent"><?php echo $i?></span><?php
	     }
       else
	     {
          // show link to the page
          ?><span class="clsScroller"><a href="<?php echo $this->ScrollNavigateModRewrite($i)?>" class="clsScrollerText"><?php echo $i?></a></span><?php
	     }
	  }
?>
<!-- NEXT 10: span class="clsScroller"><a href="" class="clsScrollerText">..</a></span--><?php
    // [next]
    if($this->Page<$this->PageCount)
	  {
      // show link to the next page
	    ?><span class="clsScroller" style="padding-right: 0px;"><a HREF="<?php echo $this->ScrollNavigateNodRewrite($this->Page+1)?>" class="clsScrollerText"><?php echo $this->MsgPagingNext?></a></span><?php
	  }
  } //Scroll_Show()
  
  
/**
* @desc выводит область постраничного листания
*
*/
  function ScrollShow()
  {
    if($this->PageCount<= 1) return;  // no need to display page browsing menu
	
    $PageWindowNo = (int)(($this->Page-1)/$this->PAGE_WINDOW_SIZE);
?>

<div class="clsScrollerHeaderText">Страницы</div>
<?php
	$HalfPWS=round($this->PAGE_WINDOW_SIZE/2);// половина количества ссылок на странице

    // [prev] - предыдущая страница (-1)
    // todo: -10
    if($this->Page>1)
	    {
        // show link to the prev page
	      ?><span class="clsScroller" style="padding-left: 0px;"><a href="<?php echo $this->ScrollNavigateModRewrite($this->Page-1)?>" class="clsScrollerText"><?php echo $this->MsgPagingPrev?></a></span><?php
	    }
	    
    $FirstPage=$this->Page-$HalfPWS;
    if($FirstPage<1)$FirstPage=1;
    $LastPage=$FirstPage+$this->PAGE_WINDOW_SIZE-1;
    if($LastPage>$this->PageCount)$LastPage=$this->PageCount;
    if($LastPage-$FirstPage<$this->PAGE_WINDOW_SIZE)
    {
    	$FirstPage=$LastPage-$this->PAGE_WINDOW_SIZE+1;
	    if($FirstPage<1)$FirstPage=1;
    }
    
    // [prev 10]
    if($FirstPage>1)
	  {
      // show link to the prev page
      ?><span class="clsScroller"><a href="<?php echo $this->ScrollNavigateModRewrite($FirstPage-1)?>" class="clsScrollerText">..</a></span><?php
	  }
	    
    for ($i=$FirstPage;$i<=$LastPage;$i++)
	  {
       if($i==$this->Page)
       {
          // disable link to the page (current page)
          ?><span class="clsScrollerCurrent"><?php echo $i?></span><?php
	     }
       else
	     {
          // show link to the page
          ?><span class="clsScroller"><a href="<?php echo $this->ScrollNavigateModRewrite($i)?>" class="clsScrollerText"><?php echo $i?></a></span><?php
	     }
	  }

    // [next 10]
	  if($LastPage<$this->PageCount)
	  {
      // show link to the prev page
      ?><span class="clsScroller"><a href="<?php echo $this->ScrollNavigateModRewrite($LastPage+1)?>" class="clsScrollerText">..</a></span><?php
	  }
	    
	  
    // [next]
    if($this->Page<$this->PageCount)
	  {
      // show link to the next page
	    ?><span class="clsScroller" style="padding-right: 0px;"><a HREF="<?php echo $this->ScrollNavigateModRewrite($this->Page+1)?>" class="clsScrollerText"><?php echo $this->MsgPagingNext?></a></span><?php
	  }
?>
<br>
<?php } //Scroll_Show()

///////////////////////////////////////////////////////////////////////////
/**
* @desc Возвращает номер страницы для SQL-запроса механизма прокрутки
*/
  function ScrollCount($sql)
  {
  	global $db;
	$this->PageCount=0;
	//counting pages and limiting newscount per page
	$db->open($sql);
	while(($row=$db->fetch()))
	{
	    $this->PageCount+=$row['cnt'];
	}
    $this->PageCount=(int)ceil(($this->PageCount/$this->PubPerPage));// по $pubPerPage новостей на страницу
    if($_GET['page'])$this->Page=(int)($_GET['page']);
    else $this->Page=1;
    $this->SqlPage=(int)(($this->Page-1)*$this->PubPerPage);
  }
///////////////////////////////////////////////////////////////////////////

}// PageScroller class end

?>