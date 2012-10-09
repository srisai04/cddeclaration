<?php
require("inc/include.php");

$msg = (isset($_GET['msg']))? $_GET['msg']:"";
$declid = (isset($_GET['declid']))? $_GET['declid']:"";

$smarty->assign("msg", $msg);
$smarty->assign("declid", $declid);

//Set user id

$user_id = (isset($_GET['user_id']))? $_GET['user_id']:"";

$decls = getDeclarationList($user_id);

$user_details=getUserDetails($user_id);

if ($declid != "" && $declid != null){
	$user_dec=getDeclarationDetailsArc($user_id,$declid);
}else{
	$user_dec=getDeclarationDetails($user_id);
}

//print_pre($user_dec);
$smarty->assign("decls",$decls);

$err_msg=($user_dec == null)? "You have not completed CD declaration.":"";
$smarty->assign("user_details",$user_details);
$smarty->assign("u_dec",$user_dec);
$smarty->assign("err_msg", $err_msg);
$smarty->display('mydeclaration.tpl');
?>
