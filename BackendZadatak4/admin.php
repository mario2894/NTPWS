<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		
		if (!isset($action) && $_SESSION['user']['role_id'] != 1) { $action = 2; }
		if (!isset($action) && $_SESSION['user']['role_id'] == 1) { $action = 1; }

		print '
		<h1>Administracija</h1>
		<div id="admin">
			<ul>';
			if ($_SESSION['user']['role_id'] == 1) {
				print	'<li><a href="index.php?menu=8&amp;action=1">Korisnici</a></li>';
			}
				print '<li><a href="index.php?menu=8&amp;action=2">Vijesti</a></li>
			</ul>';
			# Admin Users
			if ($action == 1) { include("admin/users.php"); }
			
			# Admin News
			else if ($action == 2) { include("admin/news.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Molimo Vas da se registrirate ili prijavite sa Vašim pristupnim podacima!</p>';
		header("Location: index.php?menu=7");
	}
?>