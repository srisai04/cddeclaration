<?php require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display('leftnav.tpl');
?>

<script type="text/javascript">highlight_nav(1);</script>

<!--  Display Area -->
<div id="divRHS">

<h1 class="green">My Dashboard</h1>

<ul class="ulAccountIcons">
	<?php if ($sessionroleid == 1){?>
		<li>
			<a href="usermanagement.php"><img src="_images/account/account.jpg" />People</a>
		</li>
		<li>
			<a href="orgmanagement.php"><img src="_images/account/org.jpg" />Organisations</a>
		</li>
		<li>
			<a href="importexport.php"><img src="_images/account/import.jpg" />Import/Export</a>
		</li>
		<li>
			<a href="dashboards.php"><img src="_images/account/graphs.jpg" />Dashboards</a>
		</li>
		<li>
			<a href="viewincident.php"><img src="_images/account/report.jpg" />Occurrences</a>
		</li>
		<li>
			<a href="notifications.php""><img src="_images/account/notification.jpg" />Messages</a>
		</li>
		<li>
			<a href="archivals.php""><img src="_images/account/archive1.jpg" />Archival</a>
		</li>
	<?php }else if ($sessionroleid == 2 || $sessionroleid == 3){?>
		<li>
			<a href="usermanagement.php"><img src="_images/account/account.jpg" />People</a>
		</li>
		<li>
			<a href="importexport.php"><img src="_images/account/import.jpg" />Import/Export</a>
		</li>
		<li>
			<a href="dashboards.php"><img src="_images/account/graphs.jpg" />Dashboards</a>
		</li>
		<li>
			<a href="viewincident.php"><img src="_images/account/report.jpg" />Occurrences</a>
		</li>
		<li>
			<a href="notifications.php""><img src="_images/account/notification.jpg" />Messages</a>
		</li>
		<li>
			<a href="archivals.php""><img src="_images/account/archive1.jpg" />Archival</a>
		</li>
	<?php }else if ($sessionroleid == 4){?>
	<li>
		<?php echo "<a href=\"updateuser.php?role=myaccount&userid=".$sessionuserid."\"><img src=\"_images/account/account.jpg\"/>My Account</a>";?>
	</li>
	<li>
		<a href="declaration.php"><img src="_images/account/complete.jpg" class="twoline" />Complete CD Declaration</a>
	</li>
	<li>
		<a href="mydeclaration.php"><img src="_images/account/view.jpg" />View CD Declaration</a>
	</li>
	<!--li>
		<a href="reportincident.php"><img src="_images/account/report.jpg" />Occurrences</a>
	</li-->
	<li>
		<a href="cdresources.php"><img src="_images/account/resources.jpg" />CD Resources</a>
	</li>
	<?php }else if ($sessionroleid == 5){?>
	<li>
		<?php echo "<a href=\"updateuser.php?role=myaccount&userid=".$sessionuserid."\"><img src=\"_images/account/account.jpg\"/>My Account</a>";?>
	</li>
	<li>
		<a href="viewincident.php"><img src="_images/account/report.jpg" />Occurrences</a>
	</li>
	<li>
		<a href="cdresources.php"><img src="_images/account/resources.jpg" />CD Resources</a>
	</li>
	<?php }?>
	<!--li>
		<a href="logout.php">
			<img src="_images/account/logout.jpg" />
			Log Out
		</a>
	</li-->
</ul>

<!--  Display Area -->

		</div> <!-- END OF #divRHS -->
		
		<div class="clear"><!-- --></div>
		
		</div> <!-- END OF #divFauxColumns -->
		
		<?php $smarty->display("footer.tpl"); ?>
		
			</div> <!-- END OF #divPage -->
			
			<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>