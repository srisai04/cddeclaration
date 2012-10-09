<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");
?>

<div id="divRHS">
  <?php if ($sessionroleid == 5){?>
  <script type="text/javascript">highlight_nav(3);</script>
  <?php }else if ($sessionroleid != 1){?>
  <script type="text/javascript">highlight_nav(5);</script>
  <?php }else{?>
  <script type="text/javascript">highlight_nav(6);</script>
  <?php }?>
  <h1 class="green">View Occurrences</h1>
  <?php
		$sessionorgid = $_SESSION['org_id'];
		$sessionroleid = $_SESSION['role_id'];
		
		if (isset($_REQUEST['org']))$org=htmlspecialchars($_REQUEST['org']);else $org="";
		if (isset($_REQUEST['fromdate']))$fromdate=htmlspecialchars($_REQUEST['fromdate']);else $fromdate="";
		if (isset($_REQUEST['todate']))$todate=htmlspecialchars($_REQUEST['todate']);else $todate="";
		
		if (isset($_REQUEST['status']))$status=htmlspecialchars($_REQUEST['status']);else $status="";
		$msg = "";
?>

  <form name="form3" method="post">
	  <div class="divFilter">
	    <input type="button"  onclick="return newIncident();" value="Create New Occurrence" />
	  </div>
  </form>

    <table class="tblForm">
    <form name="form2">
      <tr>
        <td colspan="5" align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?></td>
      </tr>
      <tr>
        <td style="width: 100px;"><label for="org">Organisation: </label></td>
        <td><select name="org">
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
          </select></td>
        
      </tr>
      <tr>
        <td>
			<?php 
				$formname = "form2";
				echo "From Date:";
				$inputname = "fromdate";
			?>
		</td>
	     <td colspan="4">
	        <?php 
		        $value = $fromdate;
				include ('mycalendar.php');
				echo "  To Date:";
				$inputname = "todate";
				$value = $todate;
				include ('mycalendar.php');
			?>
		</td>
        <td><input name="status" type="hidden" value="1"/><input type="button" onclick="return searchIncidents();" value="Search" /></td>
      </tr>
      <tr>
        <td colspan="7"><hr /></td>
      </tr>
    </table>
    <table class="tblUsers">
      <?php
	  echo "<tr>
	  <th>Id</th>";
		echo "<th>Description</th>";
					echo "<th> User</th>";
					echo "<th> Org.</th>";
					echo "<th> Date</th>";
					echo "<th> Acc. Officer</th>";
					echo "<th> LIN</th>";
					echo "<th> Status</th></tr>";
					if ($status == 1){//Search
						$sql = "SELECT *, DATE_FORMAT( `inc_raised_on` , '%d-%m-%Y' ) AS incdate FROM incidents";
						if ($fromdate != null && $fromdate != "" && $todate != null && $todate != ""){
							$sfdate = substr($fromdate,6,4) ."-". substr($fromdate,3,2) ."-". substr($fromdate,0,2);
							$stdate = substr($todate,6,4) ."-". substr($todate,3,2) ."-". substr($todate,0,2);
							$sql = $sql . " WHERE DATE( `inc_raised_on` ) BETWEEN '".$sfdate."' AND '".$stdate."'";
						}
						
						if ($org != 0){
							$sql = $sql . " AND org_id='".$org."'"; 
						}else if ($sessionroleid != 1 && $org == 0){
							$sql = $sql . " AND org_id='".$sessionorgid."'"; 
						}
						
						$sql = $sql . " ORDER BY inc_raised_on DESC";
						//print("SQL:".$sql."\r");
						$r1 = mysql_query($sql);
						if(!$r1) {
							$err=mysql_error();
							$msg = "Unable fetch Occurrence list at this time, please try again later. Error:".$err;
						}else{
							$count=0;
							while($row = mysql_fetch_array($r1)){
							if ($count %2) echo "<tr>";
							else echo "<tr class=\"alt\">";
									$inc = $row['inc_id'];
									if ($sessionroleid == 5){
										echo "<td width=\"10%\" align=\"center\">".$row['inc_id']."</td>";
									}else{
										echo "<td width=\"10%\" align=\"center\"><a href=\"feedback.php?incid=".$inc."\">".$row['inc_id']."</a></td>";
									}
									echo "<td width=\"30%\" class=\"la\">".$row['incident']."</td>";
									echo "<td width=\"10%\" align=\"center\">".$row['user_id']."</td>";
									echo "<td width=\"10%\" align=\"center\">".$row['org_id']."</td>";
									echo "<td width=\"20%\" align=\"left\">".$row['incdate']."</td>";
									echo "<td width=\"10%\" align=\"center\">".$row['accofficer']."</td>";
									echo "<td width=\"10%\" align=\"center\">".$row['lin']."</td>";
									echo "<td width=\"10%\" align=\"center\">".$row['inc_status']."</td>";
		                	echo "</tr>";
		                	$count++;
							}
						}
						
						if ($count == 0) $msg = "No Occurrences found. Please choose the date range and search.";
						echo "<tr><td colspan=\"9\">".$msg."</td></tr>";
						
						echo "<tr><td colspan=\"9\"><hr /></td></tr>";
						echo "<tr class=\"alt\"><td colspan=\"7\" align=\"center\">".
							"<input type=\"button\"  onclick=\"return iexportCSV('export');\" value=\"Export Occurrences\" />".
							"</td></tr>";
					}
					echo "</form>";
					
					  if (!isset($status) || $status != 1) {
					  	$msg = "Please choose From and To date and Search the occurrences.";
						echo "<tr><td colspan=\"9\">".$msg."</td></tr>";
					  }
					  echo "<tr><td colspan=\"9\"><hr /></td></tr>";
					  echo "<tr><td colspan=\"9\" class=\"la\">";
					  echo "<form name=\"form4\" method=\"post\" enctype=\"multipart/form-data\">";
					  echo "<div class=\"divFilter\">";
						    echo "Occurrences: <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\" />".
	          				"<input name=\"importfile\" type=\"file\" class=\"buttons\"/>".
	          				"<input type=\"button\" onclick=\"return iexportCSV('import')\" value=\"Upload Querterly Report\"/>";
					  echo "</div></form></td></tr>";
					echo "<tr><td colspan=\"9\"><hr /></td></tr>";	
					
					
					if ($status == 2){//Import Occurrences
						 $fname = $_FILES['importfile']['name'];
						 //Move file to server
						$tempname = $_FILES['importfile']['tmp_name'];
						$target_path = IMPORT_PATH . $fname;
						//print "Moving file";
						if(move_uploaded_file($tempname, $target_path)){
							//print("File to import:".$target_path."<br>");
							$handle = fopen($target_path, "r");
							//print("Handle:".$handle);
							$firstrow = 1;
							if ($handle != null){
								//do not load header - leave first row
								while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
								{

									echo "<tr><td colspan=\"7\" class=\"la\">";
									if ($firstrow != 1){
										$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
										$sql = "SHOW TABLE STATUS LIKE 'incidents'";
										//print("SQL2:".$sql."\r");
										$r1 = mysql_query($sql);
										$row = mysql_fetch_assoc($r1);
										$incid = $row['Auto_increment'];										
										$sql = "INSERT INTO incidents(inc_id,incident,inc_raised_on,user_id,org_id,user_anon,inc_status,anon_email,desbody,accofficer,lin,linoff) VALUES ".
										  "(0,'".trim($data[1],"'")."','".trim($data[2],"'")."','".trim($data[3],"'")."','".trim($data[4],"'")."','".trim($data[5],"'")."','".trim($data[6],"'")."','".trim($data[7],"'")."','".trim($data[8],"'")."','".trim($data[9],"'")."','".trim($data[10],"'")."','".trim($data[11],"'")."')";
										//print("SQL:".$sql."<br>");
										$r1 = mysql_query($sql); //or die(mysql_error());
										if(!$r1){
											echo "<br> Unable to execute query:'$sql'";
										}else{
											if ($data[12] != null && $data[12] != ""){
												$resp = trim($data[12],"'");
												$sql = "INSERT INTO incidentresponse (resp_id,inc_id,response) VALUES (0,'$incid','$resp')";
												//print("SQL2:".$sql."\r");
												$r1 = mysql_query($sql);
											}
											echo "<font color=\"green\">Occurrence Record Imported: Occurrence:". $data[0]. " - ". $data[1]. "</font>";
										}
										$r1=mysql_query("COMMIT");//write data & unlock transaction
									}//First row check
									$firstrow = $firstrow + 1;
									echo "</td></tr>";
								 } //while
								}
								fclose($handle);
							
							//print("target:".$target_path);
							if (@unlink($target_path)){
								//print("Temporary file deleted.");
							}else{
								//print("Unable to delete temporary file.");
							}
						}
					}
		  		?>
    </table>
  <!-- Display Area -->
</div>	<!-- END OF #divRHS -->
<div class="clear"> <!-- --> </div>
</div> <!-- END OF #divFauxColumns -->
<?php $smarty->display("footer.tpl"); ?>
</div> <!-- END OF #divPage -->
<div id="divPageBottom">  <!-- --> </div>
</div>
</body>
</html>