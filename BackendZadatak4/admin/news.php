<?php 
	
	#Add news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'add_news') {
		$_SESSION['message'] = '';
		# htmlspecialchars — Convert special characters to HTML entities
		# http://php.net/manual/en/function.htmlspecialchars.php
		$query  = "INSERT INTO news (title, description, archive)";
		$query .= " VALUES ('" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', '" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', '" . $_POST['archive'] . "')";
		$result = @mysqli_query($MySQL, $query);
		
		$ID = mysqli_insert_id($MySQL);
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
			
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			if ($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana glavna slika.</p>';
			}
        }

        require_once('news_pictures_adding.php');
		
		$_SESSION['message'] .= '<p>Uspješno dodana vijest!</p>';
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	
	# Update news
	if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_news') {
        $query  = "UPDATE news SET title='" . htmlspecialchars($_POST['title'], ENT_QUOTES) . "', description='" . htmlspecialchars($_POST['description'], ENT_QUOTES) . "', archive='" . $_POST['archive'] . "'";
        
        //Vijest može odobriti samo administrator -> role_id = 1
        if(isset($_POST['is_approved']) == true && $_SESSION['user']['role_id'] == 1) {
            $query  .= ", is_approved = " . $_POST['is_approved'];
        }
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);

        $ID = (int)$_POST['edit'];
		
		# picture
        if($_FILES['picture']['error'] == UPLOAD_ERR_OK && $_FILES['picture']['name'] != "") {
                
			# strtolower - Returns string with all alphabetic characters converted to lowercase. 
			# strrchr - Find the last occurrence of a character in a string
			$ext = strtolower(strrchr($_FILES['picture']['name'], "."));
            
			$_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'], "news/".$_picture);
			
			
			if ($ext == '.jpg' || $ext == '.jpeg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "UPDATE news SET picture='" . $_picture . "'";
				$_query .= " WHERE id=" . $ID . " LIMIT 1";
				$_result = @mysqli_query($MySQL, $_query);
				$_SESSION['message'] .= '<p>Uspješno dodana slika.</p>';
			}
        }

        require_once('news_pictures_adding.php');
		
        $_SESSION['message'] = '<p>Vijest uspješno promijenjena!</p>';
        
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End update news
	
	# Delete news
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
        
        # Delete news_picture
        $query  = "SELECT picture FROM news_pictures";
        $query .= " WHERE news_id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 

        $query  = "DELETE FROM news_pictures";
        $query .= " WHERE news_id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 

		# Delete picture
        $query  = "SELECT picture FROM news";
        $query .= " WHERE id=".(int)$_GET['delete']." LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        @unlink("news/".$row['picture']); 
		
		# Delete news
		$query  = "DELETE FROM news";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Vijest uspješno obrisana!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=2");
	}
	# End delete news
	
	
	#Show news info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		/*
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>Pregled vijesti</h2>
		<div class="news">
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['description'] . '
			<time datetime="' . $row['date'] . '">' . pickerDateTimeToMysql($row['date']) . '</time>
			<hr>
		</div>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
		*/

		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
			print '
			<h2>Pregled vijesti</h2>
			<div class="news">
				<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
				<h2>' . $row['title'] . '</h2>
			</div>';
				
			print '<div id="top">';
			//dohvaćanje slika iz galerije
				$query  = "SELECT * FROM news_pictures";
				$query .= " WHERE news_id=" . $row["id"];
				$result = @mysqli_query($MySQL, $query);
				while($row_ = @mysqli_fetch_array($result)) {
					print '
					<div id="gallery">
						<figure id="' . $row_["news_pictures_id"] . '">
							<a href="index.php?menu=2&amp;action=' . $row_['news_id'] . '&amp;pic=' . $row_["news_pictures_id"] . '"><img src="gallery/' . $row_['picture'] . '" alt="" title=""></a>
						</figure>
					</div>';
				}
				print '</div>';

				print '
			<div class="news">
				<p>'  . $row['description'] . '</p>
				<time datetime="' . $row['date'] . '">' . pickerDateTimeToMysql($row['date']) . '</time>
				
				<hr>
			</div>
			<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	
	#Add news 
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		
		print '
		<h2>Dodavanje vijesti</h2>
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="add_news">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" placeholder="Naslov vijesti..." required>
			<label for="description">Tekst *</label>
			<textarea id="description" name="description" placeholder="Tekst vijesti..." required></textarea>
				
			<label for="picture">Slika</label>
            <input type="file" id="picture" name="picture">
            
            <label for="picture">Dodatna slika 1</label>
            <input type="file" id="picture1" name="picture1">
            
            <label for="picture">Dodatna slika 2</label>
            <input type="file" id="picture2" name="picture2">
            
            <label for="picture">Dodatna slika 3</label>
            <input type="file" id="picture3" name="picture3">
            
            <label for="picture">Dodatna slika 4</label>
            <input type="file" id="picture4" name="picture4">
            
            <label for="picture">Dodatna slika 5</label>
			<input type="file" id="picture5" name="picture5">';
            
            if($_SESSION['user']['role_id'] == 1 || $_SESSION['user']['role_id'] == 2) {
                print '
			<label for="archive">Arhiva:</label><br />
            <input type="radio" name="archive" value="Y"> DA &nbsp;&nbsp;
            <input type="radio" name="archive" value="N" checked> NE';
            }
            else {
                print '<input type="hidden" id="archive" name="archive" value="N">';
            }
            
            print '
			<hr>
			
			<input type="submit" value="Spremi">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result);
		$checked_archive = false;

		print '
		<h2>Uređivanje vijesti</h2>
		<form action="" id="news_form_edit" name="news_form_edit" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="_action_" name="_action_" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			
			<label for="title">Naslov *</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="Naslov vijesti..." required>
			<label for="description">Tekst *</label>
			<textarea id="description" name="description" placeholder="Opis vijesti..." required>' . $row['description'] . '</textarea>
				
			<label for="picture">Glavna slika</label>
            <input type="file" id="picture" name="picture">
            
            <label for="picture">Dodatna slika 1</label>
            <input type="file" id="picture1" name="picture1">
            
            <label for="picture">Dodatna slika 2</label>
            <input type="file" id="picture2" name="picture2">
            
            <label for="picture">Dodatna slika 3</label>
            <input type="file" id="picture3" name="picture3">
            
            <label for="picture">Dodatna slika 4</label>
            <input type="file" id="picture4" name="picture4">
            
            <label for="picture">Dodatna slika 5</label>
			<input type="file" id="picture5" name="picture5">
						
			<label for="archive">Arhiva:</label><br />
            <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> DA &nbsp;&nbsp;
            <input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NE';
            
            if($_SESSION['user']['role_id'] == 1) {
            print '
                <br><br>
                <label for="is_approved">Odobreno:</label><br />
                <input type="radio" name="is_approved" value=true'; if($row['is_approved'] == true) { echo ' checked="checked"'; } echo ' /> DA &nbsp;&nbsp;
			    <input type="radio" name="is_approved" value=false'; if($row['is_approved'] == false) { echo ' checked="checked"'; } echo ' /> NE';
            }
            
            print '
			<hr>
			
			<input type="submit" value="Spremi">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	else {
		print '
		<h2>Vijesti</h2>
		<div id="news">
			<table>
				<thead>
					<tr>
                        <th width="16"></th>';
                        
                        if($_SESSION['user']['role_id'] == 1 || $_SESSION['user']['role_id'] == 2) {
                            print '
                            <th width="16"></th>';
                        }

                        if($_SESSION['user']['role_id'] == 1) {
                            print '
                            <th width="16"></th>';
                        }
                        
                        print '
						<th>Naslov</th>
						<th>Opis</th>
                        <th>Datum</th>
                        <th>Arhiva</th>
                        <th>Odobreno</th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM news";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
                    <tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>';
                        
                        if($_SESSION['user']['role_id'] == 1 || $_SESSION['user']['role_id'] == 2) {
                            print '
                        <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>';
                        }

                        if($_SESSION['user']['role_id'] == 1) {
                            print '
                        <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>';
                        }

                        print '
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . pickerDateTimeToMysql($row['date']) . '</td>
						<td>';
							if ($row['archive'] == 'Y') { print 'DA'; }
                            else if ($row['archive'] == 'N') { print 'NE'; }
						print '
                        </td>
                        <td>';
							if ($row['is_approved'] == false) { print '<img class="Icons" src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['is_approved'] == true) { print '<img class="Icons" src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
			<a href="index.php?menu=' . $menu . '&amp;action=' . $action . '&amp;add=true" class="AddLink">Dodaj vijest</a>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>