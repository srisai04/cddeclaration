<?php
		session_start();
		require "setpath.php";
		require "common.php";
		require "properties.php";
		require "connect.php";
		require "Smarty.php";
		
		if (isset($_REQUEST['sqlqry']))$sqlqry = $_REQUEST['sqlqry'];else $sqlqry = "";
		if (isset($_REQUEST['sqlqryu']))$sqlqryu = $_REQUEST['sqlqryu'];else $sqlqryu = "";
		if (isset($_REQUEST['sel']))$sel = $_REQUEST['sel'];else $sel = "";
		if (isset($_REQUEST['subfilter'])) $subfilter = $_REQUEST['subfilter']; else $subfilter = "";
		if (isset($_REQUEST['type']))$type = $_REQUEST['type'];else $type = "";
		if (isset($_REQUEST['info']))$info = $_REQUEST['info'];else $info = "All";
		if (isset($_REQUEST['quid']))$quid = $_REQUEST['quid'];else $quid = "";

		$dt = " (" . date('d-m-Y') . ")";

		//$sqlqry = str_replace("'", "\\'", $sqlqry);
		//print("SQL".$sqlqry);
		$sqlqry = str_replace("\\", "", $sqlqry);
		$sqlqryu = str_replace("\\", "", $sqlqryu);
		//print("SQL".$sqlqry);
		
		require('MyPDF.php');

		if ($type == "" || $type=="pdf"){ //pdf
			
			// create pdf
			$pdf=new MyPDF('P','mm','A4');
			$pdf->AliasNbPages();
			$pdf->SetMargins($pdf->left, $pdf->top, $pdf->right); 
			$pdf->AddPage();
			   
		
			$pdf->Image('_images/header/cd_logo.jpg',10,6,30);
		    // Arial bold 15
		    $pdf->SetFont('Arial','B',9);
		    // Move to the right
		    $pdf->Cell(80);
		    // Title
		    $pdf->Cell(115,10,$sel.$dt,1,0,'C');
		    $pdf->Ln();
		    $pdf->Cell(80);
		    $pdf->setFont('Arial','B',7);
		    $pdf->Cell(115,10,$info,1,0,'C');
		    $pdf->Ln(15);
		    // create table
		    $columns = array();
		    
		    
		    if ($subfilter == "Question Status" && $quid != null && $quid != 0){
		    	$answers = "";
		    	$pdf->setFont('Arial','B',5);
		    	$sql = "SELECT q.question_id, q.question, s.section_code, a.answer FROM questions q, sections s, answers a WHERE q.section_id = s.section_id and q.question_id = a.question_id and q.question_id=".$quid;
		    	$r1 = mysql_query($sql);
		    	if(!$r1){
		    		$msg = "Unable to retrieve question.";
		    		$col = array();
		    		$col[] = array('text' => $msg, 'width' => '195', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$columns[] = $col;
		    	}else {
		    		$i=$j=0;
		    		while($row = mysql_fetch_array($r1)){
		    			if ($i == 0){
		    				// Line break
		    				//$pdf->Ln();
		    				$col = array();
		    				$col[] = array('text' => $row['question'], 'width' => '195', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    				$columns[] = $col;
		    				//$pdf->Ln();
		    				//echo "<input type=\"hidden\" name=\"secid\" value=\"".$row['section_code']."\"/>";
		    			}
		    			$i++;$j++;
		    			$answers = $answers . " " . $j . ") ". $row['answer'] . " ";
		    		}
		    		$col = array();
		    		$col[] = array('text' => $answers, 'width' => '195', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$columns[] = $col;
		    		//$pdf->Ln();
		    	}
		    }
		    
		    // header col
		    $col = array();		    
		    $col[] = array('text' => 'Id', 'width' => '8', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'Name', 'width' => '30', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'e-Mail', 'width' => '30', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'Phone', 'width' => '20', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'Profession', 'width' => '25', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'Organisation', 'width' => '25', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $col[] = array('text' => 'PRN', 'width' => '12', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    if ($subfilter == "Question Status"){
		    	$col[] = array('text' => 'Answer', 'width' => '15', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    	$col[] = array('text' => 'Address', 'width' => '30', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    }else{
		    	$col[] = array('text' => 'Address', 'width' => '45', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    }
		    
		    $columns[] = $col;
		    if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
		    	if ($subfilter == "Section Wise Status") {
		    		$subhead = "All responses best practice";
		    	} else { $subhead = "Relevant";}
		    	$col = array();
		    	$col[] = array('text' => $subhead, 'width' => '195', 'height' => '4', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,230,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    	$columns[] = $col;
		    }
		    
		    $r1 = mysql_query($sqlqry);
		    if(!$r1) {
		    	$err=mysql_error();
		    	$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
		    	$col = array();
		    	$col[] = array('text' => $msg, 'width' => '195', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
 				$columns[] = $col;
		    }else{
		    	while($row = mysql_fetch_array($r1)){
		    		$col = array();
		    		$col[] = array('text' => $row['user_id'], 'width' => '8', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['user_fname']." ".$row['user_lname'], 'width' => '30', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['email'], 'width' => '30', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['phone'], 'width' => '20', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['profession'], 'width' => '25', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['organisation'], 'width' => '25', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$col[] = array('text' => $row['prn'], 'width' => '12', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		if ($subfilter == "Question Status"){
		    			$col[] = array('text' => $row['answer'], 'width' => '15', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4'].", ". $row['county'].", ". $row['city'].", ". $row['country'].", ". $row['pincode'], 'width' => '30', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		}else{
		    			$col[] = array('text' => $row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4'].", ". $row['county'].", ". $row['city'].", ". $row['country'].", ". $row['pincode'], 'width' => '45', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		}
		    		$columns[] = $col;
		    	}
		    }
		    
		    if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
		    	if ($subfilter == "Section Wise Status") {
		    		$subhead = "One or more response not best practice";
		    	} else { $subhead = "Not Relevant";  	}
		    	
		    	$col = array();
		    	$col[] = array('text' => $subhead, 'width' => '195', 'height' => '4', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,230,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    	$columns[] = $col;
		    	
		    	$r1 = mysql_query($sqlqryu);
		    	if(!$r1) {
		    		$err=mysql_error();
		    		$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
		    		$col = array();
		    		$col[] = array('text' => $msg, 'width' => '195', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    		$columns[] = $col;
		    	}else{
		    		while($row = mysql_fetch_array($r1)){
		    			$col = array();
		    			$col[] = array('text' => $row['user_id'], 'width' => '8', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['user_fname']." ".$row['user_lname'], 'width' => '30', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['email'], 'width' => '30', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['phone'], 'width' => '20', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['profession'], 'width' => '25', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['organisation'], 'width' => '25', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$col[] = array('text' => $row['prn'], 'width' => '12', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		   				$col[] = array('text' => $row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4'].", ". $row['county'].", ". $row['city'].", ". $row['country'].", ". $row['pincode'], 'width' => '45', 'height' => '3', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    			$columns[] = $col;
		    		}
		    	}
		    
		    }
		    
		    $col = array();
		    $col[] = array('text' => '******** End of Report ********', 'width' => '195', 'height' => '4', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => 'B', 'fillcolor' => '135,206,250', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => 'LTBR');
		    $columns[] = $col;
		    
		    $pdf->WriteTable($columns);
		    $pdf->Output("DeclarationReport.pdf","D");
		    
		}else{ //xls
			$header = $sel.$dt.",\n".$info ." \n";
			$hdrQuestion = "";
			if ($subfilter == "Question Status" && $quid != null && $quid != 0){
				$answers = "";
				$sql = "SELECT q.question_id, q.question, s.section_code, a.answer FROM questions q, sections s, answers a WHERE q.section_id = s.section_id and q.question_id = a.question_id and q.question_id=".$quid;
				$r1 = mysql_query($sql);
				if(!$r1){
					$msg = "Unable to retrieve question.";
				}else {
					$i=$j=0;
					while($row = mysql_fetch_array($r1)){
						if ($i == 0){
							// Line break
							$hdrQuestion = "\n";
							$hdrQuestion = $hdrQuestion . $row['question'];
							$hdrQuestion = $hdrQuestion;
							//echo "<input type=\"hidden\" name=\"secid\" value=\"".$row['section_code']."\"/>";
						}
						$i++;$j++;
						$answers = $answers . " " . $j . ") ". $row['answer'] . " ";
					}
					$hdrQuestion = $hdrQuestion ."\n". $answers . "\n";
				}
				$header = $header . $hdrQuestion . "\n";
			}
			
			if ($subfilter == "Question Status"){
				$header = $header. "Id,Name,E-Mail,Phone,Profession,Organisation,PRN,Answer,Address\n";
			}else $header = $header. "Id,Name,E-Mail,Phone,Profession,Organisation,PRN,Address\n";
		    
		    if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
		    	if ($subfilter == "Section Wise Status") {
		    		$subhead = "All responses best practice";
		    	} else { $subhead = "Relevant"; }
				$header = $header. "\n".$subhead."\n";
			}
		    
		    $r1 = mysql_query($sqlqry);
			if(!$r1) {
				$err=mysql_error();
				$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
				$data = $msg . "\n";
			}else{
				$data = "";
				while($row = mysql_fetch_array($r1)){
					$data = $data . $row['user_id'].",";
					$data = $data . $row['user_fname']." ".$row['user_lname'].",";
					$data = $data . $row['email'].",";
					$data = $data . $row['phone'].",";
					$data = $data . $row['profession'].",";
					$data = $data . $row['organisation'].",";
					$data = $data . $row['prn'].",";
					if ($subfilter == "Question Status"){
						$data = $data . $row['answer'].",";
					}
					//$data = $data . $row['gppcode'].",";
					//$data = $data . $row['consortia'].",";
					$data = $data .$row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4']." ". $row['county']." ". $row['city']." ". $row['country']." ". $row['pincode'];
					$data = $data . "\n";
				}
			}
			
			if ($subfilter == "Section Wise Status" || $subfilter == "Section Level Status"){
				if ($subfilter == "Section Wise Status") {
					$subhead = "One or more response not best practice";
				} else { $subhead = "Not Relevant";}
				
				$data = $data . "\n".$subhead."\n";
				
					    $r1 = mysql_query($sqlqryu);
				if(!$r1) {
					$err=mysql_error();
					$msg = "Unable to fetch user list at this time, please try again later. Error:".$err;
					$data = $msg . "\n";
				}else{
					while($row = mysql_fetch_array($r1)){
						$data = $data . $row['user_id'].",";
						$data = $data . $row['user_fname']." ".$row['user_lname'].",";
						$data = $data . $row['email'].",";
						$data = $data . $row['phone'].",";
						$data = $data . $row['profession'].",";
						$data = $data . $row['organisation'].",";
						$data = $data . $row['prn'].",";
						//$data = $data . $row['gppcode'].",";
						//$data = $data . $row['consortia'].",";
						$data = $data .$row['address1']." ". $row['address2']." ". $row['address3']." ". $row['address4']." ". $row['county']." ". $row['city']." ". $row['country']." ". $row['pincode'];
						$data = $data . "\n";
					}
				}
			}
			
		    header("Pragma: public"); // required 
		    header("Expires: 0"); 
		    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		    header("Cache-Control: private",false); // required for certain browsers 
		    header("Content-type: application/octet-stream");
		    header("Content-Disposition: attachment; filename=DeclarationReport.csv");
		    print "$header\n$data";
		}
?>