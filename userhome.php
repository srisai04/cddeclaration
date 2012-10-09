<?php require ("inc/include.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CD Declaration Portal</title>
<script type="text/javascript" src="js/validations.js"></script>
</head>
<body>
<table border="1" width="80%">
	<tr><td colspan="2" align="center"><h3><span>Welcome <?php print($_SESSION['name']);?></span></h3></td></tr>
	<!-- tr><td colspan="2" align="center"><?php $msg = $_GET['msg'];echo "<font color=\"red\">" . $msg . "</font>";?></td></tr-->
	<tr>
		<?php $smarty->display('leftnav.tpl'); ?>
	<td width="70%" valign="top">
	
	<!-- Display Area -->
		  <form name="form2" method="post">
		  <table>
	  			<tr>
	                <td width="70%" valign="top">Welcome and Information Page..</td>
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
