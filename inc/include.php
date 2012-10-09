<?php


	session_start();
	require "setpath.php";
	require "common.php";
	require "sessioncheck.php";
	require "properties.php";
	require "connect.php";
	require "Smarty.php";
	

	$smarty->assign("sessionuserid", $_SESSION['userid']);
	$smarty->assign("sessionroleid", $_SESSION['role_id']);
	$smarty->assign("session_name", $_SESSION['name']);
	$smarty->assign("sessionorgid", $_SESSION['org_id']);
	
	$sessionuserid = $_SESSION['userid'];
	$sessionroleid = $_SESSION['role_id'];
	$sessionname = $_SESSION['name'];
	$sesssionorgid = $_SESSION['org_id'];
?>