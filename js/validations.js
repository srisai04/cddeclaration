function highlight_nav(id1){
	document.getElementById("aNav_"+id1).className = "on";
}

function validateLogin(){
	if (!emailcheck()){
		return false;
	}else if (document.form2.password.value == null || document.form2.password.value == ""){
		alert("Password should not be empty.");
		document.form2.password.focus();
		return false;
	}else {
		// alert("Authentication..");
		document.form2.action="index.php?status=1";
		document.form2.submit();
		return true;
	}
}

function startDeclaration(){
		document.form3.action="declaration.php";
		document.form3.submit();
		return false;
}

function showDashboard(year, org, subfilter, selection, qid, secid){
	//alert("User Data:"+org+", "+subfilter+","+selection[0].row+",qid:"+qid);
	document.userform.org.value = org;
	document.userform.year.value = year;
	document.userform.subfilter.value = subfilter;
	document.userform.selection.value = selection[0].row;
	document.userform.qid.value = qid;
	document.userform.secid.value = secid;
	document.userform.action="userdata.php";
	//?year="+year+"&org="+org+"&subfilter="+subfilter+"&selection="+selection[0].row;
	//alert("action:"+document.userform.action);
	document.userform.target="_newwindow";
	document.userform.submit();
	return false;
}

function generateReport(type){
	//alert("Generating Report, please wait..");
	document.form2.action="PDFReport.php?type="+type;
	document.form2.target="_repwindow";
	document.form2.submit();
	return false;
}

function searchUsers(){
   var orgId = document.searchform.org.value;
   var roleId = document.searchform.role.value;
	document.searchform.action="usermanagement.php?org="+orgId+"&role="+roleId;
	document.searchform.submit();
	return false;
}

function newUser(){
	document.searchform.action="registration.php";
	document.searchform.submit();
	return false;
}

function newIncident(){
	document.form3.action="reportincident.php";
	document.form3.submit();
	return false;
}

function showMsg(){
   var i = document.form2.subfilter.selectedIndex;
   var sel = document.form2.subfilter.options[i].value;
	if (sel == "Imported Users"){
		alert ("Login and Password of imported users will be mailed with your message.");
		document.form2.subject.value = "Your account details for CD Declaration";
		document.form2.message.value = "Your account has been created by administrator and the account details are below:";
	}
	return false;
}

function forgotPwd(){
	if (!emailcheck()){
		return false;
	}else {
		// alert("Sending Mail..");
		document.form2.action="forgotpwd.php?status=1";
		document.form2.submit();
		return true;
	}
}

function resetPwd(){
	if (!emailcheck()){
		return false;
	}else if (document.form2.resetpwd.value == null || document.form2.resetpwd.value == ""){
		alert("Reset Password should not be empty.");
		document.form2.resetpwd.focus();
		return false;
	}else if (document.form2.password.value == null || document.form2.password.value == ""){
		alert("Password should not be empty.");
		document.form2.password.focus();
		return false;
	}else if (document.form2.confirm.value == null || document.form2.confirm.value == ""){
		alert("Confirm Password should not be empty.");
		document.form2.confirm.focus();
		return false;
	}else if (document.form2.password.value != document.form2.confirm.value){
		alert("Password and Confirm Password are not matching.");
		document.form2.password.value = "";
		document.form2.confirm.value = "";
		document.form2.password.focus();
		return false;
	}else {
		document.form2.action="resetpwd.php?status=1";
		document.form2.submit();
		return true;
	}
}

function validateDashboard(){
	if (document.form2.subfilter.value == null || document.form2.subfilter.value == "default"){
		alert("Please select report.");
		document.form2.subfilter.focus();
		return false;
	}else{
		document.form2.action="dashboards.php?status=1&orgname="+document.form2.org.options[document.form2.org.selectedIndex].text;
		document.form2.submit();
		return false;
	}
}

