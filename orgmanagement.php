<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");
?>
<script type="text/javascript">	highlight_nav(3); </script>
<link href="_css/reset.css" rel="stylesheet" type="text/css" />
<link href="_css/main_stylesheet.css" rel="stylesheet" type="text/css" />

<div id="divRHS">
  <h1 class="green">Organisation Management</h1>
  <?php
if (isset($_POST['org']))$orgid=htmlspecialchars($_POST['org']);else $orgid=0;

if (isset($_GET['status']))$status = $_GET['status']; else $status = "";

if ($status != 0){
	$orgname=htmlspecialchars($_POST['orgname']);
	$povzone=htmlspecialchars($_POST['povzone']);
	$addid = htmlspecialchars($_POST['addid']);
	$address1=htmlspecialchars($_POST['address1']);
	$address2=htmlspecialchars($_POST['address2']);
	$address3=htmlspecialchars($_POST['address3']);
	$address4=htmlspecialchars($_POST['address4']);
	$city=htmlspecialchars($_POST['city']);
	$county=htmlspecialchars($_POST['county']);
	//$state=htmlspecialchars($_POST['state']);
	$country=htmlspecialchars($_POST['country']);
	$pin=htmlspecialchars($_POST['pin']);
}else{
	$orgname = "";
	$povzone = "";
	$address1 = "";
	$address2 = "";
	$address3 = "";
	$address4 = "";
	$city = "";
	$county = "";
	$country = "";
	//$state = "";
	$pin = "";
}

if (($orgid == 0 || $orgid == null)) {
	$orgid = null;
	$orgname = "";
}

