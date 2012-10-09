<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");
	
	if (isset($_REQUEST['subject'])) $subject = $_REQUEST['subject']; else $subject = "";
	if (isset($_REQUEST['message'])) $message=($_REQUEST['message']);else $message="";
	
	if (isset($_REQUEST['org'])) $org = $_REQUEST['org']; else $org = "";
	if (isset($_REQUEST['role'])) $role = $_REQUEST['role']; else $role = "";
	if (isset($_REQUEST['subfilter'])) $subfilter = $_REQUEST['subfilter']; else $subfilter = "";
	
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";

	if (isset($_SESSION['org_id'])) $sessionorgid=$_SESSION['org_id'];else $sessionorgid="";
	if (isset($_SESSION['role_id'])) $sessionroleid=$_SESSION['role_id'];else $sessionroleid="";

	$msg = "";
	
	$subfilterval = array('default','Not Started','Started','Completed', 'Newly Imported Users');
	
	if ($status == 1){ //Send Notification/message by e-mail
			ini_set('max_execution_time', 120);
			$sql = "SELECT DISTINCT u.user_id, u.email";
			$fromclause = " from users u";
			$whereclause = " where active = 1";
			//echo "Org, Role:".$org.", ".$role;
			
			if ($sessionroleid != 1 && ($org == 0 || $role == 0)){
				if ($org == 0) $whereclause = $whereclause . " and org_id='".$sessionorgid."'"; else $sql = $sql . " and org_id='".$org."'";
				if ($role == 0) $whereclause = $whereclause . " and role_id >= '".$sessionroleid."'"; else $sql = $sql . " and role_id='".$role."'";
			}else {
				if ($org != 0)$whereclause = $whereclause . " and org_id='".$org."'";
				if ($role != 0)$whereclause = $whereclause . " and role_id='".$role."'";
			}
			
			if ($subfilter != 'default'){
				if ($subfilter == 'Not Started'){
					$fromclause = $fromclause . " ,declarations d";
					$whereclause = $whereclause . " and u.role_id != 1 and (SELECT count(decl_id) as count FROM declarations where u.user_id = declarations.user_id and YEAR( decl_started_on ) = YEAR( now( ) ) ) = 0";
				}else if ($subfilter == 'Started'){
					 $fromclause = $fromclause . " ,declarations d";
					 $whereclause = $whereclause . " and d.user_id=u.user_id and d.decl_completed='N' and YEAR(d.decl_started_on)=YEAR(now())"; 
				}else if ($subfilter == 'Completed'){
					$fromclause = $fromclause . " ,declarations d";
					$whereclause = $whereclause . " and d.user_id=u.user_id and d.decl_completed='Y' and YEAR(d.decl_started_on)=YEAR(now())";
				}else if ($subfilter == 'Newly Imported Users'){
					$whereclause = $whereclause . " and imported=1 and user_password = ''";
				}
			}
			
			$sqlexec = $sql . $fromclause . $whereclause;
						
			$emailids = "";
			//echo "SQL:".$sqlexec."<br>";
			$r1 = mysql_query($sqlexec);
			
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to lookup user details at this time, please try again later. Error:".$err;
			}else {
				while($row = mysql_fetch_array($r1)) {
					$emailids = $emailids. $row['email'] . ", ";
					if ($subfilter == 'Newly Imported Users'){
						$userid = $row['user_id'];
						$emailid = $row['email'];
						$pwd = rand(1000,9000);
						//echo "New Password:".$pwd."\r\n";
						
						if($emailid == null || $emailid == '') {
							$msg = "Empty email id, please correct and try again later";
						}else{
							 //$subject = "Your CD declaration Account";
							 $body = $message ."\r Your e-mail id: ".$row['email']." and Password:".$pwd.". Please change your password at ".$resetpwd.".";
							 $headers = "From: ".$adminmailid."\r\n" ."X-Mailer: php";
							 $headers .= "Bcc: ".$emailid. "\r\n";
							 //echo "Sub, msg:".$subject.",".$body."<br><br>";
							 
							try{
								 if (mail($adminmailid, $subject, $body, $headers)) {
								    $msg = "Message sent successfully to the following users: ".trim($emailids,",");
								    $sql = "UPDATE users set user_password='".sha1($pwd)."' where user_id='".$userid."'";
									//print ("SQL:".$sql);
									$r = mysql_query($sql);
								  } else {
								    $msg = "Failed to send mail at this time, please try again later.";
								  }
							 }catch(Exception $e){
							 	$msg = "Unable to send mail at this time, please try again later. ". $e->getMessage();
							 	//echo "Unable to send mail at this time, please try again later. ". $e->getMessage();
							 }
						}
						
					}
				}
				if (empty($emailids) || $emailids == "") $msg = "No users found for the selected criteria.";
			}

			if ($subfilter != 'Newly Imported Users'){
				$emailids = trim($emailids,", ");
				//echo "Mail-IDs:".$emailids."<br>";
				
				//Deliver e-mail
				 //$subject = "CD Declaration Notification";
				 $body = $message;
				 $headers = "From: ".$adminmailid."\r\n" ."X-Mailer: php";
				 $headers .= "Bcc: ".$emailids. "\r\n";
				 
				 $msg = "Message sent successfully to the following users:".$emailids;
				 if (empty($emailids) || $emailids == ""){
				 	$msg = "No users found for the selected criteria.";
				 }else if (mail($adminmailid, $subject, $body, $headers)) {
				    $msg = "Message sent successfully for the following users:".$emailids;
				 } else {
				    $msg = "Unable to send mail at this time, please try again later.";
				 }
			}
			 
	}
