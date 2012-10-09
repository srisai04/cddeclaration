<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "Test Permissions for temp imports <br>";

$fh = fopen("D:\\MANDCDESIGN.NET\\test\\cddec\\user\\tempimports\\test.txt","rb");
//$fh = fopen("E:\\xampp\\htdocs\\cddec\\tempimports\\test.txt","rw");

fwrite($fh, "Writing to file");
fclose($fh);

echo "If you are not seeing any error above, the permissions are provided to tempimports.";

echo "Test Permissions for templates_c <br>";

$fh = fopen("D:\\MANDCDESIGN.NET\\test\\cddec\\smarty\\templates_c\\test.txt","rb");
//$fh = fopen("E:\\xampp\\htdocs\\cddec\\smarty\\templates_c\\test.txt","rw");


fwrite($fh, "Writing to file");
fclose($fh);

echo "If you are not seeing any error above, the permissions are provided to templates_c.";

echo "Test Permissions for Cache <br>";

$fh = fopen("D:\\MANDCDESIGN.NET\\test\\cddec\\smarty\\cache\\test.txt","rb");
//$fh = fopen("E:\\xampp\\htdocs\\cddec\\smarty\\cache\\test.txt","rw");

fwrite($fh, "Writing to file");
fclose($fh);

echo "If you are not seeing any error above, the permissions are provided to cache.";

?>