<?php require("inc/include.php");
	if (isset($_SESSION['org_id'])) $sessionorgid = $_SESSION['org_id'];else $sessionorgid = "";
	if (isset($_SESSION['role_id'])) $sessionroleid = $_SESSION['role_id'];else $sessionroleid = "";
	
	$header = "";
	$data = "";
	if ($sessionroleid == 1)
	{	//Export select organisation's users
		if (isset($_REQUEST['org']) && $_REQUEST['org'] > 0){
			$sql = "SELECT * FROM users,address where users.address_id = address.address_id and users.org_id=".$_REQUEST['org'];
		}else{
			$sql = "SELECT * FROM users,address where users.address_id = address.address_id";
		}
	}else {
		$sql = "SELECT * FROM users,address where users.address_id = address.address_id and users.org_id =". "'". $sessionorgid."'".
		" and users.role_id >= '".$sessionroleid."'";
	}
    //echo"Exporting...\n".$sql;
    $rec = mysql_query($sql) or die (mysql_error());
    $num_fields = mysql_num_fields($rec);
    for($i = 0; $i < $num_fields; $i++ )
    {
    	if ($i == 19) $header .= ",";
        $header .= mysql_field_name($rec,$i).",";
    }
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        $count = 0;
        foreach($row as $value)
        {                                            
            if((!isset($value)) || ($value == ""))
            {
                $value = ",";
            }
            else
            {
                $value = str_replace( "'" , "''" , $value );
                if (stristr($value,",")) $value = "\"". $value . "\"'" . ",";
                else $value = "'" . $value . "'" . ",";
            }
            $count = $count + 1;
            if ($count == 20) $line .= ",";
            
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
    }
    $data = str_replace("\r" , "" , $data);
    
    if ($data == "")
    {
        $data = "\n No Record Found!n";                        
    }

    header("Pragma: public"); // required 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=users.csv");
    print "$header\n$data";
	?>