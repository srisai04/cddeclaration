<?php
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");
	$msg1 = "";
	$msg = "";

	if (isset($_REQUEST['archyear'])) $archyear = $_REQUEST['archyear']; else $archyear = "";
	if (isset($_REQUEST['org1'])) $org1 = $_REQUEST['org1']; else $org1 = "";
	if (isset($_REQUEST['user'])) $user = $_REQUEST['user']; else $user = "";	
	//if (isset($_REQUEST['qid'])) $qid = $_REQUEST['qid']; else $qid = "";
	if (isset($_REQUEST['status'])) $status = $_REQUEST['status']; else $status = "";

	if (isset($_SESSION['org_id'])) $sessionorgid=$_SESSION['org_id'];else $sessionorgid="";
	if (isset($_SESSION['role_id'])) $sessionroleid=$_SESSION['role_id'];else $sessionroleid="";
?>

<?php if ($sessionroleid != 1){?>
	<script type="text/javascript">	highlight_nav(7); </script>
<?php }else{?>
	<script type="text/javascript">	highlight_nav(8); </script>
<?php }?>

<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="js/validations.js"></script>
<script type="text/javascript" src="js/reportutils.js"></script>
	
<div id="divRHS">

	<h1 class="green">Archive Declarations</h1>

	<form name="formarchive" method="post">
		<table class="tblForm">
			<tr>
				<td colspan="3" align="center"><?php echo "<font color=\"red\">" . $msg1 . "</font>";?></td>
			</tr>
			<tr>
				<td>
			        <label for="archyear">Year:</label>
	                <select name="archyear">
			        <?php
					    // Generate Options
					    $thisYear = date('Y');
					    $startYear = ($thisYear - $yearRange);
					    foreach (range($thisYear, $startYear) as $year) {
						    $selected = "";
						    if($year == $archyear) { $selected = " selected"; }
						    print '<option value='. $year .' '. $selected . '>' . $year . '</option>';
					    }
			   		?>
	                </select><font color="red">*</font>
                   		<label for="org1">Organisation:</label>
			        	<select name="org1" onchange="reloadUsers();">
				          <?php
				           if ($_SESSION['role_id'] == 1){
				          	$sql = "SELECT * from organisations";
				           }else {
				          	$sql = "SELECT * from organisations where org_id ='".$sessionorgid."'";
				           }
							print("SQL1:".$sql);
							$r1 = mysql_query($sql);
							echo "<option value=\"0\">Select Organisation..</option>";
							if(!$r1){
								$msg = "Unable to retrieve organisation list.";
							}else {
								  while($row = mysql_fetch_array($r1)){
								  	if($org1 == $row['org_id']){
								  		echo "<option value=\"". $row['org_id'] . "\" selected>". $row['organisation'] . "</option>";
								  	}else{
								  		echo "<option value=\"". $row['org_id'] . "\">". $row['organisation'] . "</option>";
								  	}
								  }
							}
						   ?>
				       </select><font color="red">*</font>
                   		<label for="user"> User:</label>
			        	<select name="user">
				          <?php
				           if ($_SESSION['role_id'] == 1){
					           	if ($org1 != null && $org1 != 0)$sql = "SELECT * from users where role_id = 4 AND org_id=".$org1;
					          	else $sql = "SELECT * from users where role_id=4";
				           }else {
				          	$sql = "SELECT * from users where role_id=4 and org_id ='".$sessionorgid."'";
				           }
							//print("SQL1:".$sql);
							$r1 = mysql_query($sql);
							echo "<option value=\"0\">Select User..</option>";
							if(!$r1){
								$msg = "Unable to retrieve user list.";
							}else {
								  while($row = mysql_fetch_array($r1)){
								  	if($user == $row['user_id']){
								  		echo "<option value=\"". $row['user_id'] . "\" selected>". $row['user_id'] . " - " . $row['user_fname'] . " " . $row['user_lname'] . "</option>";
								  	}else{
								  		echo "<option value=\"". $row['user_id'] . "\">". $row['user_id'] . " - " . $row['user_fname'] . " " . $row['user_lname'] . "</option>";
								  	}
								  }
							}
						   ?>
				       </select><font color="red">*</font>
					<input type="button" onclick="return validateArchive();" value="Archive"/>
				</td>
			</tr>
			<tr>
			<td colspan="4">
				<?php if ($status == 2){
				  //Archive Data
				  include("archive.php");
				}?>
			</td></tr>
			<tr><td colspan="4"><?php echo $msg;?></td></tr>
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