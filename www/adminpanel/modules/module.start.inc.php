<?php
if(!defined("IN_CMS"))die("Invalid script call");
if(!defined("CONTENT_PAGE_CALL"))die("Invalid script call");

$messagebox=new CMessageBox("����� ���������� � ������� ���������� ���������� ����� site!");
$messagebox->Icon=MB_ICON_OK;
$messagebox->Show();
?>