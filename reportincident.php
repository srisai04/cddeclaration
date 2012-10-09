<?php
	$anonym = "";
	if (isset($_REQUEST['anonym']) && $_REQUEST['anonym'] == 1){
			$anonym = $_REQUEST['anonym'];
			require "setpath.php";
			require "common.php";
			require "properties.php";
			require "connect.php";
			require "Smarty.php";
			//Header
			$smarty->display("header.tpl");
		}else {
			require ('inc/include.php'); 
			//Header
			$smarty->display("header.tpl");
			//Left Navigation
			$smarty->display("leftnav.tpl");
		}
		
		if (isset($_SESSION['org_id'])) $sessionorgid = $_SESSION['org_id'];else $sessionorgid=0;
		if (isset($_SESSION['emailid'])) $sessionemail=$_SESSION['emailid'];else {$sessionemail="";}
		
		if (isset($_REQUEST['org']))$org=htmlspecialchars($_REQUEST['org']);else $org="";
?>
<?php if (isset($_SESSION['userid'])){
		if ($sessionroleid == 1){
			echo "<script type=\"text/javascript\">	highlight_nav(6); </script>";
		} else if ($sessionroleid == 5){
			echo "<script type=\"text/javascript\">	highlight_nav(3); </script>";
		}else{
			echo "<script type=\"text/javascript\">	highlight_nav(5); </script>";
		}
 }?>
<?php
	if (isset($_POST['incident'])) $incident=htmlspecialchars($_POST['incident']);else $incident="";
	if (isset($_POST['email'])) $email=htmlspecialchars($_POST['email']);else $email="";
	if (isset($_REQUEST['desbody'])) $desbody=htmlspecialchars($_REQUEST['desbody']);else $desbody="";	
	if (isset($_REQUEST['accofficer'])) $accofficer=htmlspecialchars($_REQUEST['accofficer']);else $accofficer="";
	if (isset($_REQUEST['lin'])) $lin=htmlspecialchars($_REQUEST['lin']);else $lin="";
	if (isset($_REQUEST['linoff'])) $linoff=htmlspecialchars($_REQUEST['linoff']);else $linoff="";
	if (isset($_REQUEST['occdate'])) $occdate=htmlspecialchars($_REQUEST['occdate']);else $occdate="";
	if (isset($_REQUEST['response'])) $response=htmlspecialchars($_REQUEST['response']);else $response="";

	/*ALTER TABLE `incidents` ADD `desbody` VARCHAR( 100 ) NULL ,
	ADD `accofficer` VARCHAR( 100 ) NULL ,
	ADD `lin` VARCHAR( 100 ) NULL ,
	ADD `linoff` VARCHAR( 100 ) NULL */
	
	//echo "email:".$_SESSION['emailid'];
		
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";
	
	if (isset($_SESSION['userid'])){
		$userid = $_SESSION['userid'];
		$email = $sessionemail;
		$anon = "N";
	}else {
		$userid = 0;
		$anon = "Y";
	}
	//print("Userid:".$userid);
	$msg = "";
	

	
	if ($status == 1){
		$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
		$sql = "SHOW TABLE STATUS LIKE 'incidents'";
		//print("SQL2:".$sql."\r");
		$r1 = mysql_query($sql);
		$row = mysql_fetch_assoc($r1);
		$incid = $row['Auto_increment'];
		$dateformat = substr($occdate,6,4) . substr($occdate,3,2) . substr($occdate,0,2);
		$sql="INSERT INTO incidents (inc_id,incident,user_id,org_id,inc_raised_on,user_anon,anon_email,desbody,accofficer,lin,linoff) values (0,'$incident','$userid','$org','$dateformat','$anon','$email','$desbody','$accofficer','$lin','$linoff')";
		//print("SQL:".$sql);
		$r = mysql_query($sql);
		if(!$r) {
			$err=mysql_error();
			$msg = "Unable to report Occurrance at this time, please try again later. Error:".$err;
		}else{
			$sql = "INSERT INTO incidentresponse (resp_id,inc_id,response) VALUES (0,'$incid','$response')";
			$r1 = mysql_query($sql);
			//print("SQL:".$sql);			
			$msg = "Thank you for reporting an Occurrence, the Administrator will get back to you as soon as possible.";
		}
		$r1=mysql_query("COMMIT");//write data & unlock transaction
	}
?>

