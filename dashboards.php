<?php
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");
	$msg1 = "";

	if (isset($_REQUEST['archyear'])) $archyear = $_REQUEST['archyear']; else $archyear = "";
	if (isset($_REQUEST['org1'])) $org1 = $_REQUEST['org1']; else $org1 = "";
	if (isset($_REQUEST['user'])) $user = $_REQUEST['user']; else $user = "";	
	if (isset($_REQUEST['qid'])) $qid = $_REQUEST['qid']; else $qid = "";
	if (isset($_REQUEST['secid'])) $secid = $_REQUEST['secid']; else $secid = "";
	//echo "secid:".$secid;
?>

<?php if ($sessionroleid != 1){?>
	<script type="text/javascript">	highlight_nav(4); </script>
<?php }else{?>
	<script type="text/javascript">	highlight_nav(5); </script>
<?php }?>

	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/validations.js"></script>
	<script type="text/javascript" src="js/reportutils.js"></script>
	
<div id="divRHS">

<h1 class="green">Declaration Dashboards</h1>

<form name="userform" method="post">
	<input type="hidden" name="org"/>
	<input type="hidden" name="subfilter"/>
	<input type="hidden" name="year"/>
	<input type="hidden" name="selection"/>
	<input type="hidden" name="qid"/>
	<input type="hidden" name="secid"/>
	<?php include("charts.php"); ?>
</form>

<form name="form2" method="post">
<table class="tblForm">
	<tr>
		<td colspan="3" align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?></td>
	</tr>
	<tr>
		<td>
	        <label for="dbyear">Year:</label>
	         <select name="dbyear">
		        <?php
				    // Generate Options
				    $thisYear = date('Y');
				    $startYear = ($thisYear - $yearRange);
				    foreach (range($thisYear, $startYear) as $year) {
					    $selected = "";
					    if($year == $dbyear) { $selected = " selected"; }
					    print '<option' . $selected . '>' . $year . '</option>';
					    //print '<option value='. $year .' '. $selected . '>' . $year . '</option>';
				    }
		   		?>
            </select><font color="red">*</font>
			<label for="org">Org.:</label>
        	<select name="org">
	          <?php
	           if ($_SESSION['role_id'] == 1){
	          	$sql = "SELECT * from organisations";
	           }else {
	          	$sql = "SELECT * from organisations where org_id ='".$sessionorgid."'";
	           }
			//print("SQL1:".$sql);
			$r1 = mysql_query($sql);
			echo "<option value=\"0\">Select Organisation..</option>";
			if(!$r1){
				$msg = "Unable to retrieve organisation list.";
			}else {
				  while($row = mysql_fetch_array($r1)){
				  	if($org == $row['org_id']){
				  		echo "<option value=\"". $row['org_id'] . "\" selected>". $row['organisation'] . "</option>";
				  	}else{
				  		echo "<option value=\"". $row['org_id'] . "\">". $row['organisation'] . "</option>";
				  	}
				  }
			}
		   ?>
	       </select><font color="red"></font>
	        <label for="subfilter">Report:</label>
                <select name="subfilter" onchange="populateQuestions();">
		        <?php
		          foreach ($subfilterval as $i){
					if ($i == "default") $disp = "Select Report..";
					else $disp = $i;

			          if ($subfilter == $i){
			          	echo "<option value=\"". $i . "\" selected>". $disp . "</option>";
			          }else{
			          	echo "<option value=\"". $i . "\">". $disp . "</option>";
			          }
		          }
		   		?>
                </select>

                <?php if ($subfilter == "Question Status"){
                			echo "<input type=\"hidden\" name=\"secid\" value=\"1\"/>";
                	        echo "<label for=qid>Q:</label>";
        					echo "<select name=\"qid\" onchange=\"viewQuestion();\">";
                			$sql = "SELECT q.question_id, q.question, s.section_code, s.section_id FROM questions q, sections s WHERE q.section_id = s.section_id";
                			$r1 = mysql_query($sql);
							//echo "<option value=\"0\">Select Question..</option>";
							if(!$r1){
								$msg = "Unable to retrieve question list.";
							}else {
								  $qno = 0;
								  $sno = 1;
								  while($row = mysql_fetch_array($r1)){
								  	if ($sno != $row['section_id']){
								  		$sno = $row['section_id'];
								  		$qno = 1;
								  	}else {
								  		$sno = $row['section_id'];
								  		$qno = $qno + 1;
								  	}
								  	if($qid == $row['question_id']){
								  		echo "<option value=\"". $row['question_id'] . "\" selected> Section ". $row['section_code'] ." - ".$qno."</option>";
								  	}else{
								  		echo "<option value=\"". $row['question_id'] . "\"> Section ". $row['section_code'] ." - ".$qno . "</option>";
								  	}
								  }
							}
							echo "</select>";
                }?>
                <font color="red">*</font>
                <?php if ($subfilter == "Question Status" && $qid != null && $qid != 0){
                			$sql = "SELECT q.question_id, q.question, s.section_code, a.answer FROM questions q, sections s, answers a WHERE q.section_id = s.section_id and q.question_id = a.question_id and q.question_id=".$qid;
                			$r1 = mysql_query($sql);
							if(!$r1){
								$msg = "Unable to retrieve question.";
							}else {
								  $i=0;
								  while($row = mysql_fetch_array($r1)){
								  	if ($i == 0){
								  		echo "</br></br>".$row['question']."</br>";
								  		$secid = $row['section_code'];
								  		echo "<input type=\"hidden\" name=\"secid\" value=\"".$row['section_code']."\"/>";
								  	}
								  	$i++;
								  	echo "".$i.")".$row['answer']. " ";
								  }
								  echo "</br></br>";
							}
                } ?>
                
             <input type="button" onclick="return validateDashboard();" value="Show Dashboard"/>
             </td>
            </tr>
            <?php if ($status == 1){?>
			<tr>
				<td>
				<br/>
					<div id="chart_div" style="border:1px solid black;"></div>
					<div id="chart_div_actions" align="right">
					<a href="javascript:printChart();"><img src="_images/print.jpeg" width="20" height="20" alt="Print Chart"/></a>
					<!-- a href="javascript://" onclick="javascript:printChart();"> Print Chart </a>&nbsp;&nbsp;&nbsp;-->
					<!-- a href="javascript://" onclick="javascript:downloadChartData();return false;"> Download Data </a-->
					</div>

				</td>
			</tr>
			<?php }?>
	</table>
	</form>

	<?php
		// Free the resources associated with the result set
		// This is done automatically at the end of the script
		@mysql_free_result($r);
		@mysql_close();
	?>
	
   <!-- Display Area -->

	</div> <!-- END OF #divRHS -->

	<div class="clear"><!-- --></div>

	</div> <!-- END OF #divFauxColumns -->

	<?php $smarty->display("footer.tpl"); ?>

		</div> <!-- END OF #divPage -->

		<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>