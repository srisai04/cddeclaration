<?php /* Smarty version Smarty-3.0.7, created on 2012-08-23 18:36:25
         compiled from "E:/xampp/htdocs\cddecv2\smarty\templates\mydeclaration.tpl" */ ?>
<?php /*%%SmartyHeaderCode:478550365c09d60a58-42544754%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4b607a828317971ca41e7598c076e201eb0f6d1' => 
    array (
      0 => 'E:/xampp/htdocs\\cddecv2\\smarty\\templates\\mydeclaration.tpl',
      1 => 1345735809,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '478550365c09d60a58-42544754',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("leftnav.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<style>
			
				#reptable{border: 1px black solid;}
				#repdelimiter{border-bottom:1px black solid;}
				#repheaders {
					font-weight: bold;
					border-top: 1px;
					border-bottom: 1px;
					border-top-style: solid;
					border-top-color: black;
					border-bottom-style: solid;
					border-bottom-color: black;
					white-space: nowrap;
					padding: 5px;
				}
				#reperr{color:red; font-weight:bold; font-size: 8pt;}
				#failed{color:red;}
				#passed{color:lime;}
			
		</style>
		
<script type="text/javascript">highlight_nav(4);</script>

<!--  Display Area -->

<div id="divRHS">
  <h1 class="green">View My Declaration</h1>
  
    <table class="tblDeclarationTop">
    <tr>
      <td>   <font size="20"></font><b> Declaration History </b></font>
      		<?php if ($_smarty_tpl->getVariable('decls')->value!=null){?> 
      		<?php  $_smarty_tpl->tpl_vars['dec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('decls')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dec']->key => $_smarty_tpl->tpl_vars['dec']->value){
?>
				<br/><a href="mydeclaration.php?declid=<?php echo $_smarty_tpl->tpl_vars['dec']->value['decl_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['dec']->value['decl_id'];?>
 - <?php echo $_smarty_tpl->tpl_vars['dec']->value['decl_year'];?>
</a>
			<?php }} ?>
			<?php }else{ ?>  : No Declaration History Available.<br/><br/>
           <?php }?> 
      </td>
    </tr>
  </table>
  
  <table class="tblDeclarationTop">
  	<tr><td><h1 class="green">Current Year Declaration</h1></td></tr>
    <tr>
      <td>
        <?php if ($_smarty_tpl->getVariable('err_msg')->value!=''){?>
        <div id=err>
          <h4><?php echo $_smarty_tpl->getVariable('err_msg')->value;?>
</h4>
        </div>
        <?php }else{ ?> <b>Declaration commenced</b> <?php echo $_smarty_tpl->getVariable('u_dec')->value['decl_started_on'];?>
</td>
      <td><?php if ($_smarty_tpl->getVariable('u_dec')->value['decl_completed']=="Y"){?><b>Declaration completed</b> <?php echo $_smarty_tpl->getVariable('u_dec')->value['decl_completed_on'];?>
<?php }?></td>
    </tr>
    <tr>
      <td> <?php if ($_smarty_tpl->getVariable('u_dec')->value['decl_completed']=="N"){?> <b>Status : </b> Incomplete
        <?php }else{ ?> <b>Status : </b> Completed
        <?php }?> </td>
    </tr>
  </table>
  <table class="tblDeclaration">
    <?php  $_smarty_tpl->tpl_vars['sec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('u_dec')->value['sections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sec']->key => $_smarty_tpl->tpl_vars['sec']->value){
?>
    <?php if ($_smarty_tpl->tpl_vars['sec']->value['user_confirmed']=='N'){?><tr><td id="delimiter" colspan="4">&nbsp;</td></tr><?php }?>    
    <tr>
      <th class="section" colspan=4><b><?php echo $_smarty_tpl->tpl_vars['sec']->value['section_name'];?>
</b><?php if ($_smarty_tpl->tpl_vars['sec']->value['user_confirmed']=='N'){?><div align="right">No</div><?php }?></th>
    </tr>
    <?php if ($_smarty_tpl->tpl_vars['sec']->value['user_confirmed']=='N'){?><tr><td id="delimiter" colspan="4">&nbsp;</td></tr><?php }?>
    <?php if ($_smarty_tpl->tpl_vars['sec']->value['user_confirmed']=='Y'){?>
    <tr>
      <th>Question</th>
      <th>Your Answer</th>
      <th>Rec. Answer</th>
      <th>Remarks</th>
    </tr>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['sec']->value['user_confirmed']=='Y'){?>
    <?php  $_smarty_tpl->tpl_vars['qa'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sec']->value['qanda']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['qa']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['qa']->key => $_smarty_tpl->tpl_vars['qa']->value){
 $_smarty_tpl->tpl_vars['qa']->index++;
?>
      <?php if ($_smarty_tpl->tpl_vars['qa']->index%2){?> <tr>
      <?php }else{ ?><tr class="alt">
      <?php }?>
      <td class="question"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['qa']->value['question']));?>
</td>
      <td id="<?php echo $_smarty_tpl->tpl_vars['qa']->value['result'];?>
"><?php echo $_smarty_tpl->tpl_vars['qa']->value['u_answer'];?>
</td>
      <?php if ($_smarty_tpl->tpl_vars['qa']->value['result']=="failed"){?>
      <td><?php echo $_smarty_tpl->tpl_vars['qa']->value['d_answer'];?>
</td>
      <td class="message"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['qa']->value['f_msg']));?>
</td>
      <?php }else{ ?>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <?php }?> </tr>
    <?php }} ?>
    <?php }?>
    
    <?php }} ?>
  </table>
  <?php }?>
  </td>
  </tr>
  </table>
  <!--  Display Area -->
</div>
<!-- END OF #divRHS -->
<div class="clear">
  <!-- -->
</div>
</div>
<!-- END OF #divFauxColumns -->
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>