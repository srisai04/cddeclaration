<?php
	require_once ('jpgraph/jpgraph.php');
	require_once ('jpgraph/jpgraph_pie.php');
?>
<html>
<body>
	<table>
	<tr>
	<td>Information</td>
	<td> 
	<?php
	// Some data
	$data = array(113,5,160,3,15,10,1);
	
	// Create the Pie Graph.
	$graph = new PieGraph(300,200);
	$graph->SetShadow();
	
	// Set A title for the plot
	$graph->title->Set("CD Declaration Statistics");
	$graph->title->SetFont(FF_VERDANA,FS_BOLD,14); 
	$graph->title->SetColor("brown");
	
	// Create pie plot
	$p1 = new PiePlot($data);
	//$p1->SetSliceColors(array("red","blue","yellow","green"));
	$p1->SetTheme("earth");
	
	$p1->value->SetFont(FF_ARIAL,FS_NORMAL,10);
	// Set how many pixels each slice should explode
	$p1->Explode(array(0,15,15,25,15));

	$graph->Add($p1);
	$graph->Stroke();
	
	?>
	</td></tr>
	</table>
</body></html>