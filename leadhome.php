<?php require("inc/include.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CD Declaration Portal</title>
<script type="text/javascript" src="js/validations.js"></script>
</head>
<body>
<table border="1" width="80%">
	<tr><td colspan="2" align="center"><h3><span>Welcome <?php print($_SESSION['name']);?></span></h3></td></tr>
	<tr><td colspan="2" align="center">
	<?php 
	 if(isset($_GET['msg']))$msg = $_GET['msg'];else $msg = "";	echo "<font color=\"red\">" . $msg . "</font>";?></td></tr>
	<tr>
	<?php 
		if (isset($_POST['status']))$status = $_POST['status'];else $status = "";
		$msg = "";
	
		$smarty->display('leftnav.tpl');
	?>
	<td width="70%" width="70%" valign="top">
	
	<!-- Display Area -->
		  <form name="form2" method="post">
		  <table>
			  <?php 
			  		$sessionorgid = $_SESSION['org_id'];
			  		$sessionroleid = $_SESSION['role_id'];
			  		
			  		if ($status == 1){
						//Activate All users
						if ($sessionroleid == 2) $sql = "UPDATE users SET active=1 where org_id='".$sessionorgid."'";
						else if ($sessionroleid == 3)$sql = "UPDATE users SET active=1 where org_id='".$sessionorgid."' and role_id ='4'";
						//print("SQL1:".$sql);
						$r = mysql_query($sql);
						if(!$r) {
							$err=mysql_error();
							$msg = "Unable to activate the users at this time. Please try again later.";
						}else{
							$msg = "All inactive users have been activated.";
						}
					}
			  		
	  				echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">ID</td>";
					echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">Name</td>";
					echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">User Name</td>";
					echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">Role</td>";
					echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">Organization</td>";
					echo "<td width=\"10%\" align=\"center\" bgcolor=\"blue\">Status</td>";
					
					if ($sessionroleid == 3){
						$sql = "SELECT * from users, roles, organisations where users.role_id = roles.role_id and users.org_id = organisations.org_id and users.org_id = '".$sessionorgid."' and users.role_id = '4' order by user_id limit 0, 30";
					}else{
				  		$sql = "SELECT * from users, roles, organisations where users.role_id = roles.role_id and users.org_id = organisations.org_id and users.org_id = '".$sessionorgid."' order by user_id limit 0, 30";
					}
				  	//print("SQL1:".$sql);
					$r1 = mysql_query($sql);
					if(!$r1) {
						$err=mysql_error();
						$msg = "Unable register at this time, please try again later. Error:".$err;
					}else{
						while($row = mysql_fetch_array($r1)){
						echo "<tr>";
								echo "<td width=\"10%\" align=\"center\">".$row['user_id']."</td>";
								echo "<td width=\"10%\" align=\"left\"><a href=\"updateuser.php?userid=".$row['user_id']."\">".$row['user_fname']." ".$row['user_lname']."</a></td>";
								echo "<td width=\"10%\" align=\"left\">".$row['user_name']."</td>";
								echo "<td width=\"10%\" align=\"left\">".$row['role_desc']."</td>";
								echo "<td width=\"10%\" align=\"left\">".$row['organisation']."</td>";
								echo "<td width=\"10%\" align=\"center\">".$row['active']."</td>";
	                	echo "</tr>";
						}
					}
		  		?>
		        <tr>
                	<td colspan="6" align="right">
	                	This will activate organization wide users. Individual users can be activated by clicking on Name
	                	<input type="hidden" name="status" value="1"/>
	                	<button type="submit">Activate All</button>
	                </td>
                </tr>
		  
          </table>
          </form>
   <!-- Display Area -->
   
   </td>
   </tr>
   <tr><td colspan="2" align="center"><?php $smarty->display('footer.tpl');?></td></tr>
</table>
</body>
</html>
