<?php 
	require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	//$smarty->display("leftnav.tpl");

	if (isset($_REQUEST['fromdate']))$fromdate=htmlspecialchars($_REQUEST['fromdate']);else $fromdate="";
	if (isset($_REQUEST['todate']))$todate=htmlspecialchars($_REQUEST['todate']);else $todate="";
?>


<div id="divRHS">
	<form name="dtform">
	<div class="tcal">
	<table>
      <tr>
        <td>
			<?php 
				$formname = "dtform";
				echo "From Date:";
				$inputname = "fromdate";
			?>
		</td>
	     <td colspan="4">
	        <?php 
		        $value = $fromdate;
				require ('mycalendar.php');
				echo "  To Date:";
				$inputname = "todate";
				$value = $todate;
				require ('mycalendar.php');
			?>
		</td>
	   </tr>
	</table>
	</div>
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
</body>
</html>
