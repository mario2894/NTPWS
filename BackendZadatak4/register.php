<?php 
	print '
	<h1>Registracija</h1>
	<div id="register">';
	
	if ($_POST['_action_'] == FALSE) {
		print '
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			
			<label for="fname">Ime *</label>
			<input type="text" id="fname" name="firstname" placeholder="Vaše ime..." required>
			<label for="lname">Prezime *</label>
            <input type="text" id="lname" name="lastname" placeholder="Vaše prezime..." required>
                    
            <label for="ldateofbirth">Datum rođenja *</label>
			<input type="date" id="ldateofbirth" name="dateofbirth" placeholder="Vaš datum rođenja..." required>
				
			<label for="email">E-mail adresa *</label>
			<input type="email" id="email" name="email" placeholder="Vaša e-mail adresa..." required>
            
            <label for="username">Korisničko ime:* <small>(Korisničko ime mora imati minimalno 4 znaka)</small></label>
			<input type="username" id="username" name="username" placeholder="Korisničko ime..." pattern=".{4,}" required>

			<label for="password">Lozinka:* <small>(Lozinka mora imati minimalno 6 znakova)</small></label>
			<input type="password" id="password" name="password" placeholder="Lozinka..." pattern=".{6,}" required>
            
            <label for="country">Država:</label>
			<select name="country" id="country">
                <option value="">Odaberite</option>';
                
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM countries";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '<option value="' . $row['id'] . '">' . $row['country_name'] . '</option>';
				}
			print '
            </select>
            
            <label for="lcity">Grad *</label>
            <input type="text" id="lcity" name="city" placeholder="Vaš grad..." required>
            
            <label for="lstreet">Ulica *</label>
            <input type="text" id="lstreet" name="street" placeholder="Vaša ulica..." required>
            
			<input type="submit" value="Registracija">
		</form>';
	}
	else if ($_POST['_action_'] == TRUE) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE email='" .  $_POST['email'] . "'";
		$query .= " OR username='" .  $_POST['username'] . "'";
		$result = @mysqli_query($MySQL, $query);
		
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (isset($row['email']) == false && isset($row['username']) == false) {
			# password_hash https://secure.php.net/manual/en/function.password-hash.php
			# password_hash() creates a new password hash using a strong one-way hashing algorithm
			$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
			
			$query  = "INSERT INTO users (firstname, lastname, email, username, password, country_id, city, street, dateofbirth)";
			$query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "', '" . $_POST['country'] . "', '" . $_POST['city'] . "', '" . $_POST['street'] . "', '" . $_POST['dateofbirth'] . "')";
			$result = @mysqli_query($MySQL, $query);
            
			print '<p>' . $_POST['firstname'] . ' ' .  $_POST['lastname'] . ', hvala na registraciji! </p>
			<hr>';
		}
		else {
			echo '<p>Korisnik sa navedenom e-mail adresom ili korisničkim imenom već postoji!</p>';
		}
	}
	print '
	</div>';
?>