function validateArchive(){
	//alert(document.formarchive.archyear.value);
	//alert(document.formarchive.org1.value);
	//alert(document.formarchive.user.value);
			
	if (document.formarchive.archyear.value == null || document.formarchive.archyear.value == ""){
		alert("Please select year.");
		document.formarchive.archyear.focus();
		return false;
	}else if(document.formarchive.org1.value == null || document.formarchive.org1.value == 0){
		alert("Please select organisation.");
		document.formarchive.org1.focus();
		return false;
	}else if(document.formarchive.user.value == null || document.formarchive.user.value == 0){
		alert("Please select user.");
		document.formarchive.user.focus();
		return false;
	}else{
		var msg = "Do you want to Archive all the declaration data for the year: "+document.formarchive.archyear.value+".";
		var agree = confirm(msg);
		if (agree){
			document.formarchive.action="archivals.php?status=2";
			document.formarchive.submit();
			return false;
		}else{
			return false;
		}
	}
}

function reloadUsers(){
	document.formarchive.action="archivals.php?status=3";
	document.formarchive.submit();
	return false;
}

function validateNotification(){
	if (document.form2.subject.value == null || document.form2.subject.value == ""){
		alert("Please enter Subject.");
		document.form2.subject.focus();
		return false;
	}else if (document.form2.message.value == null || document.form2.message.value == ""){
		alert("Please enter Notification/Message.");
		document.form2.message.focus();
		return false;
	}else {
		document.form2.action="notifications.php?status=1";
		document.form2.submit();
		return false;
	}
}

function validateIncident(){
	//alert("incident");
	if (document.form2.org.value == null || document.form2.org.value == 0){
		alert("Please Select an Organisation.");
		document.form2.org.focus();
		return false;
	}else if (document.form2.incident.value == null || document.form2.incident.value == ""){
		alert("Please enter Occurrence details.");
		document.form2.incident.focus();
		return false;
	}else if (!emailcheck1()){
		return false;
	}else {
		// alert("Sending Mail..");
		document.form2.action="reportincident.php?status=1";
		document.form2.submit();
		return false;
	}
}

function searchIncidents(){
	if (document.form2.fromdate.value == null || document.form2.fromdate.value == ""){
		alert("Please enter from date.");
		document.form2.fromdate.focus();
		return false;
	}else if (document.form2.todate.value == null || document.form2.todate.value == ""){
		alert("Please enter to date.");
		document.form2.todate.focus();
		return false;
	}else {
		document.form2.action="viewincident.php?status=1";
		document.form2.submit();
		return false;
	}
}

function validateFeedback(){
	if (document.form2.feedback.value == null || document.form2.feedback.value == ""){
		alert("Please enter your feedback.");
		document.form2.feedback.focus();
		return false;
	}else {
		document.form2.action="feedback.php?status=1";
		document.form2.submit();
		return false;
	}
}

function validateImportExport(str){
	//alert(str);
	if(str == "userimport"){
		var filename = document.form2.importuserfile;
		var status = 1;
	}else if(str == "orgimport"){
		var filename = document.form2.importorgfile;
		var status = 2;
	}else if(str == "userexport"){
		var org = "";
		if (document.form2.org != null) org = document.form2.org.value;
		//alert(org);
		window.open('exportusers.php?org='+org);
		return false;
	}
	
	if ((status == 1 || status == 2)  && !validateFile(filename)){
		return false;
	}else{
		document.form2.action="importexport.php?status="+status;
		document.form2.submit();
		return false;
	}
}

function iexportCSV(str){
	if(str == "export"){
		var org = "";
		if (document.form2.org != null) org = document.form2.org.value;
		var fromdate = "";
		if (document.form2.fromdate != null) fromdate = document.form2.fromdate.value;
		var todate = "";
		if (document.form2.todate != null) todate = document.form2.todate.value;
		window.open('exportincidents.php?org='+org+'&fromdate='+fromdate+'&todate='+todate);
		return false;
	}else{ //import
		if (document.form4.importfile == null || document.form4.importfile == "") {
			alert("Please select a CSV file to import.");
			document.form4.importfile.focus();
		} else {
			document.form4.action="viewincident.php?status=2";
			document.form4.submit();
		}
		return false;
	}
}

function viewOrg(){
	   var i = document.form2.org.selectedIndex;
	   var orgId = document.form2.org.options[i].value;

	if (orgId != null ||orgId != 0){
		document.form2.action="orgmanagement.php?status=1";
		document.form2.submit();
		return false;
	}else{
		alert ("Please select an Organisation");
		document.form2.org.focus();
		return false;
	}
}

