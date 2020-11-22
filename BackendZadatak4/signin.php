<?php 

	print '
	<h1>Prijava</h1>
    <div id="signin">';

	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" name="myForm" id="myForm" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
            
			<label for="username">Korisničko ime:*</label>
			<input type="text" id="username" name="username" value="" required>
									
			<label for="password">Lozinka:*</label>
			<input type="password" id="password" name="password" value="" pattern=".{6,}" required>
									
			<input type="submit" value="Prijava">
        </form>';

	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (password_verify($_POST['password'], $row['password'])) {

			if(isset($row['is_active']) && $row['is_active'] == true) {
			#password_verify https://secure.php.net/manual/en/function.password-verify.php
			$_SESSION['user']['valid'] = 'true';
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['firstname'] = $row['firstname'];
			$_SESSION['user']['lastname'] = $row['lastname'];
			$_SESSION['user']['role_id'] = $row['role_id'];
			$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			# Redirect to admin website
				if($_SESSION['user']['role_id'] == 1)
				{
					header("Location: index.php?menu=8");
				}
				else
				{
					header("Location: index.php?menu=8&action=2");
				}
			}
			else
			{
				unset($_SESSION['user']);
				$_SESSION['message'] = '<p>Korisnički račun nije aktiviran!</p>';
				header("Location: index.php?menu=7");
			}
		}
		else {
			unset($_SESSION['user']);
			$_SESSION['message'] = '<p>Unijeli ste pogrešne podatke za prijavu!</p>';
			header("Location: index.php?menu=7");
		}
	}
	print '
	</div>';
?>