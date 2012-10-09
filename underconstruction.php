<?php include("setpath.php");
	  require("Smarty.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CD Declaration Portal - Registration</title>
<script type="text/javascript" src="js/validations.js"></script>
</head>
<body">
<?php
	$page = $_GET['page'];
?>


<table border="1" width="80%" align="center">
	<tr><td align="center"><h3><span>This feature will be included soon. Please visit again.</span></h3></td></tr>
	<tr><td align="center"><br/><a href="javascript:history.back()">Back</a></td></tr>
	<tr><td>
	
	<!-- Display Area -->
		  <table width="65%" align="center">
                <tr>
	                <td><label for="pin">Message:</label></td>
	                <td><font color="red"><?php echo "$page"?> Page will be up soon, stay tuned.</font></td>
                </tr>
                
          </table>
   <!-- Display Area -->
   
   </td></tr>
   <tr><td align="center"><?php $smarty->display('footer.tpl');?></td></tr>
</table>
</body>
</html>