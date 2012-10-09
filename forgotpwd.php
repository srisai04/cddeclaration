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

<div id="divNoRHS_LHS">

<?php 
	if (isset($_REQUEST['email']))$emailid=htmlspecialchars($_REQUEST['email']);else $emailid="";

	$msg = "";
	if (isset($_GET['status'])){
		$status = $_GET['status'];
		if ($status == 1){
			//Mail password
			$sql = "SELECT * from users where email='".$emailid."'";
			//echo "SQL1:".$sql;
			$r1 = mysql_query($sql);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to lookup the user at this time, please try again later. Error:".$err;
			}else if ($row = mysql_fetch_assoc($r1)) {
				$emailid = $row['email'];
				//Deliver e-mail
					// Generate randon number.
					$pwd = rand(1000,9000);
					//echo "New Password:".$pwd."\r\n";//
					$sql = "UPDATE users set user_password='".sha1($pwd)."' where email='".$emailid."'";
					//print ("SQL:".$sql);
					$r = mysql_query($sql);
					if(!$r) {
						$err=mysql_error();
						$msg = "Unable to reset your password at this time, please try again later. Error:".$err;
					}else{
						 $subject = "Your new CD declaration password";
						 $body = "Your password has been reset to ".$pwd.". Please login at ".$resetpwd." and change password.";
						 $headers = "From: ".$adminmailid."\r\n" ."X-Mailer: php";
						 if (mail($emailid, $subject, $body, $headers)) {
						    $msg = "Your password is reset and new password is mailed to your e-mail id.";
						  } else {
						    $msg = "Unable to send mail at this time, please try again later.";
						  }
					}
			}else{
				$msg = "Unable to find the user account. Please verify the email id.";
			}
		}
	}
?>

	<form name="form2" method="post" action="forgotpwd.php">
	  <table class="tblFormlogin">
	    <tr><td>&nbsp;</td></tr>
	  	<tr><td><h1 class="green">Forgot Password</h1></td></tr>
		<tr><td><?php echo "<font color=\"red\">" . $msg . "</font>";?></td></tr>
		<tr>
           <td>E-Mail ID:
	           <input name="email" type="text" size="30"/><font color="red">*</font>
           </td>
        </tr>
        <tr>
           <td class="buttons">
           	  <div class="divFilterlogin">
	           <input type="button" onclick="return forgotPwd();" value="Reset" />
           	  </div>
           </td>
        </tr>
        <tr>
        	<td>Login <a href="index.php">here</a></td>
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