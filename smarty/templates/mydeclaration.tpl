{include file="header.tpl"}
{include file="leftnav.tpl"}
<style>
			{literal}
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
			{/literal}
		</style>
		
<script type="text/javascript">highlight_nav(4);</script>

<!--  Display Area -->

<div id="divRHS">
  <h1 class="green">View My Declaration</h1>
  
    <table class="tblDeclarationTop">
    <tr>
      <td>   <font size="20"></font><b> Declaration History </b></font>
      		{if $decls != null} 
      		{foreach from=$decls item=dec}
				<br/><a href="mydeclaration.php?declid={$dec.decl_id}">{$dec.decl_id} - {$dec.decl_year}</a>
			{/foreach}
			{else}  : No Declaration History Available.<br/><br/>
           {/if} 
      </td>
    </tr>
  </table>
  
  <table class="tblDeclarationTop">
  	<tr><td><h1 class="green">Current Year Declaration</h1></td></tr>
    <tr>
      <td>
        {if $err_msg!=""}
        <div id=err>
          <h4>{$err_msg}</h4>
        </div>
        {else} <b>Declaration commenced</b> {$u_dec['decl_started_on']}</td>
      <td>{if $u_dec['decl_completed'] == "Y"}<b>Declaration completed</b> {$u_dec['decl_completed_on']}{/if}</td>
    </tr>
    <tr>
      <td> {if $u_dec['decl_completed'] == "N"} <b>Status : </b> Incomplete
        {else} <b>Status : </b> Completed
        {/if} </td>
    </tr>
  </table>
  <table class="tblDeclaration">
    {foreach from=$u_dec['sections'] item=sec}
    {if $sec['user_confirmed'] == 'N'}<tr><td id="delimiter" colspan="4">&nbsp;</td></tr>{/if}    
    <tr>
      <th class="section" colspan=4><b>{$sec['section_name']}</b>{if $sec['user_confirmed'] == 'N'}<div align="right">No</div>{/if}</th>
    </tr>
    {if $sec['user_confirmed'] == 'N'}<tr><td id="delimiter" colspan="4">&nbsp;</td></tr>{/if}
    {if $sec['user_confirmed'] == 'Y'}
    <tr>
      <th>Question</th>
      <th>Your Answer</th>
      <th>Rec. Answer</th>
      <th>Remarks</th>
    </tr>
    {/if}
    {if $sec['user_confirmed'] == 'Y'}
    {foreach from=$sec['qanda'] item=qa}
      {if $qa@index % 2} <tr>
      {else}<tr class="alt">
      {/if}
      <td class="question">{nl2br(htmlspecialchars($qa['question']))}</td>
      <td id="{$qa['result']}">{$qa['u_answer']}</td>
      {if $qa['result'] == "failed"}
      <td>{$qa['d_answer']}</td>
      <td class="message">{nl2br(htmlspecialchars($qa['f_msg']))}</td>
      {else}
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      {/if} </tr>
    {/foreach}
    {/if}
    
    {/foreach}
  </table>
  {/if}
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
{include file="footer.tpl"}
</div>
<!-- END OF #divPage -->
<div id="divPageBottom">
  <!-- -->
</div>
</div>
</body></html>