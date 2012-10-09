<?php
function print_pre($str) {
	print "<pre>\n";
	print_r($str);
	print "\n</pre>\n";
}

function getDeclarationList($u_id)
{
try
{
	$arcdec_sql="SELECT decl_id, decl_started_on, YEAR (decl_started_on) as decl_year FROM `declarations_arc` WHERE user_id = " .$u_id. 
	" ORDER BY decl_started_on ASC";
	$rs=mysql_query($arcdec_sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	$data=array();
	if(mysql_num_rows($rs)) {
		while($data[]=mysql_fetch_array($rs,MYSQL_ASSOC)) { }
		array_pop($data);
	}
	//print_pre($data);
	return ($data)? $data:null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}



function getDeclarationDetails($u_id)
{
try
{
	$dec_sql="SELECT decl_id, DATE_FORMAT( `decl_started_on` , '%d-%m-%Y' ) AS decl_started_on, decl_completed, DATE_FORMAT( `decl_completed_on` , '%d-%m-%Y' ) AS decl_completed_on FROM declarations WHERE user_id=$u_id AND
						YEAR(decl_started_on) = YEAR(CURDATE())";
	$dec_rs=mysql_query($dec_sql);
	if(!$dec_rs)
	{
	throw new Exception(mysql_error());
	}
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}

try
{
	if(mysql_num_rows($dec_rs))
	{
		$decls=mysql_fetch_array($dec_rs,MYSQL_ASSOC);
		$decl_id=$decls['decl_id'];
		$sec_sql="SELECT s.section_id, s.section_name, ds.user_confirmed, ds.user_completed, ds.confirmed_on, ds.completed_on
			FROM sections s, declaration_sections ds WHERE ds.decl_id=$decl_id and s.section_id=ds.section_id";
		$sec_rs=mysql_query($sec_sql);
		
		if(!$sec_rs)
		{
		throw new Exception(mysql_error());
		}
		
		if(mysql_num_rows($sec_rs))
		{
			$sections=array();
			while($section=mysql_fetch_array($sec_rs,MYSQL_ASSOC))
			{
				$section_id=$section['section_id'];
				$section['qanda'] = array();
				if($section['user_confirmed'] == "Y")
				{
					$det_sql="SELECT *
						FROM questions q, answers a, sections s, declaration_sections ds, declaration_details dd
						WHERE dd.decl_id =$decl_id
						AND dd.decl_id = ds.decl_id
						AND ds.section_id =$section_id
						AND ds.section_id = s.section_id
						AND s.section_id = q.section_id
						AND q.question_id = dd.question_id
						AND q.question_id = a.question_id
						AND (
								a.answer_id = dd.ans_id
								OR a.correct_result = 'Y'
								) ORDER BY dd.decl_detail_id ASC";
					$det_rs=mysql_query($det_sql);
					if(!$det_rs)
					{
					throw new Exception(mysql_error());
					}
					if(mysql_num_rows($det_rs))
					{
						//print mysql_num_rows($det_rs)."<br>";
						$prev_id="";
						$qid=$question=$u_answer=$d_answer=$f_msg="";
						$result='failed';
						while($qa=mysql_fetch_array($det_rs,MYSQL_ASSOC))
						{
							if($prev_id != "" && $prev_id != $qa['question_id'])
							{
								//print "2 " . $prev_id ." --  ".$qa['question_id']."<br>";
								$section['qanda'][]=array("qid" => $qid, "question" => $question, "u_answer" => $u_answer, "d_answer" => $d_answer,
																				"f_msg" => $f_msg, "result"=>$result);
								$prev_id="";
								$qid=$question=$u_answer=$d_answer=$f_msg="";
								$result='failed';
							}
							$qid=$qa['question_id'];
							$question=$qa['question'];
							$f_msg=$qa['failed_message'];
							if($qa['answer_id'] == $qa['ans_id'] && $qa['correct_result'] == 'Y')
								$result='passed';
							if($qa['answer_id'] == $qa['ans_id'])
								$u_answer=($qa['unhide_notes'] == "Y" || strtolower($qa['answer'])== "free text box")? $qa['prompted_comment']:$qa['answer'];
							if($qa['correct_result'] == 'Y')
								$d_answer=(strtolower($qa['answer'])== "free text box")? "":$qa['answer'];
							//print "1 ". $prev_id ." --  ".$qa['question_id']."<br>";
							$prev_id=$qa['question_id'];
						}
								$section['qanda'][]=array("qid" => $qid, "question" => $question, "u_answer" => $u_answer, "d_answer" => $d_answer,
																				"f_msg" => $f_msg, "result"=>$result);
					}
				} else {
					$section['qanda'] = null;
				}
				$sections[]=$section;
			}
		}
		$decls['sections'] = $sections;
		return $decls;
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getDeclarationDetailsArc($u_id, $decl_id)
{
try
{
	$dec_sql="SELECT decl_id, DATE_FORMAT( `decl_started_on` , '%d-%m-%Y' ) AS decl_started_on, decl_completed, DATE_FORMAT( `decl_completed_on` , '%d-%m-%Y' ) AS decl_completed_on FROM declarations_arc WHERE user_id=$u_id AND decl_id=".$decl_id;
	$dec_rs=mysql_query($dec_sql);
	if(mysql_num_rows($dec_rs))
	{
		$decls=mysql_fetch_array($dec_rs,MYSQL_ASSOC);
		$decl_id=$decls['decl_id'];
		$sec_sql="SELECT s.section_id, s.section_name, ds.user_confirmed, ds.user_completed, ds.confirmed_on, ds.completed_on
			FROM sections s, declaration_sections_arc ds WHERE ds.decl_id=$decl_id and s.section_id=ds.section_id";
		$sec_rs=mysql_query($sec_sql);
		if(!$sec_rs)
		{
		throw new Exception(mysql_error());
		}
		if(mysql_num_rows($sec_rs))
		{
			$sections=array();
			while($section=mysql_fetch_array($sec_rs,MYSQL_ASSOC))
			{
				$section_id=$section['section_id'];
				$section['qanda'] = array();
				if($section['user_confirmed'] == "Y")
				{
					$det_sql="SELECT *
						FROM questions q, answers a, sections s, declaration_sections_arc ds, declaration_details_arc dd
						WHERE dd.decl_id =$decl_id
						AND dd.decl_id = ds.decl_id
						AND ds.section_id =$section_id
						AND ds.section_id = s.section_id
						AND s.section_id = q.section_id
						AND q.question_id = dd.question_id
						AND q.question_id = a.question_id
						AND (
								a.answer_id = dd.ans_id
								OR a.correct_result = 'Y'
								) ORDER BY dd.decl_detail_id ASC";
					$det_rs=mysql_query($det_sql);
					if(!$det_rs)
					{
					throw new Exception(mysql_error());
					}
					if(mysql_num_rows($det_rs))
					{
						//print mysql_num_rows($det_rs)."<br>";
						$prev_id="";
						$qid=$question=$u_answer=$d_answer=$f_msg="";
						$result='failed';
						while($qa=mysql_fetch_array($det_rs,MYSQL_ASSOC))
						{
							if($prev_id != "" && $prev_id != $qa['question_id'])
							{
								//print "2 " . $prev_id ." --  ".$qa['question_id']."<br>";
								$section['qanda'][]=array("qid" => $qid, "question" => $question, "u_answer" => $u_answer, "d_answer" => $d_answer,
																				"f_msg" => $f_msg, "result"=>$result);
								$prev_id="";
								$qid=$question=$u_answer=$d_answer=$f_msg="";
								$result='failed';
							}
							$qid=$qa['question_id'];
							$question=$qa['question'];
							$f_msg=$qa['failed_message'];
							if($qa['answer_id'] == $qa['ans_id'] && $qa['correct_result'] == 'Y')
								$result='passed';
							if($qa['answer_id'] == $qa['ans_id'])
								$u_answer=($qa['unhide_notes'] == "Y" || strtolower($qa['answer'])== "free text box")? $qa['prompted_comment']:$qa['answer'];
							if($qa['correct_result'] == 'Y')
								$d_answer=(strtolower($qa['answer'])== "free text box")? "":$qa['answer'];
							//print "1 ". $prev_id ." --  ".$qa['question_id']."<br>";
							$prev_id=$qa['question_id'];
						}
								$section['qanda'][]=array("qid" => $qid, "question" => $question, "u_answer" => $u_answer, "d_answer" => $d_answer,
																				"f_msg" => $f_msg, "result"=>$result);
					}
				} else {
					$section['qanda'] = null;
				}
				$sections[]=$section;
			}
		}
		$decls['sections'] = $sections;
		return $decls;
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}
function getUserDetails($userid) 
{
try
{
	$sql="select * from users u, organisations o, address a where u.user_id=$userid and u.org_id=o.org_id
		and o.address_id=a.address_id";
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	return (mysql_num_rows($rs))? mysql_fetch_array($rs,MYSQL_ASSOC):null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}
function getUserDeclaration($userid)
{
try
{
	$rs= mysql_query("select decl_id from declarations where user_id=$userid and decl_completed='N' ORDER BY decl_id DESC limit 1");
	//print $sql."<br>";
	if(mysql_num_rows($rs))
	{
		return mysql_result($rs,0);
	} else {
		$sql="SELECT decl_id FROM declarations WHERE YEAR(decl_completed_on) = YEAR(CURDATE()) and decl_completed = 'Y' and user_id=$userid";
		$rs=mysql_query($sql);
		if(!$rs)
		{
		throw new Exception(mysql_error());
		}
		if(mysql_num_rows($rs))
		{
			return -1;
		} else {
			return 0;
		}
	}
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getSectionDetails($section_id)
{
try
{
	$sql="SELECT * FROM sections WHERE section_id=$section_id";
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	if(mysql_num_rows($rs)){
		return mysql_fetch_array($rs,MYSQL_ASSOC);
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getAppropSection($psection_id=0)
{
try
{

	$sql="SELECT * FROM sections ORDER BY section_id ASC LIMIT 1";
	if($psection_id>0)
	{
		$sql="SELECT * FROM sections WHERE section_id>$psection_id ORDER BY section_id ASC LIMIT 1";
	}
	//print_pre($sql);
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	
	if(mysql_num_rows($rs)){
		return mysql_fetch_array($rs,MYSQL_ASSOC);
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getIncompleteSection($decid)
{
try
{

	$sql="SELECT s.* FROM sections s, declaration_sections ds WHERE ds.decl_id=$decid and ds.section_id=s.section_id and ds.user_completed='N'
		ORDER BY ds.decl_section_id LIMIT 1";
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	if(mysql_num_rows($rs)){
		return mysql_fetch_array($rs,MYSQL_ASSOC);
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getDeclaredSection($decid)
{
try
{
	$sql="select asdddsection_id from declaration_sections where decl_id=$decid order by decl_section_id DESC limit 1";
	$rs=mysql_query($sql);
	if(!$rs)
	{
	writeErrorLog(" "."Section id for declaration id"." ".$decid." "."is not selected");
	throw new Exception(mysql_error());
	}
	else
	{
	writeErrorLog(" "."Section id for declaration id"." ".$decid." "."is selected");
	}
	return (mysql_num_rows($rs))? mysql_result($rs,0):null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function getAnsweredSection($decid)
{
try
{
	$sql="select s.section_id from sections s, questions q, declaration_details d where d.decl_id=$decid and d.question_id=q.question_id and q.section_id=s.section_id order by decl_detail_id DESC limit 1";
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	return (mysql_num_rows($rs))? mysql_result($rs,0):null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}


function StartResumeDeclaration($decid=0,$section_id)
{
try
{

	global $QUESTIONS_PER_PAGE;
	$data=array();
	$q_sql="";
	if($decid == 0)
	{
		$q_sql="select * from questions where section_id=".$section_id." LIMIT $QUESTIONS_PER_PAGE";
	} else {
		$q_sql="select * from questions q, sections s where s.section_id=$section_id and q.section_id=s.section_id
			and q.question_id not in (select question_id from declaration_details where decl_id=$decid) LIMIT $QUESTIONS_PER_PAGE";
	}
	//print $q_sql;
	$q_rs=mysql_query($q_sql);
	if(!$q_rs)
	{
	throw new Exception(mysql_error());
	}
	$section="";
	if(mysql_num_rows($q_rs))
	{
		while($qdata=mysql_fetch_array($q_rs,MYSQL_ASSOC))
		{
			if($section == "")
			{
				$section=getSectionDetails($qdata['section_id']);
				$data=array("section" => $section, "declaration" => array());
			}
			$qdata['ansdata']=getAnswers($qdata['question_id']);
			$data['declaration'][]=$qdata;
		}
		return $data;
	}
	return null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}
function getAnswers($question_id)
{
try
{
	$sql="select * from answers where question_id=".$question_id;
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	$data=array();
	if(mysql_num_rows($rs)) {
		while($data[]=mysql_fetch_array($rs,MYSQL_ASSOC)) { }
		array_pop($data);
	}
	//print_pre($data);
	return ($data)? $data:null;
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}

function saveDeclaration($userid,$declid,$decldetails=null)
{
	//print_pre($decldetails);
	try
	{
	if($declid == 0)
	{
		$ins_sql="INSERT into declarations (user_id) values($userid)";
		$ins_res=mysql_query($ins_sql);
		
		$declid=mysql_insert_id();
		if($ins_res)
		{
		writeErrorLog(" "."user id "." ".$userid." "."is inserted");
		}
		else
		{
		writeErrorLog(" "."user id"." ".$userid." "." is not inserted");
		throw new Exception(mysql_error());
		}
	}
	}
	catch(Exception $e)
	{
	writeErrorLog("Error:".$e->getMessage());
	}
	try
	{
	if($declid > 0)
	{
		if(is_null($decldetails))
		{
			return $declid;
		} else 
		{
			foreach($decldetails as $decldetail)
			{
				$dec_ins_sql = "INSERT into declaration_details(decl_id,question_id,ans_id,prompted_comment)
					VALUES($declid,$decldetail[0],$decldetail[1],'".mysql_real_escape_string($decldetail[2])."')";
				$rs1=mysql_query($dec_ins_sql);
			}
			if($rs1)
		    {
				writeErrorLog( " "."Answers for declaration id"." ".$declid." "."into declaration_details table is inserted");
			}
				else
			{
				writeErrorLog( " "."Answers for declaration id"." ".$declid." "."into declaration_details table is not inserted");
				throw new Exception(mysql_error());
			}
		}
	}
	}
	catch(Exception $e)
	{
	   writeErrorLog("Error:".$e->getMessage());
    }
}
function saveSectionConfirmation($decl_id, $section_id, $confirm)
{
    try 
    {
	if($confirm == "N")
	{
		
		$sql="INSERT INTO declaration_sections (decl_id, section_id, user_confirmed, user_completed, completed_on)
			VALUES($decl_id, $section_id, '".$confirm."', 'Y', now())";
			
	}
       else 
	{
		$sql="INSERT INTO declaration_sections (decl_id, section_id, user_confirmed) VALUES($decl_id, $section_id, '".$confirm."')";
		
	}
    $rs=mysql_query($sql); 
	if($rs)
	{
	writeErrorLog( " "."declaration id"." ".$decl_id." "."and section id"." ".$section_id." "."into declaration_sections table is inserted");
	
	}
	else
	{
	 writeErrorLog( " "."declaration id"." ".$decl_id." "."and section id"." ".$section_id." "."into declaration_sections table is not inserted");
	 throw new Exception(mysql_error());
	}
	return (!mysql_errno())? true:false;
	}
	catch(Exception $e)
	{
	writeErrorLog("Error:".$e->getMessage());
	}
}
function updateDeclarationCompleted($decl_id)
{
  try
  {
	$completed=true;
	$sql="SELECT section_id FROM sections";
	$rs=mysql_query($sql);
	$rows=mysql_num_rows($rs);
	if($rows)
	{
		for($i=0; $i<$rows; $i++)
		{
			$section_id = mysql_result($rs, $i);
			$sConfirmed=getSectionConfirmed($decl_id, $section_id);
			if($sConfirmed == 'Y')
			{
				if(!isSectionCompleted($decl_id, $section_id, false))
				{
					//print "21";
					$completed=false;
					break;
				}
			} else if($sConfirmed == -1) {
				//print "22";
				$completed=false;
				break;
			}
		}
	}
	if($completed)
	{
		//print "23";
		$sql="UPDATE declarations SET decl_completed='Y', decl_completed_on=now() WHERE decl_id=$decl_id";
		$rs=mysql_query($sql);
		if(!$rs)
		{
		writeErrorLog(" "."declaration id"." ".$decl_id." "."is not completed in declarations table");
		throw new Exception(mysql_error());
		}
		else
		{
		writeErrorLog(" "."declaration id"." ".$decl_id." "."is completed in declarations table");
		}
	}
	return $completed;
	}
	catch(Exception $e)
	{
	writeErrorLog("Error:".$e->getMessage());
	}
}
function getSectionConfirmed($decl_id, $section_id)
{
   try
   {
	$sql="SELECT user_confirmed FROM declaration_sections where decl_id=$decl_id and section_id=$section_id";
	//print $sql;
	$rs=mysql_query($sql);
	if(!$rs)
	{
	throw new Exception(mysql_error());
	}
	return (mysql_num_rows($rs))? mysql_result($rs,0):-1;
   }
   catch(Exception $e)
   {
   writeErrorLog("Error:".$e->getMessage());
   }
}
function isSectionCompleted($decl_id, $section_id, $upd=true)
{
try
{
$dec_sec_sql="SELECT count(*) FROM declaration_details d, questions q, sections s
		WHERE d.decl_id=$decl_id AND q.question_id = d.question_id AND q.section_id = s.section_id
		and s.section_id=$section_id";
	$dec_sec_rs=mysql_query($dec_sec_sql);
	if(!$dec_sec_rs)
	{
	throw new Exception(mysql_error());
	}

}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
	$dec_sec_ctr = (mysql_num_rows($dec_sec_rs))? mysql_result($dec_sec_rs,0):0;

	$ques_sec_sql="SELECT count(*) FROM questions q, sections s WHERE q.section_id = s.section_id
		and s.section_id=$section_id";
	$ques_sec_rs=mysql_query($ques_sec_sql);
	$ques_sec_ctr = (mysql_num_rows($ques_sec_rs))? mysql_result($ques_sec_rs,0):0;
try
{
	if(($dec_sec_ctr > 0 && $ques_sec_ctr > 0) && ($dec_sec_ctr >= $ques_sec_ctr))
	{
		if($upd)
		{
			$upd_sql="UPDATE declaration_sections SET user_completed='Y', completed_on=now() WHERE decl_id=$decl_id";
			$rs=mysql_query($upd_sql);
			if(!$rs)
			{
			writeErrorLog(" "."declaration id"." ".$decl_id." "."and section id"." ".$section_id." "."is not completed in declaration_sections table");
			throw new Exception(mysql_error());
			}
			else
			{
			writeErrorLog(" "."declaration id"." ".$decl_id." "."and section id"." ".$section_id." "."is completed in declaration_sections table");
			}
		} else {
			return true;
		}
	} else {
		return false;
	}
}
catch(Exception $e)
{
writeErrorLog("Error:".$e->getMessage());
}
}
function writeErrorLog($string)
{
           $fh=fopen($_SERVER['DOCUMENT_ROOT']."cddecv2/testfile.txt","a") or die("sorry cannot open file");
		   date_default_timezone_set('Asia/Calcutta');
           fwrite($fh,date("d/m/y - H:i:s")." ".$string.PHP_EOL);
		   fclose($fh);
}

/*	require('../fpdf17/fpdf.php');
		
	class PDF extends FPDF
	{
	// Load data
		function LoadData($file)
		{
		    // Read file lines
		    $lines = file($file);
		    $data = array();
		    foreach($lines as $line)
		        $data[] = explode(';',trim($line));
		    return $data;
		}
		
		// Simple table
		function BasicTable($header, $data)
		{
		    // Header
		    foreach($header as $col)
		        $this->Cell(40,7,$col,1);
		    $this->Ln();
		    // Data
		    foreach($data as $row)
		    {
		        foreach($row as $col)
		            $this->Cell(40,6,$col,1);
		        $this->Ln();
		    }
		}
		
		// Better table
		function ImprovedTable($header, $data)
		{
		    // Column widths
		    $w = array(40, 35, 40, 45);
		    // Header
		    for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],7,$header[$i],1,0,'C');
		    $this->Ln();
		    // Data
		    foreach($data as $row)
		    {
		        $this->Cell($w[0],6,$row[0],'LR');
		        $this->Cell($w[1],6,$row[1],'LR');
		        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
		        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
		        $this->Ln();
		    }
		    // Closing line
		    $this->Cell(array_sum($w),0,'','T');
		}
		
		// Colored table
		function FancyTable($header, $data)
		{
		    // Colors, line width and bold font
		    $this->SetFillColor(255,0,0);
		    $this->SetTextColor(255);
		    $this->SetDrawColor(128,0,0);
		    $this->SetLineWidth(.3);
		    $this->SetFont('','B');
		    // Header
		    $w = array(40, 35, 40, 45);
		    for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $this->Ln();
		    // Color and font restoration
		    $this->SetFillColor(224,235,255);
		    $this->SetTextColor(0);
		    $this->SetFont('');
		    // Data
		    $fill = false;
		    foreach($data as $row)
		    {
		        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
		        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
		        $this->Ln();
		        $fill = !$fill;
		    }
		    // Closing line
		    $this->Cell(array_sum($w),0,'','T');
		}
	}
	
	$pdf = new PDF();
	// Column headings
	$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
	// Data loading
	$data = $pdf->LoadData('countries.txt');
	$pdf->SetFont('Arial','',14);
	$pdf->AddPage();
	$pdf->BasicTable($header,$data);
	$pdf->AddPage();
	$pdf->ImprovedTable($header,$data);
	$pdf->AddPage();
	$pdf->FancyTable($header,$data);
	$pdf->Output();
	*/
?>
