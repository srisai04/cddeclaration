<div id="divFauxColumns">
	<div id="divLHS">
		<ul id="ulLeftNav">
			{if $sessionroleid == 1}
				<li><a id="aNav_1" href="home.php">Home</a><li>
				<li><a id="aNav_2" href="usermanagement.php">People</a><li>
				<li><a id="aNav_3" href="orgmanagement.php">Organisations</a><li>
				<li><a id="aNav_4" href="importexport.php">Import/Export</a><li>
				<li><a id="aNav_5" href="dashboards.php">Dashboards</a><li>
				<li><a id="aNav_6" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_7" href="notifications.php"">Messages</a><li>
				<li><a id="aNav_8" href="archivals.php">Archival</a><li>
			{else if $sessionroleid == 2 || $sessionroleid == 3}
				<li><a id="aNav_1" href="home.php">Home</a><li> 
				<li><a id="aNav_2" href="usermanagement.php">People</a><li> 
				<li><a id="aNav_3" href="importexport.php">Import/Export</a><li>
				<li><a id="aNav_4" href="dashboards.php">Dashboards</a><li>
				<li><a id="aNav_5" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_6" href="notifications.php"">Messages</a><li>
				<li><a id="aNav_7" href="archivals.php">Archival</a><li>
			{else if $sessionroleid == 4}
				<li><a id="aNav_1" href="home.php">Home</a><li> 
				<li><a id="aNav_2" href="updateuser.php?role=myaccount&userid={$sessionuserid}">My Account</a><li>
				<li><a id="aNav_3" href="introduction.php">Complete CD Declaration</a><li>
				<li><a id="aNav_4" href="mydeclaration.php">View CD Declaration</a><li>
				<!--li><a id="aNav_5" href="reportincident.php">Occurrences</a><li-->
				<li><a id="aNav_6" href="cdresources.php">CD Resources</a><li>
			{else if $sessionroleid == 5}
				<li><a id="aNav_1" href="home.php">Home</a><li>
				<li><a id="aNav_2" href="updateuser.php?role=myaccount&userid={$sessionuserid}">My Account</a><li>
				<li><a id="aNav_3" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_4" href="cdresources.php">CD Resources</a><li>
			{/if}
		</ul>
	</div>