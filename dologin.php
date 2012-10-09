<?php session_start();
	require "setpath.php";
	require "common.php";
	require "properties.php";
	require "connect.php";

	$username = htmlspecialchars($_POST['username']);
	$password = sha1(htmlspecialchars($_POST['password']));
	$sql="SELECT * FROM `users` a, `roles` r where `user_name`='$username' and `user_password`='$password' and a.role_id = r.role_id";
	//print("SQL:".$sql);
	$r = mysql_query($sql);
	
	if(!$r) {
		$err=mysql_error();
		//print("DB Error.");
		header("Location:index.php?msg="+$err);
	}else if ($row = mysql_fetch_assoc($r)) {
		if ($row['active'] == 1){
			//redirect to home page
			$_SESSION['userid']=$row['user_id'];
			$_SESSION['name']=$row['user_fname']." ".$row['user_lname'];
			$_SESSION['username']=$row['user_name'];
			$_SESSION['org_id']=$row['org_id'];
			$_SESSION['role_id']=$row['role_id'];
			$_SESSION['roledesc']=$row['role_desc'];
			//print ("Successful Login");
			header("Location:home.php");
		}else{
			//print ("User Inactive");
			header("Location:index.php?msg=User name or password is incorrect, or your user account is inactive. Please contact your Administrator.");
		}
	}else{
		//Auth Failed, redirect to login
		//print ("Authentication Failed");
		header("Location:index.php?msg=User name or password is incorrect. Please enter valid authentication details.");
	}

	// Free the resources associated with the result set
	// This is done automatically at the end of the script
	@mysql_free_result($r);
	@mysql_close();
?>