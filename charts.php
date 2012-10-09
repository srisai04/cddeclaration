<?php
	if (isset($_REQUEST['org'])) $org = $_REQUEST['org']; else $org = "";
	if (isset($_REQUEST['subfilter'])) $subfilter = $_REQUEST['subfilter']; else $subfilter = "";
	if (isset($_REQUEST['orgname'])) $orgname = $_REQUEST['orgname']; else $orgname = "";
	if (isset($_REQUEST['dbyear'])) $dbyear = $_REQUEST['dbyear']; else $dbyear = "";
	if (isset($_REQUEST['qid'])) $qid = $_REQUEST['qid']; else $qid = "";
	if (isset($_REQUEST['secid'])) $secid = $_REQUEST['secid']; else $secid = "";
	
	//echo "Sec ID:".$secid;
	
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";

	if (isset($_SESSION['org_id'])) $sessionorgid=$_SESSION['org_id'];else $sessionorgid="";
	if (isset($_SESSION['role_id'])) $sessionroleid=$_SESSION['role_id'];else $sessionroleid="";

	$msg = "";

	$subfilterval = array('default','Declaration Status','Compliance Status','Section Level Status', 'Section Wise Status', 'Question Status', 'Response Status');

	if ($status == 1){//Generate Reports
			$sql = "SELECT count(DISTINCT u.user_id) as usercount";
			$sqldata = "SELECT DISTINCTROW u.user_fname,u.user_lname,u.email";

			$fromclause = " from users u";
			$whereclause = " where active != -1";
			$dataset1=0;
			$dataset2=0;
			$dataset3=0;
			$dataset4 =0;

			$records=array();
			$records1=array();
			$records2=array();
			$records3=array();
			$records4=array();

			if ($dbyear == date('Y')){
				$tbl_d = "declarations d";
				$tbl_dd = "declaration_details dd";
			}else{
				$tbl_d = "declarations_arc d";
				$tbl_dd = "declaration_details_arc dd";
			}
			
			if ($sessionroleid != 1 && $org == 0){
				if ($org == 0) $whereclause = $whereclause . " and u.org_id='".$sessionorgid."'"; else $whereclause = $whereclause . " and u.org_id=".$org."";
			}else {
				if ($org != 0)$whereclause = $whereclause . " and u.org_id=".$org;
			}

			if ($subfilter != 'default' && $subfilter=='Declaration Status'){
					//Not Started
					$fromclause = " from users u, $tbl_d";
					$whereexec = $whereclause . " and u.role_id = 4 and (SELECT count(decl_id) as count FROM declarations where u.user_id = declarations.user_id and YEAR( decl_started_on ) = $dbyear ) = 0";
					$sqlexec = $sql . $fromclause . $whereexec;
					$sqldataexec = $sqldata . $fromclause . $whereexec;
					//echo "SQL:".$sqlexec."<br>";
					$r1 = mysql_query($sqlexec);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						if ($row = mysql_fetch_array($r1)) {
							$dataset1 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
							if(mysql_num_rows($r2))
							{
								while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
								{
									$records1[]=$row2;
								}
							}
						} else {
							$dataset1 = 0;
						}
					}

					//Started
					 $fromclause = " from users u, $tbl_d";
					 $whereexec = $whereclause . " and u.role_id = 4 and d.user_id=u.user_id and d.decl_completed='N' and YEAR(d.decl_started_on)=".$dbyear;
					$sqlexec = $sql . $fromclause . $whereexec;
					$sqldataexec = $sqldata . $fromclause . $whereexec;
					//echo "SQL:".$sqlexec."<br>";
					$r1 = mysql_query($sqlexec);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						if ($row = mysql_fetch_array($r1)) {
							$dataset2 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
							if(mysql_num_rows($r2))
							{
								while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
								{
									$records2[]=$row2;
								}
							}
						} else {
							$dataset2 = 0;
						}
					}

					//Completed irrespective of successful or unsuccessful
					$fromclause = " from users u,$tbl_d";
					$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed ='Y' and
					YEAR( d.decl_started_on ) = ".$dbyear;
					$sqlexec = $sql . $fromclause . $whereexec;
					$sqldataexec = $sqldata . $fromclause . $whereexec;
					//echo "SQL:".$sqlexec."<br>";
					$r1 = mysql_query($sqlexec);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						if ($row = mysql_fetch_array($r1)) {
							$dataset3 = $row['usercount'];
						$r2=mysql_query($sqldataexec);
							if(mysql_num_rows($r2))
							{
								while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
								{
									$records3[]=$row2;
								}
							}
						} else {

							$dataset3 = 0;
						}
					}

					$records=array("Not Started - ".$dataset1 => $records1, "Started - ".$dataset2 => $records2,
					"Completed - ".$dataset3 => $records3);
				} else if($subfilter=='Compliance Status'){

					//Completed Successful
					$fromclause = " from users u,$tbl_d";
					$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = ".$dbyear;
					$sqlexec = $sql . $fromclause . $whereexec;
					$sqldataexec = $sqldata . $fromclause . $whereexec;
					//echo "SQL:".$sqlexec."<br>";
					$r1 = mysql_query($sqlexec);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						if ($row = mysql_fetch_array($r1)) {
							$dataset1 = $row['usercount'];
						$r2=mysql_query($sqldataexec);
							if(mysql_num_rows($r2))
							{
								while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
								{
									$records1[]=$row2;
								}
							}
						} else {

							$dataset1 = 0;
						}
					}

				//Completed Unsuccessful
					$fromclause = " from users u, $tbl_d, $tbl_dd, answers a, questions q";
					$whereexec = $whereclause . " and u.role_id = 4 and d.user_id = u.user_id and d.decl_completed = 'Y' and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = ".$dbyear;
					$sqlexec = $sql . $fromclause . $whereexec;
					$sqldataexec = $sqldata . $fromclause . $whereexec;
					//echo "SQL:".$sqlexec."<br>";
					$r1 = mysql_query($sqlexec);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						if ($row = mysql_fetch_array($r1)) {
							$dataset2 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
							if(mysql_num_rows($r2))
							{
								while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
								{
									$records2[]=$row2;
								}
							}
						} else {

							$dataset2 = 0;
						}
					}
					$records=array("Compliance - ".$dataset1 => $records1, "Non Compliance - ".$dataset2 => $records2);

			}else if($subfilter == 'Section Wise Status' || $subfilter == 'Section Level Status'){
				$sqlsec = "SELECT * FROM sections order by section_id";
			}else if($subfilter=='Question Status'){
				$sqlsec = "SELECT q.question_id, q.question, a.answer FROM questions q, answers a WHERE q.question_id = a.question_id and a.question_id = ".$qid;
			}

			if ($org==0) {
				$orgname="All";
			}
	
			$heading = $subfilter.", Org: ".$orgname.", Year:".$dbyear.".";
			
			if ($subfilter == "Declaration Status" || $subfilter == "Compliance Status"){
				//echo "\n<pre>\n".print_r(json_encode($records),true)."\n</pre>\n";
				//echo "Message".$dataset1.",". $dataset2.",".$dataset3.",".$dataset4."<br><br>\n";
				echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>\n";
			    echo "<script type=\"text/javascript\">\n";
	
			    echo "var reportdata = '[".json_encode($records)."]';\n";
			    echo "var chart;\n";
			    echo "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n";
			    echo "google.setOnLoadCallback(drawChart);\n";
	
			    echo "function drawChart() {\n";
			    echo "var data = new google.visualization.DataTable();\n";
			        echo "data.addColumn('string', 'CD Dec');\n";
			        echo "data.addColumn('number', 'CD Dec users');\n";
			        echo "data.addRows(".sizeof($records).");\n";
			        $x=$y=0;
			        foreach($records as $repname=>$repdata)
			        {
			        	echo "data.setValue(".$x.", ".$y.", '".$repname."');\n";
			        	echo "data.setValue(".$x.", ".($y+1).", ".count($repdata).");\n";
						$x++;
					}
			        echo "chart = new google.visualization.PieChart(document.getElementById('chart_div'));\n";
			        echo "chart.draw(data, {width: 650, height: 300, title: '$heading'});\n";
					echo "google.visualization.events.addListener(chart, 'select', function() {
						showDashboard('$dbyear','$org','$subfilter',chart.getSelection(),0,0);
					});";
	
			      echo "}\n";
			      echo"</script>\n";
			}else if ($subfilter == "Section Level Status"){
					  echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>\n";
					  echo "<script type=\"text/javascript\">\n";
					  echo "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n";
				      echo "google.setOnLoadCallback(drawChart);\n";
				      echo "function drawChart() {\n";
				      	echo "var data = new google.visualization.DataTable();\n";
				        echo "data.addColumn('string', 'Sections');\n";
				        echo "data.addColumn('number', 'Section Relevant');\n";
				        echo "data.addColumn('number', 'Section Not Relevant');\n";
					
				        $r = mysql_query($sqlsec);
				        //echo "<br>SQL: ".$sqlsec."<br>";
				        if(!$r) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							$norows = mysql_num_rows($r);

				        echo "data.addRows($norows);\n";

				        $i = 0;
				        while ($secrow = mysql_fetch_array($r)){
				     	//Completed Successful
						$fromclause = " from users u,".$tbl_d.", declaration_sections ds";
						//$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q, sections s where s.section_id=".$secrow['section_id']." and s.section_id=q.section_id and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = ".$dbyear;
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and ds.section_id=".$secrow['section_id']." and d.decl_id = ds.decl_id and ds.user_confirmed = 'Y' and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset1 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records1[]=$row2;
									}
								}
							} else {
	
								$dataset1 = 0;
							}
						}
	
						//Completed Unsuccessful
						//$fromclause = " from users u, $tbl_d, $tbl_dd, answers a, questions q, sections s";
						$fromclause = " from users u, $tbl_d, declaration_sections ds";
						//$whereexec = $whereclause . " and u.role_id = 4 and d.user_id = u.user_id and s.section_id=".$secrow['section_id']." and s.section_id=q.section_id and d.decl_completed = 'Y' and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = ".$dbyear;
						$whereexec = $whereclause . " and u.role_id = 4 and d.user_id = u.user_id and d.decl_completed = 'Y' and d.decl_id = ds.decl_id and ds.user_confirmed = 'N' and ds.section_id=".$secrow['section_id']." and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset2 = $row['usercount'];
								$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records2[]=$row2;
									}
								}
							} else {
	
								$dataset2 = 0;
							}
						}
						$records=array("Section Relevant - ".$dataset1 => $records1, "Section Not Relevant - ".$dataset2 => $records2);

						echo "data.setValue($i, 0, '".$secrow['section_name']."');\n";
				        echo "data.setValue($i, 1, $dataset1);\n";
				        echo "data.setValue($i, 2, $dataset2);\n";
				        $i++;
				        }
					}
					echo "var reportdata = '[".json_encode($records)."]';\n";
			        echo "var chart = new google.visualization.BarChart(document.getElementById('chart_div'));\n";
			        echo "chart.draw(data, {width: 650, height: 500, title: '$heading',vAxis: {title: 'Sections', titleTextStyle: {color: 'red'}}, hAxis: {title: 'Users', titleTextStyle: {color: 'red'}} });\n";
    			  	echo "google.visualization.events.addListener(chart, 'select', function() {
						showDashboard('$dbyear','$org','$subfilter',chart.getSelection(),0,0);
					});";

    			  	echo "}";
					echo "</script>\n";
				}else if ($subfilter == "Section Wise Status"){
					  echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>\n";
					  echo "<script type=\"text/javascript\">\n";
					  echo "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n";
				      echo "google.setOnLoadCallback(drawChart);\n";
				      echo "function drawChart() {\n";
				      	echo "var data = new google.visualization.DataTable();\n";
				        echo "data.addColumn('string', 'Sections');\n";
				        echo "data.addColumn('number', 'All responses best practice');\n";
				        echo "data.addColumn('number', 'One or more response not best practice');\n";
					
				        $r = mysql_query($sqlsec);
				        //echo "<br>SQL: ".$sqlsec."<br>";
				        if(!$r) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							$norows = mysql_num_rows($r);

				        echo "data.addRows($norows);\n";

				        $i = 0;
				        while ($secrow = mysql_fetch_array($r)){
				     	//Completed Successful
						$fromclause = " from users u,".$tbl_d.", declaration_sections ds";
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q, sections s where s.section_id=".$secrow['section_id']." and s.section_id=q.section_id and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 0 and YEAR( d.decl_started_on ) = ".$dbyear;
						//$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and ds.section_id=".$secrow['section_id']." and d.decl_id = ds.decl_id and ds.user_confirmed = 'Y' and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset1 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records1[]=$row2;
									}
								}
							} else {
	
								$dataset1 = 0;
							}
						}
	
						//Completed Unsuccessful
						$fromclause = " from users u, $tbl_d, $tbl_dd, answers a, questions q, sections s";
						//$fromclause = " from users u, $tbl_d, declaration_sections ds";
						$whereexec = $whereclause . " and u.role_id = 4 and d.user_id = u.user_id and s.section_id=".$secrow['section_id']." and s.section_id=q.section_id and d.decl_completed = 'Y' and a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id and YEAR( d.decl_started_on ) = ".$dbyear;
						//$whereexec = $whereclause . " and u.role_id = 4 and d.user_id = u.user_id and d.decl_completed = 'Y' and d.decl_id = ds.decl_id and ds.user_confirmed = 'N' and ds.section_id=".$secrow['section_id']." and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset2 = $row['usercount'];
								$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records2[]=$row2;
									}
								}
							} else {
	
								$dataset2 = 0;
							}
						}
						$records=array("Section Confirmance - ".$dataset1 => $records1, "Section Non Confirmance - ".$dataset2 => $records2);

						echo "data.setValue($i, 0, '".$secrow['section_name']."');\n";
				        echo "data.setValue($i, 1, $dataset1);\n";
				        echo "data.setValue($i, 2, $dataset2);\n";
				        $i++;
				        }
					}
					echo "var reportdata = '[".json_encode($records)."]';\n";
			        echo "var chart = new google.visualization.BarChart(document.getElementById('chart_div'));\n";
			        echo "chart.draw(data, {width: 650, height: 500, title: '$heading',vAxis: {title: 'Sections', titleTextStyle: {color: 'red'}}, hAxis: {title: 'Users', titleTextStyle: {color: 'red'}} });\n";
    			  	echo "google.visualization.events.addListener(chart, 'select', function() {
						showDashboard('$dbyear','$org','$subfilter',chart.getSelection(),0,0);
					});";

    			  	echo "}";
					echo "</script>\n";
				}else if ($subfilter == "Question Status"){
					$heading = $subfilter.": Section ".$secid. ", Q".$qid.", Org: ".$orgname.", Year:".$dbyear.".";
					$r = mysql_query($sqlsec);
					if(!$r) {
						$err=mysql_error();
						$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
					}else {
						$norows = mysql_num_rows($r);
						echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>"; 
						echo "<script type=\"text/javascript\"> ";
						echo "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});"; 
						echo "google.setOnLoadCallback(drawChart); ";
						echo "function drawChart() { ";
						echo "var data = new google.visualization.DataTable();"; 
						echo "data.addColumn('string', 'Question'); ";
						echo "data.addColumn('number', 'NoOfUsers');"; 
						echo "data.addRows($norows); ";
						$r = mysql_query($sqlsec);
				        //echo "<br>SQL: ".$sqlsec."<br>";
						
						$j=0;$k=0;
				        while ($secrow = mysql_fetch_array($r)){
					     	$fromclause = " from users u,$tbl_d";
							$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where q.question_id=".$secrow['question_id']." and a.answer='".mysql_real_escape_string($secrow['answer'])."' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 0 and YEAR( d.decl_started_on ) = ".$dbyear;
							$sqlexec = $sql . $fromclause . $whereexec;
							$sqldataexec = $sqldata . $fromclause . $whereexec;
							//echo "<br>SQL:".$sqlexec."<br>";
							$r1 = mysql_query($sqlexec);
							if(!$r1) {
								$err=mysql_error();
								$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
							}else {
								if ($row = mysql_fetch_array($r1)) {
									$dataset1 = $row['usercount'];
								} else {
									$dataset1 = 0;
								}
							        
								//echo "</br>J:".$j.", K:".$k.", Dataset:".$dataset1."\n";
								$val = addslashes("Q".$secrow['question_id']."-".$secrow['answer']);
								//echo "</br>Val:".$val;
								echo "data.setValue($k, 0, '".$val."');\n";
								echo "data.setValue($k, 1, $dataset1);\n";
					        	$k++;
							}
				        }
				        
						echo "var chart = new google.visualization.PieChart(document.getElementById('chart_div'));\n"; 
						echo "chart.draw(data, {width: 650, height: 350, title: '$heading'});\n";
						echo "google.visualization.events.addListener(chart, 'select', function() {
							showDashboard('$dbyear','$org','$subfilter',chart.getSelection(),'$qid','$secid');
						});";
						echo "}\n";
						echo "</script> ";
					}
				}else if ($subfilter == "Response Status"){
					  echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>\n";
					  echo "<script type=\"text/javascript\">\n";
					  echo "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n";
				      echo "google.setOnLoadCallback(drawChart);\n";
				      echo "function drawChart() {\n";
				      	echo "var data = new google.visualization.DataTable();\n";
				        echo "data.addColumn('string', 'Number of not relevant answers');\n";
				        echo "data.addColumn('number', 'Number Of Users');\n";

				        echo "data.addRows(4);\n";
				        					
				     	// 1 incorrect
						$fromclause = " from users u,$tbl_d";
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) = 1 and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset1 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records1[]=$row2;
									}
								}
							} else {
								$dataset1 = 0;
							}
						}
						
						// 2 - 5 incorrect
						$fromclause = " from users u,$tbl_d";
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 1 and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) <= 5 and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset2 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records2[]=$row2;
									}
								}
							} else {
								$dataset2 = 0;
							}
						}
					
						// 6 - 10
						$fromclause = " from users u,$tbl_d";
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 5 and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) <= 10 and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset3 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records3[]=$row2;
									}
								}
							} else {
								$dataset3 = 0;
							}
						}

						// >10 incorrect
						$fromclause = " from users u,$tbl_d";
						$whereexec = $whereclause . " and d.user_id = u.user_id and d.decl_completed = 'Y' and (select count(*) as count from $tbl_dd ,answers a, questions q where a.correct_result = 'N' and d.decl_id = dd.decl_id and dd.question_id = q.question_id and dd.ans_id = a.answer_id and q.question_id = a.question_id) > 10 and YEAR( d.decl_started_on ) = ".$dbyear;
						$sqlexec = $sql . $fromclause . $whereexec;
						$sqldataexec = $sqldata . $fromclause . $whereexec;
						//echo "<br>SQL:".$sqlexec."<br>";
						$r1 = mysql_query($sqlexec);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable to lookup declaration details at this time, please try again later. Error:".$err;
						}else {
							if ($row = mysql_fetch_array($r1)) {
								$dataset4 = $row['usercount'];
							$r2=mysql_query($sqldataexec);
								if(mysql_num_rows($r2))
								{
									while($row2=mysql_fetch_array($r2, MYSQL_ASSOC))
									{
										$records4[]=$row2;
									}
								}
							} else {
								$dataset4 = 0;
							}
						}						
	
						$records=array("1 - ".$dataset1 => $records1, "2 to 5 - ".$dataset2 => $records2, "6 to 10 - ".$dataset3 => $records3, "Morethan 10 - ".$dataset4 => $records4);

						echo "data.setValue(0, 0, '1');\n";
				        echo "data.setValue(0, 1, $dataset1);\n";
				        
				        echo "data.setValue(1, 0, '2 to 5');\n";
				        echo "data.setValue(1, 1, $dataset2);\n";
				        
				        echo "data.setValue(2, 0, '6 to 10');\n";
						echo "data.setValue(2, 1, $dataset3);\n";
						
						echo "data.setValue(3, 0, 'Morethan 10');\n";
						echo "data.setValue(3, 1, $dataset4);\n";
						
				    echo "var reportdata = '[".json_encode($records)."]';\n";
			        echo "var chart = new google.visualization.BarChart(document.getElementById('chart_div'));\n";
			        echo "chart.draw(data, {width: 650, height: 500, title: '$heading',vAxis: {title: 'No. of Not Relevant Responses', titleTextStyle: {color: 'red'}}, hAxis: {title: 'No. of Users', titleTextStyle: {color: 'red'}} });\n";
    			  	echo "google.visualization.events.addListener(chart, 'select', function() {
						showDashboard('$dbyear','$org','$subfilter',chart.getSelection(),0,0);
					});";

    			  	echo "}";
					echo "</script>\n";
					
				}
	}
?>