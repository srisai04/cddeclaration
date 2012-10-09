<?php require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display('leftnav.tpl');
	//require("_includes/leftnav.inc");
?>

<script type="text/javascript">highlight_nav(3);</script>

<!--  Display Area --><div id="divRHS">
	
<h1 class="green">CD Declaration Website</h1>

<p>You are about to complete your Controlled Drugs Self Declaration. </p>
<p>&nbsp;</p>
<p>READ THE NOTES BELOW BEFORE PROGRESSING.</p>
<ul>
  <li>This will take between 20-45mins, depending on your involvement with CDs.</li>
  <li> There are 8 sections </li>
  <li> <u><strong>You cannot change your cd once you have moved from one section to the next section (e.g. from Section 1 to Section 2). </strong></u></li>
  <li> So take your time and answer carefully.  Check your answers before you move to the next section.</li>
  <li> You only have to complete those sections which are relevant to your practice.</li>
  <li> Your practice includes both your NHS work, and any other private or associated practice. </li>
  <li> The first question of each section checks whether that section is relevant to you. 
    <ul>
      <li> If it is, click yes, and answer the questions that will scroll down the page.</li>
      <li>If it is not, click no, and move onto the next section.</li>
      </ul>
  </li>
  <li>If you click yes, you have to answer all the questions in that section before moving onto the next section.</li>
  </ul>
<p>&nbsp;</p>
<p><strong>Within each section are a number of questions that will assess your current practice when dealing with controlled drugs.  You only have to complete the sections relevant to your practice.  For example, if you do not prescribe controlled drugs, you do not need to complete Section 1 (which contains 9 questions within it). </strong></p>
<p><strong>Section 1: Prescribing<br />
  Section 2: Supply<br />
  Section 3: Administration<br />
  Section 4A: Security or safe custody<br />
  Section 4B: Security and safe custody in transport<br />
  Section 4C: Registers<br />
  Section 5A: Destruction or disposal<br />
  Section 5B: Stock CDs<br />
</strong></p>


<ul>
	<br/><a href="Controlled Drugs Self Declaration Questions.pdf" target="newwindow">Download full list of self declaration questions</a><br/>
</ul>

  <form name="form3" method="post">
  	<table class="tblForm">
  	<tr>
  		<td align="right">
		    <input type="button"  onClick="javascript:startDeclaration();" value="Start Declaration >>" />
	  </td>
	  </tr>
    </table>
  </form>

<!--  Display Area -->

</div> <!-- END OF #divRHS -->
		
		<div class="clear"><!-- --></div>
		
		</div> <!-- END OF #divFauxColumns -->
		
		<?php $smarty->display("footer.tpl");?>
		
			</div> <!-- END OF #divPage -->
			
			<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>