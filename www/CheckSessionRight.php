<?php
header("content-type:text/html; charset=utf-8");
////////////////////////////////////////////////////////////////////////////////
ob_start();
session_start();
//echo "SESSION FullName:".$_SESSION["FullName"];
if(!isset($_SESSION['UserName']))
    header('Location:login.html');
else
{
	$tpl->assign("FullName", $_SESSION["FullName"]);
}
?>
