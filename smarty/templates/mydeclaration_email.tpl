<html>
  <head>
    <title>{$appname}</title>
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
  </head>
  <body>

				<table border="0" width=960 id=reptable>
					<tr>
						<td colspan=2 width=50%>
							<b>Declaration commenced</b>  {$u_dec['decl_started_on']}
							{if $u_dec['decl_completed'] == "N"}
								<br><b>Status : </b> Incomplete
							{else}
								<br><b>Status : </b> Completed
							{/if}
						</td>
						<td colspan=2 width=50%>{if $u_dec['decl_completed'] == "Y"}<b>Declaration completed</b>  {$u_dec['decl_completed_on']}{/if}</td>
					</tr>
					{foreach from=$u_dec['sections'] item=sec}
						{if $sec['qanda']}
							<tr><td colspan=4 id=repdelimiter>&nbsp;</td></tr>
							<tr>
								<td colspan=4><b>{$sec['section_name']}</b>{if $sec['user_confirmed'] == 'N'}(skipped){/if}</td>
							</tr>	
							{if $sec['user_confirmed'] == 'Y'}
								<tr>
									<td id=repheaders>Question</td>
									<td id=repheaders>Your Answer</td>
									<td id=repheaders>Recommeded Answer</td>
									<td id=repheaders>Remarks</td>
								</tr>
							{/if}
							{if $sec['user_confirmed'] == 'Y'}
								{foreach from=$sec['qanda'] item=qa}
									<tr>
										<td>{$qa['question']}</td>
										<td id="{$qa['result']}">{$qa['u_answer']}</td>
										{if $qa['result'] == "failed"}
											<td>{$qa['d_answer']}</td>
											<td>{$qa['f_msg']}</td>
										{else}
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										{/if}
									</tr>
								{/foreach}
							{/if}
						{/if}
					{/foreach}
				</table>

  </body>
</html>
