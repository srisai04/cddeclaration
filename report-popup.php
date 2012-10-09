<?php require ("inc/include.php");?>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript" src="js/reportutils.js"></script>

<?php include("charts.php"); ?>

<body>
	<?php if ($status == 1){?>
		<div id="chart_div" style="border:1px solid black;"></div>
		<script>
		window.print();
		</script>
	<?php }?>
</body>
</html>