<?php require("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	//$smarty->display('leftnav.tpl');
	$sessionorgid = $_SESSION['org_id'];
	$sessionroleid = $_SESSION['role_id'];
	$sessionuserid = $_SESSION['userid'];
	
	$smarty->display("leftnav.tpl");
	$userid = $_REQUEST['userid'];
	
	if (isset($_REQUEST['salutation']))$salutation=$_REQUEST['salutation'];else $salutation="";
	if (isset($_POST['firstname'])) $firstname=htmlspecialchars($_POST['firstname']);else $firstname="";
	if (isset($_POST['lastname'])) $lastname=htmlspecialchars($_POST['lastname']);else $lastname="";
	if (isset($_POST['password']))$password=htmlspecialchars($_POST['password']);else $password="";
	if (isset($_POST['confirm']))$confirm=htmlspecialchars($_POST['confirm']);else $confirm="";
	if (isset($_POST['email']))$email=htmlspecialchars($_POST['email']);else $email="";
	if (isset($_POST['phone']))$phone=htmlspecialchars($_POST['phone']);else $phone="";
	if (isset($_POST['addressid']))$addressid=htmlspecialchars($_POST['addressid']);else $addressid="";
	if (isset($_POST['address1']))$address1=htmlspecialchars($_POST['address1']);else $address1="";
	if (isset($_POST['address2']))$address2=htmlspecialchars($_POST['address2']);else $address2="";
	if (isset($_POST['address3']))$address3=htmlspecialchars($_POST['address3']);else $address3="";
	if (isset($_POST['address4']))$address4=htmlspecialchars($_POST['address4']);else $address4="";
	if (isset($_POST['city']))$city=htmlspecialchars($_POST['city']);else $city="";
	if (isset($_POST['county']))$county=htmlspecialchars($_POST['county']);else $county="";

	if (isset($_POST['country']))$country=htmlspecialchars($_POST['country']);else $country="";
	if (isset($_POST['pin']))$pin=htmlspecialchars($_POST['pin']);else $pin="";
	if (isset($_POST['active']))$active=htmlspecialchars($_POST['active']);else $active="";	
	if (isset($_POST['profession']))$profession=htmlspecialchars($_POST['profession']);else $profession="";
	if (isset($_POST['prn']))$prn=htmlspecialchars($_POST['prn']);else $prn="";
	if (isset($_POST['gppcode']))$gppcode=htmlspecialchars($_POST['gppcode']);else $gppcode="";
	if (isset($_POST['consortia']))$consortia=htmlspecialchars($_POST['consortia']);else $consortia="";
	if (isset($_POST['role']))$role=htmlspecialchars($_POST['role']);else $role="";
	if (isset($_POST['org']))$org=htmlspecialchars($_POST['org']);else $org="";
	
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";
	
	$sallist = array ('Mr.', 'Ms.', 'Mrs.', 'Dr.');
	
	$msg = "";

	if ($status == 1){
		$sql = "SELECT * FROM users where user_id != ".$userid." and email = '".$email."'";
		$r1 = mysql_query($sql);
		if(!$r1) {
			$msg = "Unable to fetch record for update, please try again later.";
		}else if ($row = mysql_fetch_assoc($r1)) {
			$msg = "E-Mail ID ".$email." has been already registered by another user, please choose a different e-mail id.";
		}else{
			$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
			$sql = "SHOW TABLE STATUS LIKE 'address'";
			//print("SQL2:".$sql);
			$r1 = mysql_query($sql);
			if ($r1){
				if ($addressid == 0 && (!empty($address1) || !empty($address2) || !empty($city) || !empty($county) || !empty($country) || !empty($pin) )){
					//Create new address
					$row = mysql_fetch_assoc($r1);
					$addressid = $row['Auto_increment'];
					$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,country,pincode) values (0,'$address1','$address2','$address3','$address4','$city','$county','$country','$pin')";
					//print("SQL3:".$sql);
					$r = mysql_query($sql);
				}else{
					//Update existing address
					$sql = "UPDATE address SET address1='".$address1."',address2='".$address2."',address3='".$address3."',address4='".$address4."',city='".$city."',county='".$county."',country='".$country."',pincode='".$pin."' WHERE address_id='".$addressid."'";
					//print("SQL4:".$sql);
					$r = mysql_query($sql);
				}
			}
			$passwordHash = sha1($password);
			//Update Profile
			if (empty($password)){
				if ($active != "") $sql = "UPDATE users SET user_salutation='".$salutation."',user_fname='".$firstname."',user_lname='".$lastname."',".
				"email='".$email."',phone='".$phone."',address_id='".$addressid."',profession_id='".$profession."',prn='".$prn."',role_id='".$role."',org_id='".$org."',active='".$active."',gppcode='".$gppcode."',consortia='".$consortia."' WHERE user_id='".$userid."'";
				else $sql = "UPDATE users SET user_salutation='".$salutation."',user_fname='".$firstname."',user_lname='".$lastname."',".
				"email='".$email."',phone='".$phone."',address_id='".$addressid."',profession_id='".$profession."',prn='".$prn."',role_id='".$role."',org_id='".$org."',gppcode='".$gppcode."',consortia='".$consortia."' WHERE user_id='".$userid."'";
			}else{
				if ($active != "")$sql = "UPDATE users SET user_salutation='".$salutation."',user_fname='".$firstname."',user_lname='".$lastname."',user_password='".
				$passwordHash."',email='".$email."',phone='".$phone."',address_id='".$addressid."',profession_id='".$profession."',prn='".$prn."',role_id='".$role."',org_id='".$org."', active='".$active."',gppcode='".$gppcode."',consortia='".$consortia."' WHERE user_id='".$userid."'";
				else $sql = "UPDATE users SET user_salutation='".$salutation."',user_fname='".$firstname."',user_lname='".$lastname."',user_password='".
				$passwordHash."',email='".$email."',phone='".$phone."',address_id='".$addressid."',profession_id='".$profession."',prn='".$prn."',role_id='".$role."',org_id='".$org."' ,gppcode='".$gppcode."',consortia='".$consortia."' WHERE user_id='".$userid."'";
			}
			//print("SQL1:".$sql);
			$r1 = mysql_query($sql);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to update the profile at this time, please try again later. Error:".$err;
			}else{
				 $msg = "Profile is updated successfully.";
			}
			//$r = mysql_query($sql);
			$r1=mysql_query("COMMIT");//write data & unlock transaction
		}
	}else if ($status == 2){
		$sql = "delete from users where `user_id`='" . $userid . "'";
		//print($sql);
		$r = mysql_query($sql);
		
		if(!$r) {
			$msg=" Unable to delete the user record. Please try again later.";
		} else {
			$msg=" User record is deleted successfully.";
			if ($addressid != 0){
				$sql = "delete from address where `address_id`='" . $addressid . "'";
				//print($sql);
				$r = mysql_query($sql);
				if(!$r) {
					$err=mysql_error();
					$msg = $msg. "Unable to delete Address record of the user.";
					//print "SQL Error:".$err;
				}
			}
		}
	}

		//$sql = "SELECT distinct * from users u, address a, roles r, organisations o where u.user_id='".$userid."' and u.role_id=r.role_id and u.address_id = a.address_id and u.org_id = o.org_id";
		$sql = "SELECT distinct users.user_salutation,users.user_id, users.user_name, users.user_password, users.user_fname, 
		users.user_lname, users.phone, users.email, users.active, users.profession_id,users.prn,users.gppcode,users.consortia,organisations.org_id, roles.role_id, 
		users.address_id as uaddressid, address.address1, address.address2, address.address3,address.address4,address.city, address.county,
		address.country, address.pincode,  roles.role_id, roles.role_desc, organisations.org_id,
		 organisations.organisation from users, address, roles, organisations where users.user_id='".$userid."' and users.role_id=roles.role_id and users.address_id = address.address_id
		 and users.org_id = organisations.org_id";
		
		//print("SQL1:".$sql);
		$r1 = mysql_query($sql);
		if(!$r1) {
			$err=mysql_error();
			$msg = "Unable retrieve user information. Please try again later. Error:".$err;
		}else if ($row = mysql_fetch_assoc($r1)) {
				$salutation=$row['user_salutation'];
				$firstname=$row['user_fname'];
				$lastname=$row['user_lname'];
				$email=$row['email'];
				$phone=$row['phone'];
				$active=$row['active'];
				$addressid=$row['uaddressid'];
				$address1=$row['address1'];
				$address2=$row['address2'];
				$address3=$row['address3'];
				$address4=$row['address4'];
				$city=$row['city'];
				$county=$row['county'];
				$country=$row['country'];
				$pin=$row['pincode'];
				$profession=$row['profession_id'];
				$prn=$row['prn'];
				$gppcode=$row['gppcode'];
				$consortia=$row['consortia'];
				$role=$row['role_id'];
				$org=$row['org_id'];
		}
	
	
