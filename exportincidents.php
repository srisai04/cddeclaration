<?php require("inc/include.php");
	if (isset($_SESSION['org_id'])) $sessionorgid = $_SESSION['org_id'];else $sessionorgid = "";
	if (isset($_SESSION['role_id'])) $sessionroleid = $_SESSION['role_id'];else $sessionroleid = "";
	
	if (isset($_REQUEST['fromdate']))$fromdate=htmlspecialchars($_REQUEST['fromdate']);else $fromdate="";
	if (isset($_REQUEST['todate']))$todate=htmlspecialchars($_REQUEST['todate']);else $todate="";
		
	
	$header = "";
	$data = "";
	
	$sfdate = substr($fromdate,6,4) ."-". substr($fromdate,3,2) ."-". substr($fromdate,0,2);
	$stdate = substr($todate,6,4) ."-". substr($todate,3,2) ."-". substr($todate,0,2);
	
	if ($sessionroleid == 1)
	{	//Export select organisation's users
		if (isset($_REQUEST['org']) && $_REQUEST['org'] > 0){
			$sql = "SELECT * FROM incidents where org_id='".$_REQUEST['org']."' and DATE( `inc_raised_on`) BETWEEN '".$sfdate."' and '".$stdate."'";
		}else{
			$sql = "SELECT * FROM incidents where DATE( `inc_raised_on`) BETWEEN '".$sfdate."' and '".$stdate."'";
		}
	}else {
			$sql = "SELECT * FROM incidents where org_id='".$sessionorgid."' and DATE( `inc_raised_on`) BETWEEN '".$sfdate."' and '".$stdate."'";
	}
    //echo "Exporting...\n".$sql;
    $rec = mysql_query($sql) or die (mysql_error());
    $num_fields = mysql_num_fields($rec);
    for($i = 0; $i < $num_fields; $i++ )
    {
        $header .= mysql_field_name($rec,$i).",";
    }
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        foreach($row as $value){                  
            if((!isset($value)) || ($value == "")){
                $value = ",";
            }else{
                $value = str_replace( "'" , "''" , $value );
                if (stristr($value,",")) $value = "\"". $value . "\"'" . ",";
                else $value = "'" . $value . "'" . ",";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
        //Export Incident Response
        $incid = $row[0];
		$sql = "SELECT * FROM incidentresponse WHERE inc_id='".$incid."'";
		//echo "SQL:".$sql;
	    $rec1 = mysql_query($sql) or die (mysql_error());
	    $num_fields = mysql_num_fields($rec1);
	    /*$header1 = ",";
	    for($j = 0; $j < $num_fields; $j++ )
	    {
	        $header1 .= mysql_field_name($rec1,$j).",";
	    }*/
	    while($row1 = mysql_fetch_row($rec1))
	    {
	        $line = '';
	        foreach($row1 as $value){                                 
	            if((!isset($value)) || ($value == "")){
	                $value = ",";
	            }else{
	                $value = str_replace( "'" , "''" , $value );
	                if (stristr($value,",")) $value = "\"". $value . "\"'" . ",";
	                else $value = "'" . $value . "'" . ",";
	            }
	            $line .= $value;
	        }
	        $data .= ",".trim( $line ) . "\n";
	    }
	    $data = str_replace("\r" , "" , $data);
    }
    $data = str_replace("\r" , "" , $data);

    if ($data == ""){
        $data = "\r No Record Found \r";                        
    }
    header("Pragma: public"); // required 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=Occurrences.csv");
    print "$header\n$data";
	?>