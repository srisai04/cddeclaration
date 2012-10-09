<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");

	if (isset($_REQUEST['incid'])) $incid=htmlspecialchars($_REQUEST['incid']);else $incid="";
	if (isset($_REQUEST['incident'])) $incident=htmlspecialchars($_REQUEST['incident']);else $incident="";
	if (isset($_REQUEST['emailids'])) $emailids=htmlspecialchars($_REQUEST['emailids']);else $emailids="";
	if (isset($_REQUEST['feedback'])) $feedback=htmlspecialchars($_REQUEST['feedback']);else $feedback="";
?>

<div id="divRHS">

<h1 class="green">Occurrence Feedback</h1>

<?php
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";
	$msg = "";
	
	if ($status == 1){
		$sql="insert into incidentresponse (resp_id, inc_id, response, response_by, responded_on) values (0,'$incid', '$feedback', '$sessionuserid', responded_on=now())";
		//print("SQL:".$sql);
		$r = mysql_query($sql);
		if(!$r) {
			$err=mysql_error();
			$msg = "Unable to update Occurrence at this time, please try again later. Error:".$err;
		}else{
			$msg = "Thank You. Your feedback has been submitted.";
			
			$sql="UPDATE incidents SET inc_status = 'R' where inc_id = '".$incid."'";
			//print("SQL:".$sql);
			$r = mysql_query($sql);
		}
	}
?>

<form name="form2" method="post">


		<table class="tblUsers">
	 	<tr>
			<th align="center"><b>Resp. Id</b></td>
	 		<th align="center"><b>Response</b></td>
	 		<th align="center"><b>Resp. by</b></td>
	 		<th align="center"><b>Resp. Date</b></td>
	 	</tr>
	 	<tr><td colspan="4"><hr /></td></tr>
	 	<?php 
			$sql = "SELECT *, DATE_FORMAT( `inc_raised_on` , '%d-%m-%Y' ) AS incdate FROM incidents i, incidentresponse ir where i.inc_id='".$incid."' and i.inc_id = ir.inc_id";
			//echo "SQL:".$sql;
			$r1 = mysql_query($sql);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable fetch Occurrence details, please try again later. Error:".$err;
			}else while($row = mysql_fetch_array($r1)){
				echo "<tr>";
						$respid = $row['resp_id'];
						echo "<td width=\"10%\" align=\"center\">".$row['resp_id']."</td>";
						echo "<td class=\"la\" width=\"10%\">".$row['response']."</td>";
						echo "<td width=\"10%\" align=\"center\">".$row['response_by']."</td>";
						echo "<td width=\"10%\" align=\"center\">".$row['incdate']."</td>";
				echo "</tr>";
	         }
	         $count = mysql_num_rows($r1);
	    
	          if ($count == 0) {
			  	echo "<td colspan=\"4\">There is no feedback for this Occurrence yet.</td>";
		  	  }
	         ?>
	        <tr><td colspan="4"><hr /></td></tr>
		</table>


<table class="tblForm">
	<tr>
		<td colspan="3" align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?><br />
		</td>
	</tr>
			<tr>
				 <td><label for="incindent">Occurrence:</label></td>
	                <td>
					<b><font color="blue"><?php 
						$sql = "SELECT * FROM incidents where inc_id='".$incid."'";
						//echo "SQL:".$sql;
						$r1 = mysql_query($sql);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable fetch Occurrence details, please try again later. Error:".$err;
						}else if ($row = mysql_fetch_array($r1)){
							$incident = $row['incident'];
						}
					
					echo "".$incid." - ".$incident."<br>";?></font></b>
					<input type="hidden" name="incid" value=<?php echo "$incid"; ?>>
                    </td>
			</tr>
			<tr>
				<td>
				<label for="feedback">Please enter your feedback:</label></td>
				<td>
				<textarea rows="3" cols="50" name="feedback"><?php echo $feedback; ?></textarea><font color="red">*</font></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="center" colspan="3">
					<input type="button" onclick="javascript:history.go(-1);" value="Back"/>
					<input type="button" onclick="return validateFeedback();" value="Submit Feedback"/>
				</td>
			</tr>

			<?php
			// Free the resources associated with the result set
			// This is done automatically at the end of the script
			@mysql_free_result($r);
			@mysql_close();
			?>

		</table>
		</form>

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