function viewQuestion(){
	   var i = document.form2.qid.selectedIndex;
	   var qid = document.form2.qid.options[i].value;

	if (qid != null || qid != 0){
		document.form2.action="dashboards.php";
		document.form2.submit();
		return false;
	}else{
		alert ("Please select a question");
		document.form2.qid.focus();
		return false;
	}
}

function populateQuestions(){
	   var i = document.form2.subfilter.selectedIndex;
	   var subfilter = document.form2.subfilter.options[i].value;

	if (subfilter != null || subfilter != 0){
		//if ($subfilter == "Question Status"){
			document.form2.action="dashboards.php";
			document.form2.submit();
		//}
		return false;
	}else{
		alert ("Please select a report");
		document.form2.subfilter.focus();
		return false;
	}
}

function validateOrg(str){
	//alert(str);
	if (str == 'reset'){
		document.form2.org.value=0;
		document.form2.action="orgmanagement.php?status=0";
		document.form2.submit();
		return true;
	}else if (str == 'create'){
		if (document.form2.orgname.value == null || document.form2.orgname.value == ""){
			alert("Organisation name should not be empty.");
			document.form2.orgname.focus();
			return false;
		}else{
			document.form2.action="orgmanagement.php?status=2";
			document.form2.submit();
			return false;
		}
	}else if (str == 'update'){
		if (document.form2.org.value == null || document.form2.org.value == "" || document.form2.orgname.value == null || document.form2.orgname.value == ""){
			alert("Organisation name should not be empty.");
			document.form2.orgname.focus();
			return false;
		}else{
			document.form2.action="orgmanagement.php?status=3";
			document.form2.submit();
			return false;
		}
	}else if (str == 'delete'){
		if (document.form2.org.value == null || document.form2.org.value == "" || document.form2.org.value == 0){
			alert("Please select an organisation to delete.");
			document.form2.orgname.focus();
			return false;
		}else{
			document.form2.action="orgmanagement.php?status=4";
			document.form2.submit();
			return false;
		}
	}
	//return true;
}

function activateUsers(){
	   var orgId = document.searchform.org.value;
	   var roleId = document.searchform.role.value;
	   var msg = "Do you want to activate all the users displayed?"
   
	   if ((orgId == null && roleId == null) || (orgId == 0 && roleId == 0)){
		   msg = "You are activating system wide users, continue?"
			   orgId = ""; roleId = "";
	   }else if (orgId != 0 && roleId != 0){
		   msg = "You are activating users of Organisation Id "+orgId+" and website access Id "+roleId+". Continue?";
	   }else if (orgId != 0 && roleId == 0){
		   msg = "You are activating users of Organisation Id "+orgId+". Continue?";
	   }else if (orgId == 0 && roleId != 0){
		   msg = "You are activating users of website access Id "+roleId+". Continue?";
	   }
	   
	var agree = confirm(msg);
	
	if (agree){
		document.form2.action="usermanagement.php?status=1&org="+orgId+"&role="+roleId;
		document.form2.submit();
		return false;
	}else{
		return false;
	}
}

function validateRegistration(str){
	//alert(str);
	if(str == 'delete'){
		var userid = document.form2.userid.value;
		document.form2.action="updateuser.php?status=2&userid="+userid;
		document.form2.submit();
		return false;
	}else if (str == 'cancel'){
		document.form2.action="home.php";
		document.form2.submit();
		return false;
	}
	
	if (document.form2.firstname.value == null || document.form2.firstname.value == ""){
		alert("Forename should not be empty.");
		document.form2.firstname.focus();
		return false;
	}else if (!emailcheck()){
		return false;
	}else if (str != 'update' && (document.form2.password.value == null || document.form2.password.value == "")){
		alert("Password should not be empty.");
		document.form2.password.focus();
		return false;
	}else if (str != 'update' && (document.form2.confirm.value == null || document.form2.confirm.value == "")){
		alert("Confirm Password should not be empty.");
		document.form2.confirm.focus();
		return false;
	}else if (document.form2.password.value != document.form2.confirm.value){
		alert("Password and Confirm Password are not matching.");
		document.form2.password.value = "";
		document.form2.confirm.value = "";
		document.form2.password.focus();
		return false;
	}else if (!validatePhone()){
		return false;
	}else if (document.form2.org.value == 0){
		alert("Please select your organisation.");
		document.form2.org.focus();
		return false;
	}else if (document.form2.profession.value == 0){
		alert("Please select your profession.");
		document.form2.profession.focus();
		return false;
	}else if (document.form2.role.value == 0){
		alert("Please select your website access.");
		document.form2.role.focus();
		return false;
	}else{
		//alert(document.form2.status.value);
		if (str == 'update'){
			var userid = document.form2.userid.value;
			document.form2.action="updateuser.php?status=1&userid="+userid;
			document.form2.submit();
		}else{
			document.form2.action="registration.php?status=1";
			document.form2.submit();
		}
		
		return false;
	}
	//return true;
}

