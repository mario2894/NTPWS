<?php

if (isset($action) && $action != '') {
	$query  = "SELECT * FROM news_pictures";
	$query .= " WHERE news_pictures_id=" . $_GET['action'];
	$result = @mysqli_query($MySQL, $query);
	$row = @mysqli_fetch_array($result);
		print '
		<div>
			<img src="gallery/' . $row['picture'] . '" alt="" title="">
		</div>
		
		';
}
else {
print '<h1>Galerija</h1>';
		$query  = "SELECT np.*, nw.title FROM news_pictures np JOIN news nw ON np.news_id = nw.id";
		$query .= " ORDER BY np.news_id DESC";
		$result = @mysqli_query($MySQL, $query);
		while($row = @mysqli_fetch_array($result)) {
			print '
			<div id="gallery">
				<figure id="' . $row["news_pictures_id"] . '">
					<a href="index.php?menu=' . $menu . '&amp;action=' . $row['news_pictures_id'] . '"><img src="gallery/' . $row['picture'] . '" alt="' . $row["title"] . '" title="' . $row["title"] . '"></a>
					<figcaption>' . $row["title"] . '<figcaption>
				</figure>
			</div>';
		}
}
?>