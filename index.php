<?php 
if (isset($_GET['status']) && $_GET['status'] == 1){
		session_start();
		require "setpath.php";
		require "common.php";
		require "properties.php";
		require "connect.php";
		require "Smarty.php";
		
	$email = $_REQUEST['email'];
	$password = sha1($_REQUEST['password']);
	$sql="SELECT * FROM `users` a, `roles` r where `email`='$email' and `user_password`='$password' and a.role_id = r.role_id";
	//print("SQL:".$sql);
	$r = mysql_query($sql);
	
	if(!$r) {
		$err=mysql_error();
		//print("DB Error.");
		$msg = "Unable to authenticate at this time, please try again later.";
		//header("Location:index.php?msg="+$err);
	}else if ($row = mysql_fetch_assoc($r)) {
		if ($row['active'] == 1){
			//redirect to home page
			$_SESSION['userid']=$row['user_id'];
			$_SESSION['name']=$row['user_fname']." ".$row['user_lname'];
			$_SESSION['emailid']=$row['email'];
			$_SESSION['username']=$row['user_name'];
			$_SESSION['org_id']=$row['org_id'];
			$_SESSION['role_id']=$row['role_id'];
			$_SESSION['roledesc']=$row['role_desc'];
			
			$sql = "UPDATE users SET user_last_logged_on = now() WHERE user_id='".$row['user_id']."'";
			//print("SQL1:".$sql);
			$r1 = mysql_query($sql);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to update the profile at this time, please try again later. Error:".$err;
			}
			header("Location:home.php");
		}else{
			//print ("User Inactive");
			$msg="User name or password is incorrect, or your user account is inactive. Please contact your Administrator.";
		}
	}else{
		//Auth Failed, redirect to login
		//print ("Authentication Failed");
		$msg = "User name or password is incorrect. Please enter valid authentication details.";
	}

		// Free the resources associated with the result set
		// This is done automatically at the end of the script
		@mysql_free_result($r);
		@mysql_close();
		
	}else{
		require "setpath.php";
		require "Smarty.php";
	}

	$smarty->assign("sessionroleid",null);
	$smarty->display('header.tpl');

?>

<div id="divNoRHS_LHS">
  <form name="form2" method="post">
    <table class="tblFormlogin">
    <tr><td>&nbsp;</td></tr>
      <tr>
      <td>
      	<h1 class="green">Login to the Controlled Drugs Declaration Website</h1>
      </td>
      </tr>
      <tr>
        <td><?php if (isset($msg)){echo "<font color=\"red\">" . $msg . "</font>";}?></td>
      </tr>
      <tr>
        <td><label for="email">E-Mail Id:</label>
          <input type="text" name="email" size="30"/>
          <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td><label for="password">Password:</label>
          <input type="password" name="password" size="30"/>
          <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="buttons">
        	<div class="divFilterlogin">
            	<input name="Submit" onclick="return validateLogin();" type="button" value="Login" />
            </div>
         </td>
      </tr>
      <tr>
        <td>
          Forgot Password? Please reset <a href="forgotpwd.php">here</a>
        </td>
      </tr>
      <tr>
        <td>New User? Please register <a href="registration.php?anonym=1">here</a></td>
      </tr>
      <!--tr>
        <td>Want to report an incident? Please report <a href="reportincident.php?anonym=1">here</a></td>
      </tr-->
    </table>
  </form>
  <!--  Display Area -->
</div> <!-- END OF #div no RHS_LHS -->

<div class="clear">  <!-- --> </div>

<?php $smarty->display("footer.tpl");?>
	
</div> <!-- END OF #divPage -->

<div id="divPageBottom">  <!-- --> </div>

</div>
</body>
</html>