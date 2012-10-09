<?php
	$anonym = "";
	if (isset($_REQUEST['anonym']) && $_REQUEST['anonym'] == 1){
			$anonym = $_REQUEST['anonym'];
			require "setpath.php";
			require "common.php";
			require "properties.php";
			require "connect.php";
			require "Smarty.php";
			$smarty->assign("sessionroleid",null);
		}else {
			require ('inc/include.php');
			if (isset($_SESSION['userid'])) $sessionuserid = $_SESSION['userid'];else $sessionuserid = "";
			if (isset($_SESSION['role_id'])) $sessionroleid = $_SESSION['role_id'];else $sessionroleid = "";
			if (isset($_SESSION['org_id'])) $sessionorgid = $_SESSION['org_id'];else $sessionorgid = "";			
		}

	
		$smarty->display("header.tpl");
		
		if (isset($_SESSION['userid'])) {
			$smarty->display("leftnav.tpl");
		}
?>

<?php if (isset($_SESSION['userid'])){?>
	<script type="text/javascript">	highlight_nav(2);</script>
<?php }?>

<!--  Display Area -->

<div id="divRHS">
  <?php
	if (isset($_REQUEST['salutation']))$salutation=$_REQUEST['salutation'];else $salutation="";
	if (isset($_POST['firstname'])) $firstname=htmlspecialchars($_POST['firstname']);else $firstname="";
	if (isset($_POST['lastname'])) $lastname=htmlspecialchars($_POST['lastname']);else $lastname="";
	if (isset($_POST['password']))$password=htmlspecialchars($_POST['password']);else $password="";
	if (isset($_POST['email']))$email=htmlspecialchars($_POST['email']);else $email="";
	if (isset($_POST['phone']))$phone=htmlspecialchars($_POST['phone']);else $phone="";
	if (isset($_POST['address1']))$address1=htmlspecialchars($_POST['address1']);else $address1="";
	if (isset($_POST['address2']))$address2=htmlspecialchars($_POST['address2']);else $address2="";
	if (isset($_POST['address3']))$address3=htmlspecialchars($_POST['address3']);else $address3="";
	if (isset($_POST['address4']))$address4=htmlspecialchars($_POST['address4']);else $address4="";
	if (isset($_POST['city']))$city=htmlspecialchars($_POST['city']);else $city="";
	if (isset($_POST['county']))$county=htmlspecialchars($_POST['county']);else $county="";
	if (isset($_POST['country']))$country=htmlspecialchars($_POST['country']);else $country="";
	if (isset($_POST['pin']))$pin=htmlspecialchars($_POST['pin']);else $pin="";
	
	if (isset($_POST['profession']))$profession=htmlspecialchars($_POST['profession']);else $profession="";
	if (isset($_POST['prn']))$prn=htmlspecialchars($_POST['prn']);else $prn="";
	if (isset($_POST['gppcode']))$gppcode=htmlspecialchars($_POST['gppcode']);else $gppcode="";
	if (isset($_POST['consortia']))$consortia=htmlspecialchars($_POST['consortia']);else $consortia="";
	if (isset($_POST['role']))$role=htmlspecialchars($_POST['role']);else $role="";
	if (isset($_POST['org']))$org=htmlspecialchars($_POST['org']);else $org="";
	
	$sallist = array ('Mr.', 'Ms.', 'Mrs.', 'Dr.');
	
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";
	
	$msg = "";
	
//	print ("Status:".$status);
	
	if ($status == 1){
		$sql = "SELECT * from users where email='".$email."'";
		//echo "SQL1:".$sql;
		$r1 = mysql_query($sql);
		if(!$r1) {
			$err=mysql_error();
			$msg = "Unable to register at this time, please try again later. Error:".$err;
		}else if ($row = mysql_fetch_assoc($r1)) {
			$msg = "E-Mail ID '".$email."' has been registered already. Please choose a different e-mail id.";
		}else{
			$addressid = 0;
			$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
			$sql = "SHOW TABLE STATUS LIKE 'address'";
			//print("SQL2:".$sql."\r");
			$r1 = mysql_query($sql);
			
			if($r1 && (!empty($address1) || !empty($address2) || !empty($address3)|| !empty($address4) || !empty($city) || !empty($county) || !empty($country) || !empty($pin) )){
				$row = mysql_fetch_assoc($r1);
				$addressid = $row['Auto_increment'];
				$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,country,pincode) values (0,'$address1','$address2','$address3','$address4','$city','$county','$country','$pin')";
				//print("SQL3:".$sql."\r");
				$r = mysql_query($sql);	
			}
			$passwordHash = sha1($password);
			
			if (!isset($sessionuserid)){
				$sql = "INSERT INTO users (user_id,user_fname,user_lname,user_password,phone,email,user_registered_on,profession_id,prn,org_id,role_id,address_id,user_salutation,gppcode,consortia) VALUES (0,'$firstname','$lastname','$passwordHash','$phone','$email',now(),'$profession','$prn','$org','$role','$addressid','$salutation','$gppcode','$consortia')";		
			}else {
				$sql = "INSERT INTO users (user_id,user_fname,user_lname,user_password,phone,email,user_registered_on,profession_id,prn,org_id,role_id,address_id,user_salutation,active,gppcode,consortia) VALUES (0,'$firstname','$lastname','$passwordHash','$phone','$email',now(),'$profession','$prn','$org','$role','$addressid','$salutation',1,'$gppcode','$consortia')";		
			}
			//print("SQL4:".$sql."\r");
			$r = mysql_query($sql);
			$r1=mysql_query("COMMIT");//write data & unlock transaction
				
			if(!$r) {
				$err=mysql_error();
				$msg = "Unable to register at this time, please try again later. Error:".$err;
			}else{
				if (!isset($sessionuserid))$msg = "Your registration is successful. Thank you for registering to CD Declaration. Administrator will approve your request, post which you will be able to login and complete your declaration.";
				else $msg = "User registration is successful.";
			}
		}
	}
	
