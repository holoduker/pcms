<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

$messagebox=new CMessageBox("��������� ������. ����������� �������� �� �������.");
$messagebox->Icon=MB_ICON_ERROR;
$messagebox->Show();
?>