?>
<link href="_css/main_stylesheet.css" rel="stylesheet" type="text/css" />

<div id="divRHS">
  <?php if ($sessionroleid != 1){?>
  <script type="text/javascript">	highlight_nav(6); </script>
  <?php }else{?>
  <script type="text/javascript">	highlight_nav(7); </script>
  <?php }?>
  <h1 class="green">Send Notifications/Messages</h1>
  <form name="form2" method="post" action="notifications.php">
    <table class="tblForm">
      <tr>
        <td colspan="3"><?php echo "<font color=\"red\">" . $msg . "</font>";?></td>
      </tr>
      <tr>
        <td><label for="org">Organisation:</label>
          <font color="red"></font><br/></td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><label for="role">Website Access:</label>
          <font color="red">&nbsp;</font></td>
        <td><select name="role">
            <?php 
				          	if ($sessionroleid == 1){
				          		$sql = "SELECT * from roles";
				          	}else if($sessionroleid == 2){
				          		$sql = "SELECT * from roles where role_id='2' or role_id = '3' or role_id='4'";
				          	}else{
				          		$sql = "SELECT * from roles where role_id='4'";
				          	}
				          		
							$r1 = mysql_query($sql);
							echo "<option value=\"0\">Select Website Access..</option>";
							if(!$r1){
								$err = mysql_error();
								$msg = "Unable to retrieve role list:".$err;
							}else {
								  while($row = mysql_fetch_array($r1)){
								  	if($role == $row['role_id']){
								  		echo "<option value=\"". $row['role_id'] . "\" selected>". $row['role_desc'] . "</option>";
								  	}else{
								  		echo "<option value=\"". $row['role_id'] . "\">". $row['role_desc'] . "</option>";
								  	}
								  }
							}
						   ?>
          </select></td>
      </tr>
      <tr>
        <td><label for="subfilter3">Users who have:</label></td>
        <td><select name="subfilter" onchange="showMsg();">
            <?php 
			          	foreach ($subfilterval as $i){
							if ($i == "default") $disp = "Select Declaration Status..";
							else $disp = $i;
							
			          		if ($subfilter == $i){
			          			echo "<option value=\"". $i . "\" selected>". $disp . "</option>";
			          		}else{
			          			echo "<option value=\"". $i . "\">". $disp . "</option>";
			          		}
			          	}
					   ?>
          </select></td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      <tr>
        <td><label for="subject">Subject:</label></td>
        <td><input name="subject" type="text" class="medium" value='<?php echo $subject;?>' size="30"/>
          <font color="red">*</font></td>
      </tr>
      <tr>
        <td><label for="message">Message:</label></td>
        <td><textarea name="message" cols="50" rows="3" class="message"><?php echo $message; ?></textarea>
          <font color="red">*</font></td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      <tr>
        <td colspan="2" class="buttons"><input type ="button" onclick="return validateNotification();" value="Send Message">
        </button></td>
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
</div>
<!-- END OF #divRHS -->
<div class="clear">
  <!-- -->
</div>
</div>
<!-- END OF #divFauxColumns -->
<?php $smarty->display("footer.tpl"); ?>
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>