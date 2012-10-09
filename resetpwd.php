<?php 	
	require "setpath.php";
	require "common.php";
	require "properties.php";
	require "connect.php";
	require "Smarty.php"; 

	//require("_includes/header.inc");
	$smarty->assign("sessionroleid",null);
	$smarty->display("header.tpl");
?>
<!--  Display Area -->
<link href="_css/main_stylesheet.css" rel="stylesheet" type="text/css" />

<div id="divRHS">

<?php 
	if (isset($_REQUEST['email']))$emailid=htmlspecialchars($_REQUEST['email']);else $emailid="";
	if (isset($_POST['resetpwd']))$resetpwd=htmlspecialchars($_POST['resetpwd']);else $resetpwd="";
	if (isset($_POST['password']))$password=htmlspecialchars($_POST['password']);else $password="";
	if (isset($_POST['confirm']))$confirm=htmlspecialchars($_POST['confirm']);else $confirm="";
	
	$msg = "";
	if (isset($_GET['status'])){
		$status = $_GET['status'];
		if ($status == 1){
			//Mail password
			$pwd = sha1($resetpwd);
			$sql = "SELECT * from users where email='".$emailid."' and user_password='".$pwd."'";
			//echo "SQL1:".$sql;
			$r1 = mysql_query($sql);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to lookup the user at this time, please try again later. Error:".$err;
			}else if ($row = mysql_fetch_assoc($r1)) {
				$emailid = $row['email'];
				//Deliver e-mail
					// Generate randon number.
					$pwd = sha1($password);
					//echo "New Password:".$pwd."\r\n";
					$sql = "UPDATE users set user_password='".$pwd."', imported='0' where email='".$emailid."'";
					//print ("SQL:".$sql);
					$r = mysql_query($sql);
					if(!$r) {
						$err=mysql_error();
						$msg = "Unable to reset your password at this time, please try again later. Error:".$err;
					}else{
					$msg = "Your Password is changed.";
					}
			}else{
				$msg = "Unable to find the user account. Please verify the email id and reset password.";
			}
		}
	}
?>

	<form name="form2" method="post" action="resetpwd.php">
	  <table class="tblForm">
	    <tr><td>&nbsp;</td></tr>
	  	<tr><td colspan="2"><h1 class="green">Reset Password</h1></td></tr>
		<tr><td colspan="2"><?php if (isset($_REQUEST['status']))echo "<font color=\"red\">" . $msg . "<a href=\"index.php\"> Please login here.</a></font>";?></td></tr>
		<tr>
		   <td style="width: 200px;"><label for="email">E-Mail ID:</label></td>
           <td><input name="email" type="text" value="<?php echo "$emailid"?>" size="30"/><font color="red">*</font></td>
        </tr>
            <tr>
              <td style="width: 200px;"><label for="resetpwd">Old Password:</label></td>
              <td><input name="resetpwd" type="password" value="<?php echo "$resetpwd"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
        	<tr>
              <td style="width: 200px;"><label for="password">New Password:</label></td>
              <td><input name="password" type="password" value="<?php echo "$password"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
            <tr>
              <td style="width: 200px;"><label for="confirm">Confirm New Password:</label></td>
              <td><input name="confirm" type="password" value="<?php echo "$confirm"?>" size="30"/>
                <font color="red">*</font></td>
            </tr>
        <tr>
           <td class="buttons" colspan="2">
	           <input type="button" onclick="return resetPwd();" value="Change Password" />
           </td>
        </tr>
		</table>
		</form>

  <!--  Display Area -->

</div> <!-- END OF #divRHS -->
		
		<div class="clear"><!-- --></div>
	
		<?php //require("_includes/footer.inc"); 
			$smarty->display("footer.tpl");
		?>
		
			</div> <!-- END OF #divPage -->
			
			<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html> 