function validateDeclaration(str){
	var secsel = document.form2.secquestion.value;
	alert(str);
	if (str == 'section'){
		alert("section");
		document.form2.action="cddec.php?status=1&secsel="+secsel;
		document.form2.submit();
		return false;
	}else{
		if (str == 'save'){
			var userid = document.form2.userid.value;
			document.form2.action="cddec.php?status=2";
			document.form2.submit();
		}
		return false;
	}
}

function validatePhone(){
	var Phone=document.form2.phone;
	if ((Phone.value!=null)&& (Phone.value!="")){
		//alert("Please enter your phone number");
		//Phone.focus();
		//return false;

		if (checkInternationalPhone(Phone.value)==false){
			alert("Please enter a valid phone number in the format +123-123-123-1234");
			Phone.value="";
			Phone.focus();
			return false;
		}
	}
	return true;
}

function emailcheck(){
	var emailID=document.form2.email;
	
	if ((emailID.value==null)||(emailID.value=="")){
		alert("Please enter your email ID");
		emailID.focus();
		return false;
	}
	if (echeck(emailID.value)==false){
		emailID.value="";
		emailID.focus();
		return false;
	}
	return true;
}

function emailcheck1(){
	var emailID=document.form2.email;
	
	if ((emailID.value==null)||(emailID.value=="")){
		//alert("Please enter your email ID");
		//emailID.focus();
		return true;
	}else if (echeck(emailID.value)==false){
		emailID.value="";
		emailID.focus();
		return false;
	}
	return true;
}

function validateFile(File){
	if ((File.value!=null) && (File.value!="")){
		if (File.value.lastIndexOf(".csv")==-1 && File.value.lastIndexOf(".xls")==-1)// && File.value.lastIndexOf(".pdf")==-1)
		{
			alert("Please import file in .csv or .xls format.");
			File.focus();
			return false;
		}
	}else {
		alert("Please select a file to import.");
		File.focus();
		return false;
	}
	return true;
}

function echeck(str) {
	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var lstr=str.length;
	var ldot=str.indexOf(dot);
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	   return false;
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	   return false;
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	    return false;
	}

	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	    return false;
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	    return false;
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	    return false;
	 }
	
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID. Please enter in myname@myorg.com format.");
	    return false;
	 }
		 return true;		
}

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{   
	var i;
	for (i = 0; i < s.length; i++)
	{   
	  // Check that current character is number.
	  var c = s.charAt(i);
	  if (((c < "0") || (c > "9"))) return false;
	}
	// All characters are numbers.
	return true;
}

function trim(s)
{
	var i;
	var returnString = "";
	// Search through string's characters one by one.
	// If character is not a whitespace, append to returnString.
	for (i = 0; i < s.length; i++)
	{   
	  // Check that current character isn't whitespace.
	  var c = s.charAt(i);
	  if (c != " ") returnString += c;
	}
	return returnString;
}

function stripCharsInBag(s, bag)
{   
	var i;
	var returnString = "";
	// Search through string's characters one by one.
	// If character is not in bag, append to returnString.
	for (i = 0; i < s.length; i++)
	{   
	  // Check that current character isn't whitespace.
	  var c = s.charAt(i);
	  if (bag.indexOf(c) == -1) returnString += c;
	}
	return returnString;
}

