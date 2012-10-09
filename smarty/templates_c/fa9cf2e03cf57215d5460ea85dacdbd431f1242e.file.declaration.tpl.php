<?php /* Smarty version Smarty-3.0.7, created on 2012-08-23 18:36:28
         compiled from "E:/xampp/htdocs\cddecv2\smarty\templates\declaration.tpl" */ ?>
<?php /*%%SmartyHeaderCode:501450365c0cc92d95-26346044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa9cf2e03cf57215d5460ea85dacdbd431f1242e' => 
    array (
      0 => 'E:/xampp/htdocs\\cddecv2\\smarty\\templates\\declaration.tpl',
      1 => 1345735812,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '501450365c0cc92d95-26346044',
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
			
				#frmtable{border: 1px black solid;}
				#frmdelimiter{border-bottom:1px black solid;}
				#err{color:red; font-weight:bold; font-size: 8pt;}
				.hidenotes{display:none;}
				.shownotes{display:block;}
			
		</style>

<script type="text/javascript">highlight_nav(3);</script>

<!--  Display Area -->
<div id="divRHS">

<h1 class="green">CD Declaration</h1>
	
	<table class="tblForm">
	<!-- tr><td colspan="2" align="center"><font color="red"><?php echo $_smarty_tpl->getVariable('msg')->value;?>
</font></td></tr-->
	<tr>
	<td width="70%" valign="top">

	<?php if ($_smarty_tpl->getVariable('completed_msg')->value!=''){?>
		<h4><?php echo $_smarty_tpl->getVariable('completed_msg')->value;?>
</h4>
	<?php }else{ ?>
	<form name=frm method=POST onSubmit="return validate();">
	<input type=hidden name=section_id value=<?php echo $_smarty_tpl->getVariable('section')->value['section_id'];?>
>
	<input type=hidden name=decl_id value=<?php echo $_smarty_tpl->getVariable('decl_id')->value;?>
>
	<table class="frmForm" id=frmtable>
	<tr>
	<td><h2 class="green"><?php echo $_smarty_tpl->getVariable('section')->value['section_name'];?>
</h2></td>
	</tr>
	<tr>
	<td><?php echo $_smarty_tpl->getVariable('section')->value['user_confirmation_text'];?>
</td>
	</tr>
	<tr>
	<td>Yes&nbsp;&nbsp;<input type=radio name=choice value=yes onclick="toggleSectionQuestions(0,this);">
	&nbsp;&nbsp;&nbsp;No&nbsp;&nbsp;<input type=radio name=choice value=no onclick="toggleSectionQuestions(1,this);">
	</td>
	</tr>

		<tr>
			<td>
	<div id="questions" style="display:none;">
				<table border="0" width=840 id=frmtable>
					<?php  $_smarty_tpl->tpl_vars['dec'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('decls')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['dec']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['dec']->key => $_smarty_tpl->tpl_vars['dec']->value){
 $_smarty_tpl->tpl_vars['dec']->index++;
?>
					<tr>
					<td width="400"><input type=hidden name=qid_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 value=<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
><image src="_images/help.jpg" width="15" height="15" title="<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_tip'];?>
"></image><?php echo $_smarty_tpl->tpl_vars['dec']->index+1;?>
) <?php echo $_smarty_tpl->tpl_vars['dec']->value['question'];?>
</td>
					<td width="300" align=left>
					<?php if (count($_smarty_tpl->tpl_vars['dec']->value['ansdata'])>1){?>
					<?php  $_smarty_tpl->tpl_vars['ans'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dec']->value['ansdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ans']->key => $_smarty_tpl->tpl_vars['ans']->value){
?>
					<div style="clear:both;">
					<?php if ($_smarty_tpl->tpl_vars['dec']->value['multiple']=="Y"){?>
					<input type=checkbox name=aid_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
[] value=<?php echo $_smarty_tpl->tpl_vars['ans']->value['answer_id'];?>

					<?php }else{ ?>
					<input type=radio name=aid_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 value=<?php echo $_smarty_tpl->tpl_vars['ans']->value['answer_id'];?>

					<?php }?>
					onclick=togglenotes(<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
,'<?php echo $_smarty_tpl->tpl_vars['ans']->value['unhide_notes'];?>
','<?php echo $_smarty_tpl->tpl_vars['ans']->value['answer_id'];?>
');><?php echo $_smarty_tpl->tpl_vars['ans']->value['answer'];?>

					<input type="hidden" name="unhide_notes_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['ans']->value['answer_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['ans']->value['unhide_notes'];?>
">
					</div>
					<?php }} ?>
					<?php }else{ ?>
					<input type=hidden name=aid_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 value=<?php echo $_smarty_tpl->tpl_vars['dec']->value['ansdata'][0]['answer_id'];?>
>
					&nbsp;&nbsp;&nbsp;Please type-in your answer<br>&nbsp;&nbsp;&nbsp;in the adjacent text box
					<?php }?>
					</td>
					<td<?php if ($_smarty_tpl->tpl_vars['dec']->value['hide_notes']=="Y"){?> id=notes_container_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 class=hidenotes<?php }?>><?php echo $_smarty_tpl->tpl_vars['dec']->value['notes_label'];?>
<br><br>
					<input type=hidden name=hide_notes_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 value=<?php echo $_smarty_tpl->tpl_vars['dec']->value['hide_notes'];?>
>
					<input type=hidden name=multiple_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
 value=<?php echo $_smarty_tpl->tpl_vars['dec']->value['multiple'];?>
>
					<textarea cols=25 rows=3 name=notes_<?php echo $_smarty_tpl->tpl_vars['dec']->value['question_id'];?>
></textarea>
					</td>
					</tr>
					<tr><td colspan=3 id=frmdelimiter>&nbsp;</td></tr>
					<?php }} ?>
					<!-- <tr><td colspan=3 align=center><input type=submit value="Submit Declaration" name=submit/></td></tr> -->
				</table>
	</div>
			</td>
		</tr>
	<tr>
	<td align="right">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=submit value="Continue >>">
	</td>
	</tr>
	</table>
	</form>
	<?php }?>
	</td>
	</tr>
	</table>

<!--  Display Area -->

	</div> <!-- END OF #divRHS -->
	
	<div class="clear"><!-- --></div>
	
	</div> <!-- END OF #divFauxColumns -->

	<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	</div> <!-- END OF #divPage -->
	
	<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>

