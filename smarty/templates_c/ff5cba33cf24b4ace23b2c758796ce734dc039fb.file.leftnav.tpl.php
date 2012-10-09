<?php /* Smarty version Smarty-3.0.7, created on 2012-08-23 18:30:18
         compiled from "E:/xampp/htdocs\cddecv2\smarty\templates\leftnav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:34450365a9a19d7f2-33859278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff5cba33cf24b4ace23b2c758796ce734dc039fb' => 
    array (
      0 => 'E:/xampp/htdocs\\cddecv2\\smarty\\templates\\leftnav.tpl',
      1 => 1345735810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34450365a9a19d7f2-33859278',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divFauxColumns">
	<div id="divLHS">
		<ul id="ulLeftNav">
			<?php if ($_smarty_tpl->getVariable('sessionroleid')->value==1){?>
				<li><a id="aNav_1" href="home.php">Home</a><li>
				<li><a id="aNav_2" href="usermanagement.php">People</a><li>
				<li><a id="aNav_3" href="orgmanagement.php">Organisations</a><li>
				<li><a id="aNav_4" href="importexport.php">Import/Export</a><li>
				<li><a id="aNav_5" href="dashboards.php">Dashboards</a><li>
				<li><a id="aNav_6" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_7" href="notifications.php"">Messages</a><li>
				<li><a id="aNav_8" href="archivals.php">Archival</a><li>
			<?php }elseif($_smarty_tpl->getVariable('sessionroleid')->value==2||$_smarty_tpl->getVariable('sessionroleid')->value==3){?>
				<li><a id="aNav_1" href="home.php">Home</a><li> 
				<li><a id="aNav_2" href="usermanagement.php">People</a><li> 
				<li><a id="aNav_3" href="importexport.php">Import/Export</a><li>
				<li><a id="aNav_4" href="dashboards.php">Dashboards</a><li>
				<li><a id="aNav_5" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_6" href="notifications.php"">Messages</a><li>
				<li><a id="aNav_7" href="archivals.php">Archival</a><li>
			<?php }elseif($_smarty_tpl->getVariable('sessionroleid')->value==4){?>
				<li><a id="aNav_1" href="home.php">Home</a><li> 
				<li><a id="aNav_2" href="updateuser.php?role=myaccount&userid=<?php echo $_smarty_tpl->getVariable('sessionuserid')->value;?>
">My Account</a><li>
				<li><a id="aNav_3" href="introduction.php">Complete CD Declaration</a><li>
				<li><a id="aNav_4" href="mydeclaration.php">View CD Declaration</a><li>
				<!--li><a id="aNav_5" href="reportincident.php">Occurrences</a><li-->
				<li><a id="aNav_6" href="cdresources.php">CD Resources</a><li>
			<?php }elseif($_smarty_tpl->getVariable('sessionroleid')->value==5){?>
				<li><a id="aNav_1" href="home.php">Home</a><li>
				<li><a id="aNav_2" href="updateuser.php?role=myaccount&userid=<?php echo $_smarty_tpl->getVariable('sessionuserid')->value;?>
">My Account</a><li>
				<li><a id="aNav_3" href="viewincident.php">Occurrences</a><li>
				<li><a id="aNav_4" href="cdresources.php">CD Resources</a><li>
			<?php }?>
		</ul>
	</div>