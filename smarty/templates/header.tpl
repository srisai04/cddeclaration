<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Website description" />
	<meta name="keywords" content="keyword1,keyword2" />
	<link rel="shortcut icon" href="_images/favicon.ico" />

	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/validations.js"></script>
    <script type="text/javascript" src="cal/calendar_eu.js"></script>

	<link rel="stylesheet" href="_css/reset.css" />
	<link rel="stylesheet" href="_css/main_stylesheet.css" />
	<link rel="stylesheet" href="cal/calendar.css" type="text/css" />
	
	<!--[if lte IE 6]>
		<link rel="stylesheet" href="_css/ie6_stylesheet.css" />
	<![endif]-->
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="_css/ie7_stylesheet.css" />
	<![endif]-->

	<title>CD Declaration</title>
	
</head>

<body><div id="divContainer">
	<div id="divHeader">
		<img class="left" src="_images/header/cd_logo.jpg" alt="CD Declaration" />
		<img class="right" src="_images/header/mmp_logo.jpg" alt="CD Declaration" />
	</div>
	
	<div id="divPage">
		<ul id="ulTopNav">
			{if $sessionroleid != null}
				<li class="first"><a href="logout.php">Log Out</a></li>
				<li><a href="account.php">Quick Links</a></li>
				<li>Welcome {$session_name}</li>
			{/if}		
		</ul>