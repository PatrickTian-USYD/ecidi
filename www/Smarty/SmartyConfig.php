<?php

include("./Smarty/libs/Smarty.class.php");
define('SMARTY_ROOT', './Smarty');
$tpl = new Smarty();
$tpl->template_dir = SMARTY_ROOT."/templates/";
$tpl->compile_dir = SMARTY_ROOT."/templates_c/";
$tpl->config_dir = SMARTY_ROOT."/configs/";
$tpl->cache_dir = SMARTY_ROOT."/cache/";
$tpl->caching = false; 
//$tpl->clear_compiled_tpl();
//$tpl->caching=1;
//$tpl->cache_lifetime=60*60*24;
$tpl->left_delimiter = '<{{';
$tpl->right_delimiter = '}}>';
?>
