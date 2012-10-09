<?php
/*if($_SERVER['SERVER_PORT']!=443)
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'];
     header("Location:$redirect");
  }*/
  
  
error_reporting(E_ALL);
ini_set('display_errors',"1");
if(preg_match("/Linux/" , php_uname()))
{
  if(!defined("PATH_SEPARATOR"))
    define("PATH_SEPARATOR", ":");
  if(!defined("DIR_SEPARATOR"))
    define("DIR_SEPARATOR", "/");
} else {
  if(!defined("PATH_SEPARATOR"))
    define("PATH_SEPARATOR", ";");
  if(!defined("DIR_SEPARATOR"))
    define("DIR_SEPARATOR", "\\");
}


if(preg_match("/ABBEYROAD/", php_uname()))
{
  if(!defined("APP_PATH"))
    define("APP_PATH", DIR_SEPARATOR . "test" . DIR_SEPARATOR . "cddecdatabase");
} else {
  if(!defined("APP_PATH"))
    define("APP_PATH", DIR_SEPARATOR . "cddecv2");
}

if(!defined("APP_PATH"))
	define("APP_PATH", "cddecv2");

//Define the document root variable

if(!isset($_SERVER['DOCUMENT_ROOT'])){
	if(isset($_SERVER['SCRIPT_FILENAME'])){
		$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));
	};
};
if(!isset($_SERVER['DOCUMENT_ROOT'])){
	if(isset($_SERVER['PATH_TRANSLATED'])){
		$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])));
	};
};

// $_SERVER['DOCUMENT_ROOT'] is now set


if(!defined("CSS_PATH"))define("CSS_PATH", APP_PATH . DIR_SEPARATOR . "_css");
if(!defined("IMG_PATH"))define("IMG_PATH", APP_PATH . DIR_SEPARATOR ."_images");
if(!defined("SCR_PATH"))define("SCR_PATH", APP_PATH . DIR_SEPARATOR ."_scripts");

if(!defined("CDD_PATH"))
  define("CDD_PATH", $_SERVER['DOCUMENT_ROOT'] . DIR_SEPARATOR . APP_PATH);
if(!defined("SMARTY"))
  define("SMARTY", CDD_PATH . DIR_SEPARATOR . 'smarty' . DIR_SEPARATOR . 'libs');
if(!defined("INC_PATH"))
  define("INC_PATH", CDD_PATH . DIR_SEPARATOR . 'inc');
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR  . CDD_PATH . PATH_SEPARATOR . SMARTY . PATH_SEPARATOR . INC_PATH . PATH_SEPARATOR . CSS_PATH . PATH_SEPARATOR . SCR_PATH . PATH_SEPARATOR . IMG_PATH);

if(!defined("IMPORT_PATH"))
  define("IMPORT_PATH", CDD_PATH . DIR_SEPARATOR . 'user' . DIR_SEPARATOR . 'tempimports' . DIR_SEPARATOR);

//uncomment the below line to see the include_path
//print str_replace(PATH_SEPARATOR,"\n<br>", ini_get("include_path"));
?>