?>
<script type="text/javascript">	highlight_nav(2); </script>
<!--  Display Area -->

<div id="divRHS">
  <h1 class="green">Update User</h1>
  <table class="tblForm">
    <tr>
      <td valign="top"><!-- Display Area -->
        <form name="form2" method="post" action="updateuser.php">
          <table class="tblForm">
            <?php if ($msg != null){?>
		    <tr>
		      <td colspan="2" align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?><br/>
		        <?php }?></td>
		    </tr>
		    <tr>
            <td style="width: 130px;">
            <label for="salutation">Salutation:</label>
            </td>
            <td>
                <select name="salutation">
		        <?php
		          foreach ($sallist as $i){
			          if ($salutation == $i){
			          	echo "<option value=\"". $i . "\" selected>". $i . "</option>";
			          }else{
			          	echo "<option value=\"". $i . "\">". $i . "</option>";
			          }
		          }
		   		?>
                </select>
              </td>
            </tr>
            <tr>
              <td style="width: 200px;"><label for="firstname">Forename:</label></td>
              <td><input name="firstname" type="text" class="medium" value="<?php echo "$firstname"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>

            <tr>
              <td style="width: 200px;"><label for="lastname">Surname:</label></td>
              <td><input name="lastname" type="text" class="medium" value="<?php echo "$lastname"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="email">E-Mail ID:</label></td>
              <td><input name="email" type="text" class="medium" value="<?php echo "$email"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
            <?php if($sessionroleid != 1 && $sessionuserid != $userid){ $editable = "readonly=readonly";} else {$editable = "";}?>
            <tr>
              <td><label for="password">Password:</label></td>
              <td><input name="password" type="password" class="small" value="<?php echo "$password";?>" <?php echo " $editable"?>" size="32"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td><label for="confirm">Confirm Password:</label></td>
              <td><input name="confirm" type="password" class="small" value="<?php echo "$confirm"?>" <?php echo " $editable"?>" size="32"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td><label for="phone">Phone Number:</label></td>
              <td><input name="phone" type="text" class="medium" value="<?php echo "$phone"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="org">Organisation:</label></td>
              <td><select name="org" class="medium">
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
                </select>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td><label for="profession">Profession:</label></td>
              <td><select name="profession" class="medium">
                  <?php 
				          	$sql = "SELECT * from professions";
							$r1 = mysql_query($sql);
							echo "<option value=\"0\">Select Profession..</option>";
							if(!$r1){
								$err = mysql_error();
								$msg = "Unable to retrieve profession list:".$err;
							}else {
								  while($row = mysql_fetch_array($r1)){
								  	if($profession == $row['profession_id']){
								  		echo "<option value=\"". $row['profession_id'] . "\" selected>". $row['profession'] . "</option>";
								  	}else{
								  		echo "<option value=\"". $row['profession_id'] . "\">". $row['profession'] . "</option>";
								  	}
								  }
							}
						   ?>
                </select>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td><label for="prn">Prof. Reg. Number:</label></td>
			  <td><input name="prn" type="text" class="medium" value="<?php echo "$prn"?>" size="30"/></td>
            </tr>            
            <tr>
              <td><label for="role">Website Access:</label></td>
              <td><select name="role" class="medium">
                  <?php 
				          	if ($sessionroleid == 1){
				          		$sql = "SELECT * from roles";
				          	}else if ($sessionroleid == 2 || $sessionroleid == 3){
				          		$sql = "SELECT * from roles where role_id >='".$sessionroleid."'";
				          	}else{
				          		$sql = "SELECT * from roles where role_id ='".$sessionroleid."'";
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
                </select>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td><label for="gppcode">GP Practice Code:</label></td>
			  <td><input name="gppcode" type="text" class="medium" value="<?php echo "$gppcode"?>" size="30"/> (if applicable)</td>
            </tr>
            <tr>
              <td><label for="consortia">Clinical Commissioning Group:</label></td>
			  <td><input name="consortia" type="text" class="medium" value="<?php echo "$consortia"?>" size="30"/> (if applicable)</td>
            </tr>
            <?php 
               		if (isset($_SESSION['role_id']) && $_SESSION['role_id'] != 4 && $_SESSION['role_id'] != 5){
	               		 if ($active == 1){
					 		echo "<tr><td>Is User Active?</td><td>
						 		<input type=\"radio\" name=\"active\" value=\"1\" checked/>Yes  
						 		<input type=\"radio\" name=\"active\" value=\"0\"/>No
						 		<input type=\"radio\" name=\"active\" value=\"2\"/>Blocked
					 		<br/></td></tr>";
						 }else if ($active == 0){
						 	echo "<tr><td>Is User Active?</td><td>
						 		<input type=\"radio\" name=\"active\" value=\"1\" />Yes
						 		<input type=\"radio\" name=\"active\" value=\"0\" checked/>No
						 		<input type=\"radio\" name=\"active\" value=\"2\"/>Blocked
						 	<br/></td></tr>";
						 }else{
						 	echo "<tr><td>Is User Active?</td><td>
						 		<input type=\"radio\" name=\"active\" value=\"1\" />Yes
						 		<input type=\"radio\" name=\"active\" value=\"0\" />No
						 		<input type=\"radio\" name=\"active\" value=\"2\" checked />Blocked
						 	<br/></td></tr>";
						 }
               		}
                ?>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td colspan="2"><b>User Address:</b></td>
            </tr>
            <tr>
              <td><input type="hidden" name="addressid" value="<?php echo "$addressid"?>"/>
                <label for="address1">Professional Address:</label></td>
              <td><input name="address1" type="text" class="medium" value="<?php echo "$address1"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="address2">Address Line 2:</label></td>
              <td><input name="address2" type="text" class="medium" value="<?php echo "$address2"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="address3">Address Line 3:</label></td>
              <td><input name="address3" type="text" class="medium" value="<?php echo "$address3"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="address4">Address Line 4:</label></td>
              <td><input name="address4" type="text" class="medium" value="<?php echo "$address4"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="city">City:</label></td>
              <td><input name="city" type="text" class="medium" value="<?php echo "$city"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="county">County:</label></td>
              <td><input name="county" type="text" class="medium" value="<?php echo "$county"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="country">Country:</label></td>
              <td><input name="country" type="text" class="medium" value="<?php echo "$country"?>" size="30"/></td>
            </tr>
            <tr>
              <td><label for="pin">Post Code:</label></td>
              <td><input name="pin" type="text" class="medium" value="<?php echo "$pin"?>" size="30"/></td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td colspan="2" class="buttons"><input type="hidden" name="userid" value="<?php echo "$userid"?>"/>
                <!-- input name="Button" type="button" onclick="return validateRegistration('cancel')" value="Cancel"/-->
				<input name="Button" type="button" onclick="javascript:history.back()" value="Cancel"/>                
                <input name="Button" type="button" onclick="return validateRegistration('update')" value="Update"/>
                <?php if ($sessionroleid != 4){?>
                <input name="Button" type="button" onclick="return validateRegistration('delete')" value="Delete"/>
                <?php }?>
                </td>
            </tr>            

            <?php  
		  	// Free the resources associated with the result set
			// This is done automatically at the end of the script
			@mysql_free_result($r);
			@mysql_close();
		?>
          </table>
        </form></td>
    </tr>
  </table>
  <!--  Display Area -->
</div>
<!-- END OF #divRHS -->
<div class="clear">
  <!-- -->
</div>
</div>
<!-- END OF #divFauxColumns -->
<?php $smarty->display("footer.tpl");?>
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>