<?php
ini_set('display_errors',0);
if(!mysql_connect($dbhost,$dbuser,$dbpassword)){
	die("Unable to connect to the database");
}
if(!mysql_select_db($dbname)){
	die("Unable to select the database");
}
ini_set('display_errors',1);
?>
