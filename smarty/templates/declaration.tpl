{include file="header.tpl"}
{include file="leftnav.tpl"}

		<style>
			{literal}
				#frmtable{border: 1px black solid;}
				#frmdelimiter{border-bottom:1px black solid;}
				#err{color:red; font-weight:bold; font-size: 8pt;}
				.hidenotes{display:none;}
				.shownotes{display:block;}
			{/literal}
		</style>

<script type="text/javascript">highlight_nav(3);</script>

<!--  Display Area -->
<div id="divRHS">

<h1 class="green">CD Declaration</h1>
	
	<table class="tblForm">
	<!-- tr><td colspan="2" align="center"><font color="red">{$msg}</font></td></tr-->
	<tr>
	<td width="70%" valign="top">

	{if $completed_msg != ""}
		<h4>{$completed_msg}</h4>
	{else}
	<form name=frm method=POST onSubmit="return validate();">
	<input type=hidden name=section_id value={$section['section_id']}>
	<input type=hidden name=decl_id value={$decl_id}>
	<table class="frmForm" id=frmtable>
	<tr>
	<td><h2 class="green">{$section['section_name']}</h2></td>
	</tr>
	<tr>
	<td>{$section['user_confirmation_text']}</td>
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
					{foreach from=$decls item=dec}
					<tr>
					<td width="400"><input type=hidden name=qid_{$dec['question_id']} value={$dec['question_id']}><image src="_images/help.jpg" width="15" height="15" title="{$dec['question_tip']}"></image>{$dec@index + 1}) {$dec['question']}</td>
					<td width="300" align=left>
					{if $dec['ansdata']|@count > 1}
					{foreach from=$dec['ansdata'] item=ans}
					<div style="clear:both;">
					{if $dec['multiple'] == "Y"}
					<input type=checkbox name=aid_{$dec['question_id']}[] value={$ans['answer_id']}
					{else}
					<input type=radio name=aid_{$dec['question_id']} value={$ans['answer_id']}
					{/if}
					onclick=togglenotes({$dec['question_id']},'{$ans['unhide_notes']}','{$ans['answer_id']}');>{$ans['answer']}
					<input type="hidden" name="unhide_notes_{$dec['question_id']}_{$ans['answer_id']}" value="{$ans['unhide_notes']}">
					</div>
					{/foreach}
					{else}
					<input type=hidden name=aid_{$dec['question_id']} value={$dec['ansdata'][0]['answer_id']}>
					&nbsp;&nbsp;&nbsp;Please type-in your answer<br>&nbsp;&nbsp;&nbsp;in the adjacent text box
					{/if}
					</td>
					<td{if $dec['hide_notes'] == "Y"} id=notes_container_{$dec['question_id']} class=hidenotes{/if}>{$dec['notes_label']}<br><br>
					<input type=hidden name=hide_notes_{$dec['question_id']} value={$dec['hide_notes']}>
					<input type=hidden name=multiple_{$dec['question_id']} value={$dec['multiple']}>
					<textarea cols=25 rows=3 name=notes_{$dec['question_id']}></textarea>
					</td>
					</tr>
					<tr><td colspan=3 id=frmdelimiter>&nbsp;</td></tr>
					{/foreach}
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
	{/if}
	</td>
	</tr>
	</table>

<!--  Display Area -->

	</div> <!-- END OF #divRHS -->
	
	<div class="clear"><!-- --></div>
	
	</div> <!-- END OF #divFauxColumns -->

	{include file="footer.tpl"}
	
	</div> <!-- END OF #divPage -->
	
	<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>

