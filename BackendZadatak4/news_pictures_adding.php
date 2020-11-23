<?php

# picture1
        if($_FILES['picture1']['error'] == UPLOAD_ERR_OK && $_FILES['picture1']['name'] != "") {
			$ext = strtolower(strrchr($_FILES['picture1']['name'], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture1']['tmp_name'], "gallery/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT news_pictures (news_id, picture) VALUES ('" . $ID . "', '" . $_picture . "')";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana dodatna slika 1.</p>';
			}
        }
        # picture2
        if($_FILES['picture2']['error'] == UPLOAD_ERR_OK && $_FILES['picture2']['name'] != "") {
			$ext = strtolower(strrchr($_FILES['picture2']['name'], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture2']['tmp_name'], "gallery/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT news_pictures (news_id, picture) VALUES ('" . $ID . "', '" . $_picture . "')";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana dodatna slika 2.</p>';
			}
        }
        # picture3
        if($_FILES['picture3']['error'] == UPLOAD_ERR_OK && $_FILES['picture3']['name'] != "") {
			$ext = strtolower(strrchr($_FILES['picture3']['name'], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture3']['tmp_name'], "gallery/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT news_pictures (news_id, picture) VALUES ('" . $ID . "', '" . $_picture . "')";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana dodatna slika 3.</p>';
			}
        }
        # picture4
        if($_FILES['picture4']['error'] == UPLOAD_ERR_OK && $_FILES['picture4']['name'] != "") {
			$ext = strtolower(strrchr($_FILES['picture4']['name'], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture4']['tmp_name'], "gallery/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT news_pictures (news_id, picture) VALUES ('" . $ID . "', '" . $_picture . "')";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana dodatna slika 4.</p>';
			}
        }
        # picture5
        if($_FILES['picture5']['error'] == UPLOAD_ERR_OK && $_FILES['picture5']['name'] != "") {
			$ext = strtolower(strrchr($_FILES['picture5']['name'], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture5']['tmp_name'], "gallery/".$_picture);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif') { # test if format is picture
				$_query  = "INSERT news_pictures (news_id, picture) VALUES ('" . $ID . "', '" . $_picture . "')";
                $_result = @mysqli_query($MySQL, $_query);
                $_SESSION['message'] .= '<p>Uspješno dodana dodatna slika 5.</p>';
			}
        }

?>