<div id="divRHS">
  <!-- Display Area -->
  <h1 class="green">Report an Occurrence</h1>
  <form name="form2" method="post" action="reportincident.php">
    <table class="tblForm">
      <tr>
        <td colspan="2"><?php echo "<font color=\"red\">" . $msg . "</font>";?><br />
          <?php if (!isset($_SESSION['userid'])) echo "Go To <a href=\"index.php\">Login</a>";?></td>
      </tr>
      <tr>
        <th width="150"><label for="org">Organisation:</label></th>
        <td><select name="org" class="medium">
            <?php 
				           if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 0){
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
          </select>
          <font color="red">*</font></td>
      </tr>
      <tr>
          <td style="width: 130px;"><label for="desbody">Name of Designated Body:</label></td>
          <td><input name="desbody" type="text" class="medium" value="<?php echo "$desbody"; ?>" size="30"/></td>
      </tr>
      <tr>
          <td style="width: 130px;"><label for="accofficer">Name of Accountable Officer:</label></td>
          <td><input name="accofficer" type="text" class="medium" value="<?php echo "$accofficer"; ?>" size="30"/></td>
      </tr>
      <tr>
          <td style="width: 130px;"><label for="lin">Name of Local Intelligence Network:</label></td>
          <td><input name="lin" type="text" class="medium" value="<?php echo "$lin"; ?>" size="30"/></td>
      </tr>
      <tr>
          <td style="width: 130px;"><label for="linoff">Name of LIN Officer:</label></td>
          <td><input name="linoff" type="text" class="medium" value="<?php echo "$linoff"; ?>" size="30"/></td>
      </tr>
      <tr>
        <th valign="top"><input name="anonym" type="hidden" value="<?php echo "$anonym"; ?>"/>
          <label for="incident">Description of Concern:</label></th>
        <td><textarea rows="3" cols="50" name="incident"><?php echo $incident; ?></textarea>
        <font color="red">*</font></td>
      </tr>
      <tr>
          <td style="width: 130px;"><label for="occdate">Occurrance Date:</label></td>
          <td>
          	<?php
          		$formname = "form2";
				$inputname = "occdate";
		        $value = $occdate;
				include ('mycalendar.php');
			?>
          </td>
      </tr> 
      <tr>
          <td style="width: 130px;"><label for="response">Action Taken:</label></td>
          <td><input name="response" type="text" class="medium" value="<?php echo "$response"; ?>" size="30"/></td>
      </tr>
      <?php if ($sessionorgid != 0){ $show = "hidden"; }else $show = "text"?>
      <tr>
        <td><?php if ($sessionorgid == 0){?>
          <label for="email">E-Mail ID:</label></td>
        <?php }?>
        <td><?php echo "<input type='$show' name=\"email\" size=\"30\" value='$email'/>";?></td>
      </tr>
      <tr>
        <td colspan="2" class="buttons"><hr /></td>
      </tr>
      <tr>
        <td colspan="2" class="buttons"><input type="button" onclick="return validateIncident();" value="Report Occurrence"></td>
      </tr>
    </table>
  </form>
  <?php if (isset($sessionuserid) && $sessionuserid != 0){?>
  <table class="tblUsers">
    <tr>
      <th>Id</th>
      <th>Description</th>
      <th>Date</th>
      <th>Org. Id</th>
      <th>Acc. Officer</th>
      <th>LIN</th>
      <th>Status</th>
    </tr>
    <tr>
      <td colspan="7"><hr /></td>
    </tr>
    <?php 
		$sql = "SELECT *, DATE_FORMAT( `inc_raised_on` , '%d-%m-%Y' ) AS incdate FROM incidents where user_id='".$sessionuserid."'";
		//echo "SQL:".$sql;
		$r1 = mysql_query($sql);
		if(!$r1) {
			$err=mysql_error();
			$msg = "Unable fetch Occurrence details, please try again later. Error:".$err;
		}else while($row = mysql_fetch_array($r1)){
			echo "<tr>";
					echo "<td>".$row['inc_id']."</td>";
					echo "<td class=\"la\">".$row['incident']."</td>";
					echo "<td>".$row['incdate']."</td>";
					echo "<td>".$row['org_id']."</td>";
					echo "<td>".$row['accofficer']."</td>";
					echo "<td>".$row['lin']."</td>";
					echo "<td>Submitted</td>"; //.$row['inc_status'].
			echo "</tr>";
         }
         $count = mysql_num_rows($r1);
    
          if ($count == 0) {
		  	echo "<td colspan=\"7\">You have not raised any Occurrences yet.</td>";
	  	  }
         ?>
    <tr>
      <td colspan="7"><hr /></td>
    </tr>
  </table>
  <?php } ?>
  <?php
		// Free the resources associated with the result set
		// This is done automatically at the end of the script
		@mysql_free_result($r);
		@mysql_close();
	?>
  <!--  Display Area -->
</div>
<!-- END OF #divRHS -->
<div class="clear">
  <!-- -->
</div>
<?php if (!isset($_REQUEST['anonym'])){?>
</div>
<!-- END OF #divFauxColumns -->
<?php }?>
<?php $smarty->display("footer.tpl"); ?>
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>