?>
  <table class="tblForm">
    <tr>
      <?php if (!isset($sessionroleid)){?>
      <td><h1 class="green">User Registration</h1></td>
      <?php }else{?>
      <td align="center" colspan="2"><h1 class="green">User Registration</h1></td>
      <?php }?>
    </tr>
    <?php if (!isset($sessionuserid)){?>
    <tr>
      <td align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?><br/>
        Go To <a href="index.php">Login</a></td>
    </tr>
    <?php }?>
    <?php if (isset($sessionuserid)){?>
    <tr>
      <td align="center" colspan="2"><?php echo "<font color=\"red\">" . $msg . "</font>";?></td>
    </tr>
    <?php }?>
    <tr>
      <td><!-- Display Area -->
        <form name="form2" method="post" action="registration.php">
          <table class="tblForm">
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
              <td style="width: 130px;"><label for="firstname">Forename:</label></td>
              <td><input name="firstname" type="text" class="medium" value="<?php echo "$firstname"; ?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <th><label for="lastname">Surname:</label></th>
              <td><input name="lastname" type="text" class="medium" value="<?php echo "$lastname";?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="email">E-Mail ID:</label></th>
              <td><input name="email" type="text" class="medium" value="<?php echo "$email"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <th><label for="password">Password:</label></th>
              <td><input name="password" type="password" class="small" size="32"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <th><label for="confirm">Confirm Password:</label></th>
              <td><input name="confirm" type="password" class="small" size="32"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <th><label for="phone">Phone Number:</label></th>
              <td><input name="phone" type="text" class="small" value="<?php echo "$phone"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="org">Organisation:</label></th>
              <td><select name="org">
                  <?php 
				           if (!isset($sessionuserid) || $sessionroleid == 1){
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
              <th><label for="profession">Profession:</label></th>
              <td><select name="profession">
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
              <th><label for="prn">Prof. Reg. Number:</label></th>
			  <td><input name="prn" type="text" class="medium" value="<?php echo "$prn"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="role">Website Access:</label></th>
              <td><select name="role">
                  <?php 
				          	if (!isset($sessionuserid)){
				          		$sql = "SELECT * from roles where role_id=4 or role_id=5";
				          	}else if ($sessionroleid == 1){
				          		$sql = "SELECT * from roles";
				          	}else if($sessionroleid == 2){
				          		$sql = "SELECT * from roles where role_id > '".$sessionroleid."'";
				          	}else{
				          		$sql = "SELECT * from roles where role_id='4' or role_id='5'";
				          	}
				          	//print("SQL:".$sql);
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
              <th><label for="gppcode">GP Practice Code:</label></th>
			  <td><input name="gppcode" type="text" class="medium" value="<?php echo "$gppcode"?>" size="30"/> (if applicable)</td>
            </tr>
            <tr>
              <th><label for="consortia">Clinical Commissioning Group:</label></th>
			  <td><input name="consortia" type="text" class="medium" value="<?php echo "$consortia"?>" size="30"/> (if applicable)</td>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td colspan="2"><b><br/>
                User Address:</b></td>
            </tr>
            <tr>
              <th><label for="address1">Professional Address:</label></th>
              <td><input name="address1" type="text" class="medium" value="<?php echo "$address1"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="address2">Address Line 2:</label></th>
              <td><input name="address2" type="text" class="medium" value="<?php echo "$address2"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="address3">Address Line 3:</label></th>
              <td><input name="address3" type="text" class="medium" value="<?php echo "$address3"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="address4">Address Line 4:</label></th>
              <td><input name="address4" type="text" class="medium" value="<?php echo "$address4"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="city">City:</label></th>
              <td><input name="city" type="text" class="medium" value="<?php echo "$city"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="county">County:</label></th>
              <td><input name="county" type="text" class="medium" value="<?php echo "$county"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="country">Country:</label></th>
              <td><input name="country" type="text" class="medium" value="<?php echo "$country"?>" size="30"/></td>
            </tr>
            <tr>
              <th><label for="pin">Post Code:</label></th>
              <th><input name="pin" type="text" class="medium" value="<?php echo "$pin"?>" size="30"/></th>
            </tr>
            <tr>
              <td colspan="2"><hr /></td>
            </tr>
            <tr>
              <td colspan="2" class="buttons"><input type="hidden" name="anonym" value="<?php echo "$anonym"?>"/>
                <input type="button"onclick="return validateRegistration('register');" value="Register"/></td>
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
<?php if (isset($_SESSION['userid'])){?>
</div>
<!-- END OF #divFauxColumns -->
<?php }?>
<?php 
	$smarty->display("footer.tpl"); 
?>
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>