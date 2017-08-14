<?php
include("Smarty/SmartyConfig.php");
include("PubApi.php");
include("CheckSessionRight.php");
//echo PHP_VERSION;
//session_start();


$tpl->assign("title", "leapsoul.cn为你展示smarty模板技术");
$tpl->assign("content", "leapsoul.cn通过详细的安装使用步骤为你展示smarty模板技术");
$tpl->display("index.html");
?>