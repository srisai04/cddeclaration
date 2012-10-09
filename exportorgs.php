<?php include("inc/include.php");
    $sql = "SELECT * FROM organisations,address where organisations.address_id = address.address_id";
    //echo"Exporting...\n".$sql;
    $rec = mysql_query($sql) or die (mysql_error());
    $num_fields = mysql_num_fields($rec);
    $header = "";
    $data = "";
    for($i = 0; $i < $num_fields; $i++ )
    {
    	if ($i == 4) $header .= ",";
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
                $value = "'" . $value . "'" . ",";
            }
            $count = $count + 1;
            if ($count == 5) $line .= ",";
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
    header("Content-Disposition: attachment; filename=organisations.csv");
    print "$header\n$data";
?>