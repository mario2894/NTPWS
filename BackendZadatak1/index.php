<?php 
print '
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="styles.css">

		<title>Napredne tehnike programiranja web servisa</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="description" content="Projektni zadatak">
		<meta name="keywords" content="programiranje, web servisi">
		<meta name="author" content="Mario Tušek">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	</head>
<body>
	<header>
		<div'; 
			if ($_GET['menu'] > 1) { print ' class="banner-subimage"'; } else { print ' class="banner-image"'; }  
		print '></div>
		<nav>';
			include("menu.php");
	print '</nav>
	</header>
	<main>';
	
	if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
	else if ($_GET['menu'] == 2) { include("news.php"); }
	else if ($_GET['menu'] == 3) { include("contact.php"); }
	else if ($_GET['menu'] == 4) { include("about_us.php"); }
	else if ($_GET['menu'] == 5) { include("gallery.php"); }

	print '
	</main>
	<footer>
		<p>Copyright &copy; 2020 Mario Tušek. <a href="https://github.com/mario2894/ntpws"><img src="img/GitHub.png" title="Github" alt="Github"></a></p>¸
	</footer>
</body>
</html>';
?>