function generateReport(which)
{
	var str="";
	var str2="";
	var rep = eval(reportdata);
	var ctr=0;
	for( var repname in rep[0])
	{
		if(which == ctr)
		{
			str+=repname+"\n";
			//str2+=typeof rep[0][repname] + "\n";
			var rep2=rep[0][repname];
			for(var repobj in rep2)
			{
			//	str2+="*******" + typeof rep2[repobj] + "\n";
				if(typeof rep2[repobj] == "object")
				{
					str+="\t"+rep2[repobj]['user_fname']+ " " +
					rep2[repobj]['user_lname']+ " " +
					rep2[repobj]['email']+"\n";
				}
			}
			str+="\n";
		}
		ctr++;
	}
	//alert(str2);
	$('chartdata_div').innerHTML="<pre>\n"+str+"\n</pre>";
	//return str;
}


function showData(selection){
  //var selection = chart.getSelection();

/*var message="";
  for (var i = 0; i < selection.length; i++) {
    var item = selection[i];
    if (item.row != null && item.column != null) {
      message += '{row:' + item.row + ',column:' + item.column + '}';
    } else if (item.row != null) {
      message += '{row:' + item.row + '}';
    } else if (item.column != null) {
      message += '{column:' + item.column + '}';
    }
  }
  if (message == '') {
    message = 'nothing';
  }
  alert('You selected ' + message+"\n"+selection);*/
  
  
  generateReport(selection[0].row);
  
}

function selectHandler(e) {
  alert('A table row was selected');
}

function printChart()
{
	var frmObj=document.form2;
	
	if (frmObj.subfilter.options[frmObj.subfilter.selectedIndex].text == "Question Status"){
		var qstr="org="+frmObj.org.value+"&dbyear="+frmObj.dbyear.options[frmObj.dbyear.selectedIndex].text+"&orgname="+frmObj.org.options[frmObj.org.selectedIndex].text+"&subfilter="+frmObj.subfilter.options[frmObj.subfilter.selectedIndex].text+"&qid="+frmObj.qid.value+"&secid="+frmObj.secid.value+"&status=1";
	}else{
		var qstr="org="+frmObj.org.value+"&dbyear="+frmObj.dbyear.options[frmObj.dbyear.selectedIndex].text+"&orgname="+frmObj.org.options[frmObj.org.selectedIndex].text+"&subfilter="+frmObj.subfilter.options[frmObj.subfilter.selectedIndex].text+"&status=1";	
	}
	//alert(frmObj.dbyear.options[frmObj.dbyear.selectedIndex].text);
	if (frmObj.subfilter.options[frmObj.subfilter.selectedIndex].text == "Section Wise Status"){
		var width = 650;
		var height = 500;
	}else {
		var width = 650;
		var height = 300;
	}
	window.open('report.php?'+qstr,'1306948637150','&width='+width+',&height='+height+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
}