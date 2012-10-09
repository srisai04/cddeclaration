<?php require ("inc/include.php");
//Header
$smarty->display("header.tpl");
//Left Navigation
$smarty->display("leftnav.tpl");
?>
<?php if ($sessionroleid != 1){?>
<script type="text/javascript">	highlight_nav(3); </script>
<?php }else{?>
<script type="text/javascript">	highlight_nav(4); </script>
<?php }?>

<div id="divRHS">
  <h1 class="green">Import/Export</h1>
  <?php
	$sessionorgid = $_SESSION['org_id'];
	$sessionroleid = $_SESSION['role_id'];
	
	if (isset($_POST['org']))$org=htmlspecialchars($_POST['org']);else $org="";
	if (isset($_GET['status']))$status = $_GET['status'];else $status = "";
?>
  <form name="form2" method="post" action="importexport.php" enctype="multipart/form-data">
    <table class="tblForm">
      <tr>
        <td colspan="2" align="center"><?php if(isset($_GET['msg']))$msg = $_GET['msg'];else $msg = ""; echo "<font color=\"red\">" . $msg . "</font>";?>
          <br/></td>
      </tr>
      <tr>
        <td><label for="importuserfile"><b>Users:</b></label>
          <br>
          <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
          <input name="importuserfile" type="file" class="buttons"/>
          <input type="button" onclick="return validateImportExport('userimport')" value="Import Users"/></td>
      </tr>
      <?php if ($sessionroleid == 1 || $sessionroleid == 2){?>
      <tr>
        <td><br>
          <label for="org"></label>
          <select name="org">
            <?php
            			if ($sessionroleid == 2) $sql = "SELECT * from organisations where org_id=".$sessionorgid;
			          	else $sql = "SELECT * from organisations";
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
          <input type ="button" onclick="return validateImportExport('userexport')" value="Export Users"/>
            </td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="2"><hr /></td>
      </tr>
      <?php if ($sessionroleid == 1){?>
      <tr>
        <td><label for="importorgfile"><b>Organisations:</b></label>
          <br>
          <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
          <input name="importorgfile" type="file" class="medium"/>
          &nbsp;&nbsp;&nbsp;<input type="button" onclick="return validateImportExport('orgimport')" value="Import Organisations"/>
          <br/>
          <br/>
          <input type="button"onclick="window.open('exportorgs.php')" value="Export Organisations"/></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><?php
		      if ($status == 1){ //Import Users
				 $fname = $_FILES['importuserfile']['name'];
				 //Move file to server
				$tempname = $_FILES['importuserfile']['tmp_name'];
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
							//print("Reading..".$firstrow);
							if ($firstrow != 1){
								//echo "<br> Row:".$firstrow."<br>";
								
								if ($sessionroleid != 1 && ($sessionorgid != trim($data[11],"'")) || $sessionroleid > trim($data[12],"'") ){
									//User do not have permission to import users 1 - Importing other org users, 2 - Importing a user upper roles
									echo "<br><font color=\"red\">No Previleges to import user: E-Mail ID: '$data[6]' , First Name: '$data[3]', Last Name: '$data[4]'</font>";										
									echo "<br>(You do not have previleges to import users of other organisations and the role higher than your role)";
								}else{
								
								$sql = "SELECT * FROM users WHERE email='".trim($data[6],"'")."'";
								//print("<br>SQL1:".$sql);
								$r1 = mysql_query($sql);
								if(!$r1) {
									$err=mysql_error();
									echo "<br> A SQL error occured, Unable to execute the queries at this time, please try again later. Error:".$err."<br>";
								}else if ($row = mysql_fetch_assoc($r1)) {
									$sql = "UPDATE users SET user_fname='".trim($data[3],"'")."',user_lname='".trim($data[4],"'")."',".
									"phone='".trim($data[5],"'")."',email='".trim($data[6],"'")."',user_registered_on='".trim($data[7],"'")."',user_last_logged_on='".trim($data[8],"'").
									"',profession_id='".trim($data[9],"'")."',prn='".trim($data[10],"'")."',org_id='".trim($data[11],"'")."',role_id='".trim($data[12],"'")."',address_id='".trim($data[13],"'").
									"',user_salutation='".trim($data[14],"'")."',active='".trim($data[15],"'")."',gppcode='".trim($data[16],"'")."',consortia='".trim($data[17],"'")."' WHERE user_id='".trim($data[0],"'")."'";
									//echo "<br>".$sql;
									$r1 = mysql_query($sql);
									if(!$r1){
										echo "<br>Unable to update the record at this time, please try again later.<br>";
									}else{
										echo "<br><font color=\"blue\">User Record Updated: E-Mail ID: '$data[6]' , First Name: '$data[3]', Last Name: '$data[4]'</font>";
										$sql="UPDATE address SET address1='".trim($data[20],"'")."',address2='".trim($data[21],"'")."',address3='".trim($data[22],"'")."',address4='".trim($data[23],"'")."',city='".trim($data[24],"'")."',county='".trim($data[25],"'")."',state='".trim($data[26],"'")."',country='".trim($data[27],"'")."',pincode='".trim($data[28],"'")."' WHERE address_id='".trim($data[19],"'")."'";
										//echo"<br>".$sql."<br>";
										$r1 = mysql_query($sql);
										if(!$r1){
											echo "<br>Unable to update the Address at this time, please try again later.<br>";
										}
									}
								}else{
									$addressid = 0;
									//print ("<br>Address is empty?:".$data[16]);
									if ($data[19] != null && $data[19] != ""){
										$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
										$sql = "SHOW TABLE STATUS LIKE 'address'";
										//print("<br>SQL2:".$sql);
										$r1 = mysql_query($sql);
										
										if($r1){
											$row = mysql_fetch_assoc($r1);
											$addressid = $row['Auto_increment'];
											$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,state,country,pincode) values".
											"(0,'".trim($data[20],"'")."','".trim($data[21],"'")."','".trim($data[22],"'")."','".trim($data[23],"'")."','".trim($data[24],"'")."','".trim($data[25],"'")."','".trim($data[26],"'")."','".trim($data[27],"'")."','".trim($data[28],"'")."')";
											//print("<br>SQL3:".$sql);
											$r = mysql_query($sql);	
										}
									}
								//print("Password:".trim($data[2],"'"));
								$passwordHash = trim($data[2],"'");
								//$passwordHash = sha1(trim($data[2],"'"));
								$sql = "INSERT INTO users(user_id, user_name, user_password, user_fname, user_lname,". 
								"phone, email, user_registered_on, user_last_logged_on, profession_id,prn, org_id, role_id,".
								  "address_id, user_salutation, active, gppcode, consortia, imported) VALUES ".
								  "(0,'".trim($data[1],"'")."','$passwordHash','".trim($data[3],"'")."','".trim($data[4],"'")."','".trim($data[5],"'")."','".trim($data[6],"'")."','".trim($data[7],"'")."','".trim($data[8],"'")."','".trim($data[9],"'")."','".trim($data[10],"'")."','".trim($data[11],"'")."','".trim($data[12],"'")."','".$addressid."','".trim($data[14],"'")."','".trim($data[15],"'")."','".trim($data[16],"'")."','".trim($data[17],"'")."','1')";
								//print("SQL:".$sql."<br>");
								$r1 = mysql_query($sql); //or die(mysql_error());
								if(!$r1){
									echo "<br> Unable to execute query:'$sql'";
								}else{
									echo "<br><font color=\"green\">User Record Imported: E-Mail ID: '$data[6]' , First Name: '$data[3]', Last Name: '$data[4]'</font>";
								}
								$r1=mysql_query("COMMIT");//write data & unlock transaction
							  }
							 } //user prev check
							}//First row check
							$firstrow = $firstrow + 1;
						 } //while
						 
						}
						fclose($handle);
					
					//print("target:".$target_path);
					if (@unlink($target_path)){
						//print("Temporary file deleted.");
					}else{
						//print("Unable to delete temporary file.");
					}
				} else {
					print "Unable to move file to temporary location to create queries for import.";
				}
									
			}else if ($status == 2){ //Import Organisations
				 $fname = $_FILES['importorgfile']['name'];
				 //Move file to server
				$tempname = $_FILES['importorgfile']['tmp_name'];
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
							//print("Reading..".$firstrow);
							if ($firstrow != 1){
								$sql = "SELECT * FROM organisations WHERE organisation='".trim($data[1],"'")."'";
								//print("<br>SQL1:".$sql);
								$r1 = mysql_query($sql);
								if(!$r1) {
									$err=mysql_error();
									print("<br> A SQL error occured, Unable to execute the queries at this time, please try again later. Error:".$err);
								}else if ($row = mysql_fetch_assoc($r1)) {
									print("<br> Organisation Name '".trim($data[1],"'")."' is already in the system. Please choose a different Name.");
								}else{
									$addressid = 0;
									//print ("<br>Address is empty?:".$data[5]);
									if ($data[5] != null && $data[5] != ""){
										$r1 = mysql_query("STARTTRANSACTION"); //Lock transcations
										$sql = "SHOW TABLE STATUS LIKE 'address'";
										//print("<br>SQL2:".$sql);
										$r1 = mysql_query($sql);
										
										if($r1){
											$row = mysql_fetch_assoc($r1);
											$addressid = $row['Auto_increment'];
											$sql="INSERT INTO address (address_id,address1,address2,address3,address4,city,county,state,country,pincode) values".
											"(0,'".trim($data[6],"'")."','".trim($data[7],"'")."','".trim($data[8],"'")."','".trim($data[9],"'")."','".trim($data[10],"'")."','".trim($data[11],"'")."','".trim($data[12],"'")."','".trim($data[13],"'")."','".trim($data[14],"'")."')";
											//print("<br>SQL3:".$sql);
											$r = mysql_query($sql);	
										}
									}
								$sql = "INSERT INTO organisations(org_id, organisation, povzone, address_id) VALUES ".
								  "(0,'".trim($data[1],"'")."','".trim($data[2],"'")."','$addressid')";
								//print("<br>SQL:".$sql."");
								$r1 = mysql_query($sql); //or die(mysql_error());
								if(!$r1){
									echo "<br> Unable to execute query:'$sql'";
								}else{
									echo "<br><font color=\"green\">Organisation Record Imported: Organisation Name: '".trim($data[1],"'")."' <br></font>";
								}
								$r1=mysql_query("COMMIT");//write data & unlock transaction
							} 
						 } //firstrow check
						 $firstrow = $firstrow + 1;
						} //while
						fclose($handle);
					}
					//print("Target:".$target_path);
					if (@unlink($target_path)){
						//print("Temporary file deleted.");
					}else{
						//print("Unable to delete temporary file.");
					}
				} else {
					print "Unable to move file to temporary location to create queries for import.";
				}
				
			}else if ($status == 3){
				//echo "<script>window.popUp(\"export.php\");</script>";
			}
			?></td>
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