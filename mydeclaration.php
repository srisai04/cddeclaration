<?php
require("inc/include.php");

$msg = (isset($_GET['msg']))? $_GET['msg']:"";
$declid = (isset($_GET['declid']))? $_GET['declid']:"";

$smarty->assign("msg", $msg);
$smarty->assign("declid", $declid);

$decls = getDeclarationList($_SESSION['userid']);

$user_details=getUserDetails($_SESSION['userid']);

if ($declid != "" && $declid != null){
	$user_dec=getDeclarationDetailsArc($_SESSION['userid'],$declid);
}else{
	$user_dec=getDeclarationDetails($_SESSION['userid']);
}

//print_pre($user_dec);
$smarty->assign("decls",$decls);

$err_msg=($user_dec == null)? "You have not completed CD declaration.":"";
$smarty->assign("user_details",$user_details);
$smarty->assign("u_dec",$user_dec);
$smarty->assign("err_msg", $err_msg);
$smarty->display('mydeclaration.tpl');
?>
