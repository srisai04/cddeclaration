<?php require ("inc/include.php");
	//Header
	$smarty->display("header.tpl");
	//Left Navigation
	$smarty->display('leftnav.tpl');
	//require("_includes/leftnav.inc");

	if ($sessionroleid == 5){
	  echo "<script type=\"text/javascript\">	highlight_nav(4); </script>";
	}else if ($sessionroleid == 4){
	  echo "<script type=\"text/javascript\">	highlight_nav(6); </script>";
	}else{
	  echo "<script type=\"text/javascript\">	highlight_nav(5); </script>";
	}

?>
<!--  Display Area -->
<div id="divRHS">
        <p><strong>Overview</strong></p>
  <p>          The existing legislation  and guidance surrounding controlled drugs is shared between a variety of  government departments and other agencies. See legislation section.</p>
  <p>&nbsp; </p>
  <p><strong>Good Practice Guides</strong></p>
<p>          Good practice guides  have been produced which take account of legislation and guidance from  government departments and other agencies.</p>
<p>&nbsp;</p>
<p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/gp_practice_no1.pdf"><strong>Five Minute Guide – Number 1 GP  Practices – Ordering and collection of Controlled Drugs (CDs)</strong></a><strong><br />
  December 2010</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/gp_practice_no2.pdf"><strong>Five Minute Guide – Number 2 GP  Practices – Receiving CDs and CD Registers</strong></a><strong><br />
          December 2010</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/gp_practice_no3.pdf"><strong>Five Minute Guide – Number 3 GP  Practices – Storage of CDs</strong></a><strong><br />
          December 2010</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/gp_practice_no4.pdf"><strong>Five Minute Guide – Number 4 GP  Practices – Prescribing of Controlled Drugs</strong></a><strong><br />
          December 2010</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/gp_practice_no5.pdf"><strong>Five Minute Guide – Number 5 GP  Practices – Controlled Drugs governance</strong></a><strong><br />
          December 2010</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/less_than_sixty.php"><strong>Controlled drugs - less than 60  minute e-learning events</strong></a><strong><br />
          August 2010</strong></p>
        <p>&nbsp;</p>
        <p><strong>Primary Care</strong></p>
        <p><a href="http://www.npc.nhs.uk/controlled_drugs/resources/controlled_drugs_third_edition.pdf"><strong>A guide to good  practice in the management of controlled drugs in primary care (England) – 3rd  edition</strong></a><br />
          Publication date: December 2009</p>
        <p>This version of the  Controlled Drugs (CD) guide is the full Third Edition and replaces the Second  Edition.<br />
          <br />
          The National Prescribing  Centre website (<a href="http://www.npc.nhs.uk">www.npc.nhs.uk</a>) contains a section dealing with&nbsp;<a href="http://www.npc.nhs.uk/faqs_cd.php">frequently  asked questions</a>&nbsp;and individual  professional organisations provide a range of advisory services to their  members (see Appendix 4 – useful contacts).<br />
          The guide is primarily  aimed at developing good practice for the management of controlled drugs in  primary care in England, but it also encompasses issues raised at the  interfaces between primary, secondary and social care. This guide takes into  account the significant legislative changes introduced since the publication of  the first edition in December 2005.</p>
        <p>The guide should be of  value in a wide range of settings where CDs are used including:</p>
        <ul>
          <li>GP and dental practices</li>
          <li>Pharmacies</li>
          <li>Midwifery services</li>
          <li>Out-of-hours services</li>
          <li>Patients own home</li>
          <li>Care homes</li>
          <li>Community nursing  services</li>
          <li>Community palliative  care services</li>
          <li>Substance misuse  services</li>
          <li>Hospices</li>
          <li>Prison services</li>
          <li>Ambulance  services/paramedics</li>
          <li>Intermediate care  services</li>
        </ul>
        <p>Every effort has been  made to ensure that the information provided in this guide is accurate and  up-to-date. However, the legal and regulatory framework governing CDs is  continuing to change significantly and readers should always check that they  are referring to the most up-to-date version of this guide, as well as  cross-checking with other recognised sources of information.</p>
        <p>&nbsp; </p>
        <p><strong>Department of Health</strong></p>
        <p>          The Department of Health  Controlled Drug website section contains information on the post Shipman  changes to the legal framework around the use and management of controlled  drugs. It signposts the user to the relevant legislation and guidance.</p>
        <ul>
          <li><a href="http://webarchive.nationalarchives.gov.uk/+/www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_4131227">Specific DH guidance - Safer Management of Controlled Drugs</a></li>
          <li><a href="http://www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_4131465">Private CDs and other changes to prescribing and dispensing  of CDs</a></li>
          <li><a href="http://www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_079574">Record keeping</a></li>
          <li><a href="http://www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_079571">Requisitions</a></li>
          <li><a href="http://www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_078034">Destruction</a></li>
        </ul>
        <p>&nbsp;</p>
        <p><strong>Care Quality  Commission</strong></p>
        <p>          The Care Quality  Commission website provides an overview of the work of the Care quality  Commission to promote the safe management of controlled drugs and resources to  support organisations in discharging their responsibilities. It also hosts the  register of accountable officers in England.<br />
          <br />
          <a href="http://www.cqc.org.uk/newsandevents/newsstories.cfm?cit_id=37488&amp;FAArea1=customWidgets.content_view_1&amp;usecache=false">Controlled Drugs Annual Report 2010</a><br />
          <a href="http://www.cqc.org.uk/guidanceforprofessionals/healthcare/allhealthcarestaff/managingrisk/controlleddrugs/self-assessmenttool.cfm">Self Assessment Tool</a><br />
          <a href="http://www.cqc.org.uk/guidanceforprofessionals/healthcare/allhealthcarestaff/managingrisk/controlleddrugs/accountabl/registerofofficers.cfm">Register of Accountable Officers in England</a></p>
        <p><strong>&nbsp;</strong></p>
        <p><strong>Secondary Care</strong></p>
        <p><a href="http://www.dh.gov.uk/en/Publicationsandstatistics/Publications/PublicationsPolicyAndGuidance/DH_079618">Safer management of controlled drugs: a guide to good  practice in secondary care (England)&nbsp;</a><br />
          Date of publication: Oct 07<br />
          This document promotes the safe and effective use of controlled drugs in  healthcare organisations providing secondary care. The guidance will support  healthcare professionals and organisations in implementing robust arrangements  for controlled drugs.<br />
          <br />
          <a href="http://www.cqc.org.uk/guidanceforprofessionals/socialcare/careproviders/guidance.cfm?widCall1=customWidgets.content_view_1&amp;cit_id=2534">The safe management of controlled drugs in care homes</a><br />
          Management of Controlled Drugs in Care Homes&nbsp;<br />
          Guidance produced by the Care Quality Commission relating to safe practice when  controlled drugs are prescribed for care home. The document describes the  arrangements that care providers should make when controlled drugs are  prescribed for people in care homes</p>
        <p>&nbsp;</p>
      </div> <!-- END OF #divRHS -->
		
		<div class="clear"><!-- --></div>
		
		</div> <!-- END OF #divFauxColumns -->
		
		<?php $smarty->display("footer.tpl");?>
		
			</div> <!-- END OF #divPage -->
			
			<div id="divPageBottom"><!-- --></div>

</div>
</body>
</html>