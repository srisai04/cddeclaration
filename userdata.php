<?php 
		session_start();
		require "setpath.php";
		require "common.php";
		require "properties.php";
		require "connect.php";
		require "Smarty.php";

		if (isset($_REQUEST['status']))$status = $_REQUEST['status'];else $status = "";
		if (isset($_REQUEST['subfilter']))$subfilter = $_REQUEST['subfilter'];else $subfilter = "";
		if (isset($_REQUEST['selection']))$selection = $_REQUEST['selection'];else $selection = "";
		if (isset($_REQUEST['year'])) $year = $_REQUEST['year']; else $year = "";
		if (isset($_REQUEST['qid'])) $qid = $_REQUEST['qid']; else $qid = "";
		if (isset($_REQUEST['secid'])) $secid = $_REQUEST['secid']; else $secid = "";
		
		if (isset($_SESSION['org_id'])) $sessionorgid=$_SESSION['org_id'];else $sessionorgid="";
		if (isset($_SESSION['role_id'])) $sessionroleid=$_SESSION['role_id'];else $sessionroleid="";
	
		$msg = "";
		$sql = "";
		$sqlu = "";		
		
		if (isset($_REQUEST['org'])) $org = $_REQUEST['org']; else $org = "";
		if (isset($_REQUEST['role'])) $role = $_REQUEST['role']; else $role = "";
		
		$smarty->assign("sessionroleid",null);
		$smarty->display('header.tpl');
		
		if ($year == date('Y')){
			$tbl_d = "declarations d";
			$tbl_dd = "declaration_details dd";
		}else{
			$tbl_d = "declarations_arc d";
			$tbl_dd = "declaration_details_arc dd";
		}
		
		//print ("Org:".$org);
		if ($org == "" || $org == 0){
			if ($sessionroleid != 1) $org = $sessionorgid;
		}

		if ($subfilter == "Declaration Status"){
			if ($selection == 0){
				$sel = "Not Started";
				$sql = "SELECT * FROM users u, roles r, organisations o, address ad, professions p WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id".
			  	" and u.role_id = 4 and u.user_id NOT IN ( SELECT d.user_id from $tbl_d WHERE YEAR( d.decl_started_on ) = $year)";
			}else if ($selection == 1){
				$sel = "Started";
				$sql = "SELECT * FROM users u, roles r, organisations o, address ad, professions p WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id".
			  	" and u.role_id = 4 and u.user_id IN ( SELECT d.user_id from $tbl_d WHERE YEAR( d.decl_started_on ) = $year and d.decl_completed='N')";
			}else if ($selection == 2){
				$sel = "Completed";
				$sql = "SELECT * FROM users u, roles r, organisations o, address ad, professions p WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id".
			  	" and u.role_id = 4 and u.user_id IN ( SELECT d.user_id from $tbl_d WHERE YEAR( d.decl_started_on ) = $year and d.decl_completed='Y')";
			}
		}else if ($subfilter == "Compliance Status"){
			if ($selection == 0){
				$sel = "Compliance";
				$sql = "SELECT * FROM users u, roles r, organisations o, address ad, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id".
			  	" and u.role_id = 4 and d.user_id=u.user_id and d.decl_completed='Y' and".
				" (SELECT count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = $year";
			}else if ($selection == 1){
				$sel = "Non Compliance";
				$sql = "SELECT * FROM users u, roles r, organisations o, address ad, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id".
			  	" and u.role_id = 4 and d.user_id=u.user_id and d.decl_completed='Y' and".
				" (SELECT count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) != 0 and YEAR( d.decl_started_on ) = $year";
			}
		}else if ($subfilter == "Section Level Status"){
			$sqlsec = "SELECT * FROM sections order by section_id";
			$r = mysql_query($sqlsec);
	        //echo "SQL: ".$sqlsec;
	        if(!$r) {
				$err=mysql_error();
				$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
			}else {
				$res = mysql_data_seek($r,$selection);
				$row = mysql_fetch_array($r);
				$secid = $row['section_id'];
				$seccode = $row['section_code'];
			}
			
			if ($secid != null ){
				$sel = "Section - ".$seccode;
				/*$sql = "SELECT * from users u, roles r, organisations o, address ad, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q, sections s where s.section_id=$secid and s.section_id=q.section_id and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = $year";
				$sqlu = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, answers a, questions q, sections s, roles r, organisations o, address ad, professions p,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and s.section_id=$secid and s.section_id=q.section_id and d.decl_completed = 'Y' and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = $year";
				*/
				$sql = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, roles r, organisations o, address ad, declaration_sections ds, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
						"and u.active = 1 and d.user_id = u.user_id and d.decl_completed = 'Y' and d.decl_id=ds.decl_id and ds.section_id = '$secid' and ds.user_confirmed = 'Y' and YEAR( d.decl_started_on ) = $year";
				$sqlu = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, roles r, organisations o, address ad, declaration_sections ds, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
						"and u.active = 1 and d.user_id = u.user_id and d.decl_completed = 'Y' and d.decl_id=ds.decl_id and ds.section_id = '$secid' and ds.user_confirmed = 'N' and YEAR( d.decl_started_on ) = $year";
			}
		}else if ($subfilter == "Section Wise Status"){
			$sqlsec = "SELECT * FROM sections order by section_id";
			$r = mysql_query($sqlsec);
	        //echo "SQL: ".$sqlsec;
	        if(!$r) {
				$err=mysql_error();
				$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
			}else {
				$res = mysql_data_seek($r,$selection);
				$row = mysql_fetch_array($r);
				$secid = $row['section_id'];
				$seccode = $row['section_code'];
			}
			
			if ($secid != null ){
				$sel = "Section - ".$seccode;
				$sql = "SELECT * from users u, roles r, organisations o, address ad, professions p,$tbl_d WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q, sections s where s.section_id=$secid and s.section_id=q.section_id and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = $year";
				$sqlu = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, answers a, questions q, sections s, roles r, organisations o, address ad, professions p,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and s.section_id=$secid and s.section_id=q.section_id and d.decl_completed = 'Y' and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = $year";
			}
		}else if ($subfilter == "Question Status"){
			$sel = "Section ".$secid.", Question Id ".$qid;
			$sql = "SELECT distinct u.*,p.*,o.*,r.*,ad.*,a.* from users u, answers a, questions q, roles r, organisations o, address ad, professions p,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and q.question_id=$qid and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = $year";
		}else if ($subfilter == "Response Status"){
			$nofNR = "=0";
			if ($selection == 0) {
				$sel = "1 NR";
				$nofNR = "=1";
			}else if ($selection == 3) {
				$sel = "10+ NR";
				$nofNR = ">10";
			}
			
			$sql = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, organisations o, address ad, professions p, roles r,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and d.user_id = u.user_id and d.decl_completed = 'Y' and u.address_id=ad.address_id and u.org_id=o.org_id and u.profession_id = p.profession_id and (select count(*) as count from $tbl_dd,".
				"answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) $nofNR and YEAR( d.decl_started_on ) = ".$year;
			
			if ($selection == 1) {
				$sel = "2 to 5 NR";
				$sql = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, organisations o, address ad, professions p, roles r,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and d.user_id = u.user_id and d.decl_completed = 'Y' and u.address_id=ad.address_id and u.org_id=o.org_id and u.profession_id = p.profession_id and (select count(*) as count from $tbl_dd ,".
				"answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 1 and (select count(*) as count from $tbl_dd ,answers a, questions q ".
				"where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) <=5 and YEAR( d.decl_started_on ) = ".$year;
			}else if ($selection == 2) {
				$sel = "6 to 10 NR";
				$sql = "SELECT distinct u.*,p.*,o.*,r.*,ad.* from users u, organisations o, address ad, professions p, roles r,$tbl_d, $tbl_dd WHERE u.profession_id=p.profession_id and u.address_id=ad.address_id and u.role_id = r.role_id and u.org_id = o.org_id ".
				"and u.active = 1 and u.role_id = 4 and d.user_id = u.user_id and d.user_id = u.user_id and d.decl_completed = 'Y' and u.address_id=ad.address_id and u.org_id=o.org_id and u.profession_id = p.profession_id and (select count(*) as count from $tbl_dd ,".
				"answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 5 and (select count(*) as count from $tbl_dd ,answers a, questions q ".
				"where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) <=10 and YEAR( d.decl_started_on ) = ".$year;
				
			}  
		}
		
		if ($org != "" && $org != 0) {
			$sql = $sql . " and u.org_id='$org'";
			if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status") $sqlu = $sqlu . " and u.org_id='$org'";
		}
		
		if ($subfilter == "Question Status") $sql = $sql . " order by a.answer";
			
		//print("SQL:".$sql);
		//print("SQL:".$sqlu);
?>

<div id="divNoRHS_LHS">

  <h1 class="green"><br/>Dashboards: <?php echo "$subfilter ( $sel )";?></h1>
  
  <form name="form2" method="post">
    	<?php 
	  		if ($subfilter == "Question Status"){
  		        if ($subfilter == "Question Status" && $qid != null && $qid != 0){
	                $sql1 = "SELECT q.question_id, q.question, s.section_code, a.answer FROM questions q, sections s, answers a WHERE q.section_id = s.section_id and q.question_id = a.question_id and q.question_id=".$qid;
	                $r1 = mysql_query($sql1);
					if(!$r1){
						$msg = "Unable to retrieve question.";
					}else {
						  $i=0;
						  while($row = mysql_fetch_array($r1)){
						  	if ($i == 0)echo "".$row['question']."</br>";
						  	$i++;
						  	echo "".$i.")".$row['answer']. " ";
						  }
						  echo "</br></br>";
					}
	  			}
	  		}
  		?>

    <table class="tblUsers">
      <?php
				//if ($ordby == 1) $ord=0; else $ord = 1;
  				echo "<th>Id</th>";
				echo "<th>Name</th>";
				echo "<th>E-Mail ID</th>";
				echo "<th>Phone</th>";
				echo "<th>Profession</th>";
				echo "<th align=\"center\" bgcolor=\"gray\">Organisation</th>";
				echo "<th>PRN</th>";
				if ($subfilter == "Question Status"){
					echo "<th>Answer</th>";
				}
				//echo "<th>GPP</th>";
				//echo "<th>Consortia</th>";
				echo "<th width=\"20%\" align=\"center\" bgcolor=\"gray\">Address</th>";

			  	if (!empty($pno) && !empty($noi))
			  	{
			  		$start = $pno * noi;
			  		$end = $start + $noi;
			  		$sql = $sql. " limit ".$start. " , ".$end;
			  	}
				
			  	if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
			  		echo "<tr class=\"alt\">";
			  		if ($subfilter == "Section Wise Status") {$subhead = "All responses best practice";} else { $subhead = "Relevant";}
			  		echo "<td colspan=\"10\"><b>".$subhead ."</b></td></tr>";
			  	}
			  	
			  				  	
			  	//print("SQL1:".$sql);
				$r1 = mysql_query($sql);
				if(!$r1) {
					$err=mysql_error();
					$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
				}else{
					$count = 0;
					while($row = mysql_fetch_array($r1)){
						if ($count % 2) echo "<tr>";
						else echo "<tr class=\"alt\">";
							echo "<td width=\"5%\">".$row['user_id']."</td>";
							echo "<td  width=\"5%\" class=\"la\">".$row['user_fname']." ";
							echo "".$row['user_lname']."</td>";
							echo "<td width=\"5%\">".$row['email']."</td>";
							echo "<td width=\"5%\">".$row['phone']."</td>";
							echo "<td width=\"5%\">".$row['profession']."</td>";
							echo "<td width=\"5%\">".$row['organisation']."</td>";
							echo "<td width=\"5%\">".$row['prn']."</td>";
							//echo "<td width=\"5%\">".$row['gppcode']."</td>";
							//echo "<td width=\"5%\">".$row['consortia']."</td>";
							if ($subfilter == "Question Status"){
								echo "<td width=\"5%\">".$row['answer']."</td>";
							}
							echo "<td width=\"55%\">".$row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4'].", ". $row['county']." ". $row['city']." ". $row['country']." ". $row['pincode']."</td>";
                		echo "</tr>";
                		$count++;
					}
					if ($count == 0){
						echo "<tr class=\"alt\">";
				  		echo "<td colspan=\"10\">No Records Found.</td></tr>";
					}
				}

				
				if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
			  		echo "<tr class=\"alt\">";
					if ($subfilter == "Section Wise Status") {$subhead = "One or more response not best practice";} else { $subhead = "Not Relevant";}
			  		echo "<td colspan=\"10\"><b>". $subhead ."</b></td></tr>";
					//print("SQL1:".$sqlu);
					$r1 = mysql_query($sqlu);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
					}else{
						$count = 0;
						while($row = mysql_fetch_array($r1)){
							if ($count % 2) echo "<tr>";
							else echo "<tr class=\"alt\">";
								echo "<td width=\"5%\">".$row['user_id']."</td>";
								echo "<td  width=\"5%\" class=\"la\">".$row['user_fname']." ";
								echo "".$row['user_lname']."</td>";
								echo "<td width=\"5%\">".$row['email']."</td>";
								echo "<td width=\"5%\">".$row['phone']."</td>";
								echo "<td width=\"5%\">".$row['profession']."</td>";
								echo "<td width=\"5%\">".$row['organisation']."</td>";
								echo "<td width=\"5%\">".$row['prn']."</td>";
								//echo "<td width=\"5%\">".$row['gppcode']."</td>";
								//echo "<td width=\"5%\">".$row['consortia']."</td>";
								echo "<td width=\"55%\">".$row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4'].", ". $row['county']." ". $row['city'].", ". $row['country'].", ". $row['pincode']."</td>";
	                		echo "</tr>";
	                		$count++;
						}
						if ($count == 0){
							echo "<tr class=\"alt\">";
					  		echo "<td colspan=\"10\">No Records Found.</td></tr>";
						}
					}
			  		
			  	}
				
			  	if ($subfilter == "Question Status"){
			  		// Taken care in general section above
			  	}
			  	
			  	if ($subfilter == "Response Status"){
					// Taken care in general section above
			  	}
	  		?>
	  <tr><td colspan="10"><hr /></td></tr>
      <tr class="alt">
        <td colspan="10"><div class="divFilter">
        	<br/>
        		<input name="sqlqry" type="hidden" value="<?php echo $sql; ?>" />
        		<input name="sqlqryu" type="hidden" value="<?php echo $sqlu; ?>" />
        		<input name="info" type="hidden" value="<?php echo "Organisation:".$org." Year:".$year; ?>" />
				<input name="sel" type="hidden" value="<?php echo $subfilter . " - ". $sel ;?>" />
				<input name="subfilter" type="hidden" value="<?php echo $subfilter;?>" />
				<input name="quid" type="hidden" value="<?php echo $qid;?>" />
        	<a href="javascript:print()"><img src="_images/print.jpeg" width="20" height="20" alt="Print"/></a>
            <!-- input name="print" type="button" onclick="javascript:print()" value="Print" /-->
            <input name="genpdf" type="button" onclick="return generateReport('pdf')" value="Generate PDF" />
            <input name="genxls" type="button" onclick="return generateReport('xls')" value="Generate CSV" />
          </div></td>
      </tr>
    </table>
  </form>
  
  <!--  Display Area -->
</div> <!-- END OF #div no RHS_LHS -->

<div class="clear">  <!-- --> </div>

<?php $smarty->display("footer.tpl");?>
	
</div> <!-- END OF #divPage -->

<div id="divPageBottom">  <!-- --> </div>

</div>
</body>
</html>