if ($status == 1 && $orgid != 0 && $orgid != null){ // View Org
	$sql = "SELECT * from organisations where org_id='".$orgid."'";
	//print("SQL1:".$sql);
	$r1 = mysql_query($sql);
	if(!$r1) {
		$err=mysql_error();
		$msg = "Unable to fetch organisation details, please try again later. Error:".$err;
	}else if ($row = mysql_fetch_assoc($r1)) {
		$orgid = $row['org_id'];
		$orgname = $row['organisation'];
		$povzone = $row['povzone'];
		$addid = $row['address_id'];
		if ($addid == 0 ||  $addid == null){
			$address1="";
			$address2="";
			$address3="";
			$address4="";
			$city="";
			$county="";
			$country="";
			$pin="";
		}
	}

	if ($addid != 0 && $addid != null){
		$sql = "SELECT * from address where address_id='".$addid."'";
		//print("SQL1:".$sql);
		$r1 = mysql_query($sql);
		if(!$r1) {
			$err=mysql_error();
			$msg = "Unable to fetch address details, please try again later. Error:".$err;
		}else if ($row = mysql_fetch_assoc($r1)) {
			$addessid = $row['address_id'];
			$address1 = $row['address1'];
			$address2 = $row['address2'];
			$address3 = $row['address3'];
			$address4 = $row['address4'];
			$city = $row['city'];
			$county = $row['county'];
			//$state = $row['state'];
			$country = $row['country'];
			$pin = $row['pincode'];
		}
	}
}else if($status == 2){ // Create Org
	$orgname=htmlspecialchars($_POST['orgname']);
	$sql = "SELECT * from organisations where organisation='".$orgname."'";
	//print("SQL1:".$sql);
	$r1 = mysql_query($sql);
	if(!$r1) {
		$err=mysql_error();
		$msg = "Unable to fetch organisation details at this time, please try again later. Error:".$err;
	}else if ($row = mysql_fetch_assoc($r1)) {
		$msg = "Organisation name '".$orgname."' is already exists in database. Please choose a different name.";
	}else{
		$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
		$sql = "SHOW TABLE STATUS LIKE 'address'";
		//print("SQL2:".$sql);
		$r1 = mysql_query($sql);
			
		if($r1 && (!empty($address1) || !empty($address2) || !empty($address3)|| !empty($address4)|| !empty($city) || !empty($county) || !empty($country) || !empty($pin) )){
			$row = mysql_fetch_assoc($r1);
			$addid = $row['Auto_increment'];
			$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,country,pincode) values (0,'$address1','$address2','$address3','$address4','$city','$county','$country','$pin')";
			//print("SQL3:".$sql);
			$r = mysql_query($sql);
		}else $addid = 0;
			
		$sql = "INSERT INTO organisations (org_id,organisation,povzone,address_id) VALUES (0,'$orgname','$povzone','$addid')";
		//print("SQL4:".$sql);
		$r = mysql_query($sql);
		$r1=mysql_query("COMMIT");//write data & unlock transaction

		if(!$r) {
			$err=mysql_error();
			$msg = "Unable to create organisation at this time, please try again later. Error:".$err;
		}else{
			$msg = "Organisation is created successfully.";
		}
	}
}else if ($status == 3){ //Update
	if($addid == 0 && (!empty($address1) || !empty($address2) || !empty($address3) ||!empty($address4) || !empty($city) || !empty($county) || !empty($country) || !empty($pin) )){
		$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
		$sql = "SHOW TABLE STATUS LIKE 'address'";
		//print("SQL2:".$sql);
		$r1 = mysql_query($sql);
		$row = mysql_fetch_assoc($r1);
		$addid = $row['Auto_increment'];
		$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,country,pincode) values (0,'$address1','$address2','$address3','$address4','$city','$county','$country','$pin')";
		//print("SQL3:".$sql);
		$r = mysql_query($sql);
		$r1=mysql_query("COMMIT");//write data & unlock transaction
	}else if ($addid != 0){
		$sql = "UPDATE address SET address1='".$address1."',address2='".$address2."',address3='".$address3."',address4='".$address4."',city='".$city."',county='".$county."',country='".$country."',pincode='".$pin."' WHERE address_id='".$addid."'";
		//print("SQL4:".$sql);
		$r = mysql_query($sql);
	}

	$sql = "UPDATE organisations SET organisation='".$orgname."',povzone='".$povzone."',address_id='".$addid."' WHERE org_id='".$orgid."'";
	//print("SQL4:".$sql);
	$r = mysql_query($sql);

	if(!$r) {
		$err=mysql_error();
		$msg = "Unable to udate organisation at this time, please try again later. Error:".$err;
	}else{
		$msg = "Organisation details are updated successfully.";
	}
}else if ($status == 4){
	//Delete
	if ($addid != 0){
		$sql = "delete from address where `address_id`='" . $addid . "'";
		//print($sql);
		$r = mysql_query($sql);
		if(!$r) {
			$err=mysql_error();
			$msg="Unable to delete Address record of the organisation.";
			//print "SQL Error:".$err;
		}
	}
	$sql = "delete from organisations where `org_id`='" . $orgid . "'";
	//print($sql);
	$r = mysql_query($sql);
	$msg=$msg." Organisation is deleted successfully.";

	if(!$r) $msg=$msg." Unable to delete the organisation. Please try again later.";
}
?>
  <form name="form2" method="post" action="orgmanagement.php">
    <table class="tblForm">
      <tr>
        <td colspan="2" align="center"><?php if (!empty($msg)){
        echo "<font color=\"red\">" . $msg . "</font>";
		}?></td>
      </tr>
      <!-- Display Area -->
      <tr>
        <th style="width: 130px;"><label for="org">Organisation:</label>
        </th>
        <td><select name="org" onchange="viewOrg();">
            <?php
		$sql = "SELECT * from organisations";
		//print("SQL1:".$sql);
		$r1 = mysql_query($sql);
		echo "<option value=\"0\">Select organisation to update..</option>";
		if(!$r1){
			$msg = "Unable to retrieve organisation list.";
		}else {
			while($row = mysql_fetch_array($r1)){
				if($orgid == $row['org_id']){
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
        <th><label for="orgid"><font color="red"></font>Organisation Id:</label>
        </th>
        <td><?php echo "$orgid"?></td>
      </tr>
      <tr>
        <th><label for="orgname">Organisation Name:</label>
        </th>
        <td><input name="orgname" type="text" class="medium"
			value="<?php echo "$orgname"?>" size="30" />
          <font color="red">*</font></td>
      </tr>
      <tr>
         <th><label for="povzone">POV Zone:</label></th>
         <td><input name="povzone" type="text" class="medium" value="<?php echo "$povzone"?>" maxlength="5" size="30"/></td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      <tr>
        <td colspan="2"><b> User Address:</b></td>
      </tr>
      <tr>
        <th><label for="address1">Address Line 1:</label>
        </th>
        <td><input type="hidden" name="addid" size="30" value="<?php echo "$addid"?>" />
          <input name="address1" type="text" class="medium" value="<?php echo "$address1"?>" /></td>
      </tr>
      <tr>
        <th><label for="address2">Address Line 2:</label>
        </th>
        <td><input name="address2" type="text" class="medium"
			value="<?php echo "$address2"?>" /></td>
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
        <th><label for="city">City:</label>
        </th>
        <td><input name="city" type="text" class="medium"
			value="<?php echo "$city"?>" /></td>
      </tr>
      <tr>
        <th><label for="county">County:</label>
        </th>
        <td><input name="county" type="text" class="medium"
			value="<?php echo "$county"?>" size="30" /></td>
      </tr>
      <tr>
        <th><label for="country">Country:</label>
        </th>
        <td><input name="country" type="text" class="medium"
			value="<?php echo "$country"?>" size="30" /></td>
      </tr>
      <tr>
        <th><label for="pin">Post Code:</label>
        </th>
        <td><input name="pin" type="text" class="small"
			value="<?php echo "$pin"?>" size="30" /></td>
      </tr>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      <tr>
        <td colspan="2" class="buttons">
          <input type="button" onclick="return validateOrg('reset');" value="Reset" />
          <input type="button" onclick="return validateOrg('create');" value="Create" />
          <input type="button" onclick="return validateOrg('update');" value="Update" />
          <input type="button" onclick="return validateOrg('delete');" value="Delete" />
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