function checkInternationalPhone(strPhone){
	var bracket=3;
	strPhone=trim(strPhone);
	if(strPhone.indexOf("+")>1) return false;
	if(strPhone.indexOf("-")!=-1)bracket=bracket+1;
	if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false;
	var brchr=strPhone.indexOf("(");
	if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false;
	if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false;
	s=stripCharsInBag(strPhone,validWorldPhoneChars);
	return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}


// <------------------- Declaration Related functions ---------------->

function getClickedCheckbox(ans)
{
	var obj=document.frm;
	for(var i=0; i<obj.length; i++)
	{
    if(obj.elements[i].type == "checkbox")
		{
			if(obj.elements[i].value == ans)
				return obj.elements[i];
		}
	}
}

function togglenotes(qid,show_notes,value)
{
	var nc_obj = eval("document.getElementById('notes_container_"+qid+"')");
	var ans_obj = eval("document.frm.aid_"+qid);
	var ans_chk_obj = getClickedCheckbox(value);
	if(nc_obj != null)
	{
		if(ans_chk_obj)
		{
			if(ans_chk_obj.checked)
			{
				if(show_notes == "Y")
					nc_obj.style.display="block";
			} else {
				if(show_notes == "Y")
					nc_obj.style.display="none";
			}
			return;
		}
		if(ans_obj.type == "radio")
		{
			if(show_notes == "Y")
				nc_obj.style.display="block";
			if(show_notes == "N")
				nc_obj.style.display="none";
		}

	}
}

function checkNotesRequired(qid)
{
	var hobj=eval("document.frm.hide_notes_"+qid);
	var cobj=eval("document.getElementById('notes_container_"+qid+"')");
	if(hobj.value == "Y")
	{
		if(cobj != null)
		{
			if(cobj.style.display == "block")
				return true;
		}
	}
	return false;
}

function getSectionConfirmation()
{
	var obj=document.frm.choice;
	for(var i=0; i< obj.length; i++)
	{
		if(obj[i].checked)
			return obj[i].value;
	}
}


function checkMultipleAnswers(qid)
{
	var ret = false;
	var obj=document.frm['aid_'+qid+'[]'];
	for(var i=0; i<obj.length; i++)
	{
		var notes = eval("document.frm.notes_"+qid);
		var unhide_obj=eval("document.frm.unhide_notes_"+qid+"_"+obj[i].value);
		if(obj[i].checked)
		{
			if(unhide_obj.value == "Y")
			{
				if(notes.value == "")
				{
					ret = false;
					break;
				}
			}
			ret = true;
		}
	}
	return ret;
}

function validate()
{
	var obj = document.frm;
	var qid=/^qid_[0-9]+/;
	if(getSectionConfirmation() == "yes")
	{
		for(var i=0; i<obj.length; i++)
		{
			if(obj.elements[i].name.search(qid)==0)
			{
				var qobj = obj.elements[i].name.split("_");
				var notes = eval("document.frm.notes_"+qobj[1]);
				if(!checkAnswer(qobj[1]) || (checkNotesRequired(qobj[1]) && notes.value == ""))
				{
					alert("You have not selected or typed an answer for Q ID : "+ qobj[1]+". Please answer all the questions.");
					try{
						notes.focus();
					}catch (e){}
					return false;
				}
			}
		}
	}else{
		var ls = document.frm.section_id.value;
		if (ls == "9"){
			alert("General Section is mandatory to complete. Please select Yes and complete");
			return false;
		}
		
	}
	return true;
}

function checkAnswer(qid)
{
	var obj = eval("document.frm.aid_"+qid);
	if(typeof obj != "undefined")
	{
		if(obj.type == "hidden")
		{
			var notesobj = eval("document.frm.notes_"+qid);
			return notesobj.value;
		}
		for(var i=0; i<obj.length; i++)
		{
			if(obj[i].checked)
				return obj[i].value;
		}
	} else {
		return checkMultipleAnswers(qid);
	}
	return false;
}

function toggleSectionQuestions(what,which)
{
	if(what == 0)
 	{
		if($('questions').style.display == "none")
			Effect.SlideDown('questions');
	}
	if(what == 1)
	{
		if($('questions').style.display == "")
			Effect.SlideUp('questions');
	}
	which.checked=true;
}
