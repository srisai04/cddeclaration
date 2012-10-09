<?php require ("inc/include.php");?>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="js/reportutils.js"></script>

<body>

<?php include("charts.php"); ?>

<br/><a href="javascript:print()"><img src="_images/print.jpeg" width="20" height="20" alt="Print"/></a>

	<?php if ($subfilter == "Question Status" && $qid != null && $qid != 0){
                			$sql = "SELECT q.question_id, q.question, s.section_code, a.answer FROM questions q, sections s, answers a WHERE q.section_id = s.section_id and q.question_id = a.question_id and q.question_id=".$qid;
                			$r1 = mysql_query($sql);
							if(!$r1){
								$msg = "Unable to retrieve question.";
							}else {
								  $i=0;
								  while($row = mysql_fetch_array($r1)){
								  	if ($i == 0){
								  		echo "</br></br>".$row['question']."</br>";
								  		$secid = $row['section_code'];
								  		echo "<input type=\"hidden\" name=\"secid\" value=\"".$row['section_code']."\"/>";
								  	}
								  	$i++;
								  	echo "".$i.")".$row['answer']. " ";
								  }
								  echo "</br></br>";
							}
      } ?>

	<?php if ($status == 1){?>
		<div id="chart_div" style="border:1px solid black;"></div>
		<script>
			//print();
		</script>
	<?php }?>
	

</body>
</html>