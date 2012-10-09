<?php
	$sqlinsert1 = "INSERT INTO declarations_arc";
	$sqlinsert2 = "INSERT INTO declaration_sections_arc";
	$sqlinsert3 = "INSERT INTO declaration_details_arc";

	$sqlselect1 = " SELECT d.* FROM `declarations` d, `users` u, `organisations` o";
	
	$sqlselect2 = " SELECT * FROM `declaration_sections` WHERE decl_id IN(
							SELECT d.decl_id
							FROM `declarations` d, `users` u, `organisations` o";
	
	$sqlselect3 = " SELECT * FROM `declaration_details` WHERE decl_id IN(
							SELECT d.decl_id
							FROM `declarations` d, `users` u, `organisations` o";
	
	$sqlwhere = " WHERE d.user_id = u.user_id
					AND u.org_id = o.org_id";

	$orderby = " ORDER BY d.decl_id";
	
	$sqlexec = "";
	$archsuccess = "1";
	
	if ($sessionroleid != 1) $org1 = $sessionorgid;	
	
	//Individual User
	if ($user != 0 && $user != null){
		echo "<b>User Level archive:</b>";
		$sqlwhereext = " AND YEAR( d.decl_started_on ) = '".$archyear."' AND u.user_id = '".$user."'";
		$sqlwhere1 = $sqlwhere . $sqlwhereext;
		$sqldelete = "DELETE FROM declarations WHERE YEAR( decl_started_on ) = '".$archyear."' AND user_id='".$user."'";
	}else if ($org1 != null && $org1 != 0){
		echo "<b>Organisation Level archive:</b>";
		$sqlwhereext = " AND o.org_id = ".$org1." AND YEAR( d.decl_started_on ) = '".$archyear."'";
		$sqlwhere1 = $sqlwhere . $sqlwhereext;
		$sqldelete = "DELETE FROM declarations WHERE YEAR( decl_started_on ) = '".$archyear."' AND user_id IN (SELECT u.user_id from users u, organisations o WHERE u.org_id = o.org_id and o.org_id ='".$org1."')";
	}else{
		echo "<b>System Level archive:</b>";
		$sqlwhereext = " AND YEAR( d.decl_started_on ) = '".$archyear."'";
		$sqlwhere1 = $sqlwhere .$sqlwhereext;
		$sqldelete = "DELETE FROM declarations WHERE YEAR( decl_started_on ) = '".$archyear."'";
	}
	
	//Declaratin Table Archive
	$sqlexec = $sqlinsert1 . $sqlselect1 . $sqlwhere1 . $orderby;
	//echo "<br/>" ."SQL:".$sqlexec."<br/>";
	$r = mysql_query($sqlexec);
	if(!$r) {
		$err=mysql_error();
		$archsuccess = "0";
		echo "<br/>Declaration Table: Archival process is unsuccessful, please try again later. Error:".$err;
	}else{
		echo "<br/>Declaration Table: Declarations are successfully archived and purged from active database.";
	}

	//Declaratin Sections Table Archive
	$sqlexec = $sqlinsert2 . $sqlselect2 . $sqlwhere1 . $orderby .")";
	//echo "<br/>" ."SQL:".$sqlexec."<br/>";
	$r = mysql_query($sqlexec);
	if(!$r) {
		$err=mysql_error();
		$archsuccess = "0";
		echo "<br/>Declaration Sections Table: Archival process is unsuccessful, please try again later. Error:".$err;
	}else{
		echo "<br/>Declaration Sections Table: Declarations are successfully archived and purged from active database.";
	}

	//Declaratin Details Table Archive
	$sqlexec = $sqlinsert3 . $sqlselect3 . $sqlwhere1 . $orderby .")";
	//echo "<br/>" ."SQL:".$sqlexec."<br/>";
 	$r = mysql_query($sqlexec);
	if(!$r) {
		$err=mysql_error();
		$archsuccess = "0";
		echo "<br/>Declaration Details Table: Archival process is unsuccessful, please try again later. Error:".$err;
	}else{
		echo "<br/>Declaration Details Table: Declarations are successfully archived and purged from active database.";
	}

	if ($archsuccess = "1"){
		$r1 = mysql_query($sqldelete);
		if(!$r1) {
			$err=mysql_error();
			echo "<br/>Declarations: Deletion process is unsuccessful, please try again later. Error:".$err;
		}else{
			echo "<br/>Declarations: Declarations are successfully purged from active database.";
		}
	}else{
		echo "<br/>Data Purge: Archival failed, hence the data is not purged.";
	}
?>