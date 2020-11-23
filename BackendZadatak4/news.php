<?php
	
	if (isset($action) && $action != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=" . $_GET['action'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
			print '
			<div class="news">
				<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
				<p>'  . $row['description'] . '</p>
				<time datetime="' . $row['date'] . '">' . pickerDateTimeToMysql($row['date']) . '</time>
				<hr>
			</div>';
	}
	else {
		print '<h1>Vijesti</h1>';
		$query  = "SELECT * FROM news";
		$query .= " WHERE archive='N' AND is_approved = true";
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			print '
			<div class="news">
				<a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '"><img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '"></a>
				<h2><a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">' . $row['title'] . '</a></h2>';
				if(strlen($row['description']) > 300) {
					echo substr(strip_tags($row['description']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">Više</a>';
				} else {
					echo strip_tags($row['description']);
				}
				print '
				<time datetime="' . $row['date'] . '">' . pickerDateTimeToMysql($row['date']) . '</time>
				<hr>
			</div>';
		}
	}
?>