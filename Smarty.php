<?php
$root = $_SERVER['DOCUMENT_ROOT'].APP_PATH;
require_once('Smarty.class.php');
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->caching = 0;
$smarty->cache_lifetime = 0;
$smarty->assign('appname', 'CD Declaration');
$smarty->setTemplateDir($root . DIR_SEPARATOR . "smarty" . DIR_SEPARATOR . "templates");
$smarty->setCompileDir($root . DIR_SEPARATOR . "smarty" . DIR_SEPARATOR . "templates_c");
$smarty->setCacheDir($root . DIR_SEPARATOR . "smarty" . DIR_SEPARATOR . "cache");
$smarty->setConfigDir($root . DIR_SEPARATOR . "smarty" . DIR_SEPARATOR . "configs");

?>
