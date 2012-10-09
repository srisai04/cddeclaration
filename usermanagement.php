<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display("leftnav.tpl");

	if (isset($_REQUEST['status']))$status = $_REQUEST['status'];else $status = "";
	if (isset($_GET['order']))$order = $_GET['order'];else $order = "";
	if (isset($_GET['ordby']))$ordby = $_GET['ordby'];else $ordby = 1;
	
	//if (isset($_POST['org']))$org = $_POST['org'];else $org = "";
	//if (isset($_POST['role']))$role = $_POST['role'];else $role = "";
	
	if (isset($_SESSION['org_id'])) $sessionorgid=$_SESSION['org_id'];else $sessionorgid="";
	if (isset($_SESSION['role_id'])) $sessionroleid=$_SESSION['role_id'];else $sessionroleid="";

	$msg = "";
	
	if (isset($_REQUEST['org'])) $org = $_REQUEST['org']; else $org = "";
	if (isset($_REQUEST['role'])) $role = $_REQUEST['role']; else $role = "";
	
	//print ("Org:".$org." Role:".$role);
	
	if ($status == 1){
		//Activate All users
		
		$sql = "UPDATE users SET active=1 WHERE active=0";
		
		
		if (empty($org) && $org == 0) {
			if ($sessionroleid > 1)$org = $sessionorgid;
		}
		if (!empty($org) && $org != 0){
			$sql = $sql . " and org_id=".$org;
		}
		
		if (!empty($role) && $role != 0) $sql = $sql . " and role_id=".$role;
		
		//print("SQL1:".$sql);
		$r = mysql_query($sql);
		if(!$r) {
			$err=mysql_error();
			$msg = "Unable to activate users at this time. Please try again later.";
		}else{
			$msg = "All inactive users have been activated.";
			if ((!empty($org) && $org != 0) || (!empty($role) && $role != 0)) $msg = "All inactive users of selected Organisation and Website access have been activated.";
			
		}
	}
?>
<!--  Display Area -->

<div id="divRHS">
<script type="text/javascript">	highlight_nav(2); </script>

  <h1 class="green">People Management</h1>
  <form name="searchform" method="post">
    <table class="tblForm">
      <tr>
        <td colspan="6" align="center"><?php echo "<font color=\"red\">" . $msg . "</font>";?></td>
      </tr>
      <tr>
        <td><label for="org">Organisation:</label></td>
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
          </select>
          <font color="red"></font></td>
        <td><label for="role">Website Access:</label></td>
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
							$msg = "Unable to retrieve website access list:".$err;
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
          </td>
          <td><input type="submit" onclick="return searchUsers();" value="Search" /></td>
        <td><div class="divFilterUM">
            <input type="button"  onclick="return newUser();" value="Create New User" />
          </div></td>
      </tr>
    </table>
  </form>
  <form name="form2" method="post">
    <table class="tblUsers">
      <?php
      		if (($org == 0 || $org == null) && ($role == 0 || $role == null) ){
      			echo "<tr>
        			<td colspan=\"7\">Please select an organisation or web access and search.<br></td></tr>";
      		}else{
		  		if ($ordby == 1) $ord=0; else $ord = 1;
  				echo "<th> <a href=\"usermanagement.php?order=id&ordby=".$ord."&org=".$org."&role=".$role."\">Id</a></th>";
				echo "<th> <a href=\"usermanagement.php?order=fname&ordby=".$ord."&org=".$org."&role=".$role."\">Name</a></th>";
				//echo "<th> <a href=\"usermanagement.php?order=lname&ordby=".$ord."&org=".$org."&role=".$role."\">Sur Name</a></th>";
				echo "<th> <a href=\"usermanagement.php?order=name&ordby=".$ord."&org=".$org."&role=".$role."\">E-Mail ID</a></th>";
				echo "<th>Access</th>";
				echo "<th width=\"20%\" align=\"center\" bgcolor=\"gray\">Organisation</th>";
				echo "<th width=\"10%\" align=\"center\" bgcolor=\"gray\"><a href=\"usermanagement.php?order=status&ordby=".$ord."&org=".$org."&role=".$role."\">Status</a></th>";
				
			  	$sql = "SELECT * from users, roles, organisations where users.role_id = roles.role_id and users.org_id = organisations.org_id";
			  	//print("Org:".$org." , role:".$role);
			  					
			  	if (!empty($org)) $sql = $sql . " and users.org_id=".$org;
			  	if (!empty($role)) $sql = $sql . " and users.role_id=".$role;
			  	
			  	if (!empty($sessionroleid) && ($sessionroleid == 2 || $sessionroleid == 3)){
			  		if (!empty($sessionorgid))$sql = $sql . " and users.org_id=".$sessionorgid;
			  		 $sql = $sql . " and users.role_id >=".$sessionroleid;
			  	}

			  	if ($ordby == 0) $ord = "desc";else $ord="asc";
			  	
			  	if ($order == "id"){
			  		$sql = $sql. " order by user_id ".$ord;
			  	}else if ($order == "fname"){
			  		$sql = $sql. " order by user_fname ".$ord;
			  	}else if ($order == "lname"){
			  		$sql = $sql. " order by user_lname ".$ord;
			  	}else if ($order == "name"){
			  		$sql = $sql. " order by user_name ".$ord;
			  	}else if ($order == "status"){
			  		$sql = $sql. " order by active ".$ord;
			  	}else{
			  		$sql = $sql. " order by user_id asc";
			  	}

			  	if (!empty($pno) && !empty($noi))
			  	{
			  		$start = $pno * noi;
			  		$end = $start + $noi;
			  		$sql = $sql. " limit ".$start. " , ".$end;
			  	}
				
			  	//print("SQL1:".$sql);
				$r1 = mysql_query($sql);
				if(!$r1) {
					$err=mysql_error();
					$msg = "Unable fetch user list at this time, please try again later. Error:".$err;
				}else{
					$count = 0;
					while($row = mysql_fetch_array($r1)){
						if ($count % 2) echo "<tr>";
						else echo "<tr class=\"alt\">";
							echo "<td>".$row['user_id']."</td>";
							echo "<td class=\"la\">".$row['user_fname']." ";
							echo "".$row['user_lname']."</td>";
							echo "<td><a href=\"updateuser.php?userid=".$row['user_id']."\">".$row['email']."</a></td>";
							echo "<td>".$row['role_desc']."</td>";
							echo "<td>".$row['organisation']."</td>";
							
							if ($row['active'] == 2) {
								echo "<td>Blocked</td>";
							}else if ($row['active'] == 0) {
								echo "<td>Inactive</td>";
							}else echo "<td>Active</td>";
							
                		echo "</tr>";
                		$count++;
					}
				}
	  		?>
	  <?php if ($sessionroleid == 1){?>
	  <tr><td colspan="7"><hr /></td></tr>
      <tr class="alt">
        <td colspan="7"><div class="divFilter">
        	<br/>
            <input name="Submit" type="submit" onclick="return activateUsers();" value="Activate Users" />
          </div></td>
      </tr>
      <tr>
        <td colspan="7"> This will activate users displayed in this list. Individual users can be activated by clicking on e-mail id.<br></td>
      </tr>
      <?php }}?>
    </table>
  </form>
  <!--  Display Area -->
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