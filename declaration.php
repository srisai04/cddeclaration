<?php
require("inc/include.php");
$completed_msg="";
$user_details=getUserDetails($_SESSION['userid']);
$smarty->assign("user_details",$user_details);
if(isset($_POST['submit']) && isset($_POST['choice']))
{
	//print "1 ".$_POST['decl_id']."\n". "<br>";
	if($_POST['decl_id'] == "0")
	{
		//print "2 ".$_POST['decl_id']."\n". "<br>";
		$user_decid = saveDeclaration($_SESSION['userid'],0);
		$smarty->assign("decl_id",$user_decid);
	}
	$choice = ($_REQUEST['choice'] == "no")? "N":"Y";
	$user_decid=($_POST['decl_id'] == "0")? $user_decid:$_POST['decl_id'];
	saveSectionConfirmation($user_decid, $_REQUEST['section_id'],$choice);

	if($choice == "Y")
	{
		$decldetails=array();
		foreach($_POST as $name=>$value)
		{
			$qid=$aid=$notes="";
			if(preg_match("/^qid_[0-9]+$/",$name))
			{
				list($qstr,$qid) = explode("_",$name);
				if(isset($_POST["aid_".$qid]))
				{
					$aid = $_POST["aid_".$qid];
				}
				if(isset($_POST["notes_".$qid]))
				{
					$notes = $_POST["notes_".$qid];
				}
				if($aid > 0)
				{
					if(is_array($aid))
					{
						foreach($aid as $ans_id)
						{
							$unhide_notes = $_POST['unhide_notes_'.$qid.'_'.$ans_id];
							if($unhide_notes == "Y")
								$decldetails[]=array($qid, $ans_id, $notes);
							else
								$decldetails[]=array($qid, $ans_id, "");
						}
					} else {
						$decldetails[]=array($qid, $aid, $notes);
					}
				} else {
					$err_msg = "Question ID : $qid was not answered";
					$decldetails=array();
					break;
				}
			}
		}
		if($decldetails)
		{
			saveDeclaration($_SESSION['userid'], $user_decid, $decldetails);
			isSectionCompleted($user_decid, $_POST['section_id'], true);
		}
	}
	if(updateDeclarationCompleted($user_decid))
	{
		$completed_msg="Congratulations you have completed the Controlled Drugs Declaration for the current year.
											You can view complteted declaration in View My Declaration.";
		$smarty->assign("user_details",$user_details);
		$user_dec=getDeclarationDetails($_SESSION['userid']);
		$smarty->assign("u_dec",$user_dec);
		$body=$smarty->fetch('mydeclaration_email.tpl');
		$emailid = $user_details['email'];
		$subject = "Successful completion of CD declaration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: noreply@cddeclaration.com\r\n" ."X-Mailer: php";
		mail($emailid, $subject, $body, $headers);
	}
}

$user_decid=getUserDeclaration($_SESSION['userid']);
$smarty->assign("decl_id",$user_decid);

if($user_decid == -1 && $completed_msg == "")
{
	$completed_msg="You have completed the Controlled Drugs Declaration for the current year. You can view complteted declaration in View My Declaration.";
} else {
	if($user_decid == 0)
	{
		$section=getAppropSection(0);
		$decls = StartResumeDeclaration($user_decid,$section['section_id']);
	} else {
		if(!isset($_REQUEST['section_id']))
		{
			$section=getAppropSection(getDeclaredSection($user_decid));
		} else {
			if(isset($_POST['choice']))
				$section=getAppropSection($_REQUEST['section_id']);
			else
				$section=getSectionDetails($_REQUEST['section_id']);
		}
		if(!is_null($section))
		{
			$decls = StartResumeDeclaration($user_decid,$section['section_id']);
		}
	}

	if(isset($decls) && $decls)
	{
		$smarty->assign("section",$decls['section']);
		$smarty->assign("decls",$decls['declaration']);
	}
}
$smarty->assign("completed_msg", $completed_msg);
$smarty->display("declaration.tpl");
?>
