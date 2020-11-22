<?php 
    
    # Stop Hacking attempt
	if(!defined('__APP__')) {
		die("Pokušaj hakiranja!");
    }

    if($_SESSION['user']['role_id'] != 1) {
		die("Pokušaj hakiranja!");
    }
    
	# Update user profile
	if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
		$query  = " UPDATE users SET firstname='" . $_POST['firstname'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', country_id=" . $_POST['country'] . ", city='" . $_POST['city'] . "', street='" . $_POST['street'] . "', dateofbirth='" . $_POST['dateofbirth'] . "', role_id=" . $_POST['roles'] . ", is_active=" . $_POST['is_active'];
        $query .= " WHERE id='" . (int)$_POST['edit'] . "'";
        $query .= " LIMIT 1";
        $result = @mysqli_query($MySQL, $query);
		# Close MySQL connection
		@mysqli_close($MySQL);
        
		$_SESSION['message'] = '<p>Korisnik uspješno promijenjen!</p>';
		
		# Redirect na administraciju
		header("Location: index.php?menu=8&action=1");
	}
	# End update user profile
	
	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM users";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($MySQL, $query);

		$_SESSION['message'] = '<p>Korisnik uspješno obrisan!</p>';
		
		# Redirect
		header("Location: index.php?menu=8&action=1");
	}
	# End delete user profile
	
	
	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        
        $row_country_id = $row['country_id'];
        $row_role_id = $row['role_id'];

		print '
		<h2>Korisnički profil</h2>
		<p><b>Ime:</b> ' . $row['firstname'] . '</p>
		<p><b>Prezime:</b> ' . $row['lastname'] . '</p>
        <p><b>Korisničko ime:</b> ' . $row['username'] . '</p>';
        
        if(isset($row_role_id) == true) {
        $_query  = "SELECT * FROM roles";
		$_query .= " WHERE roles_id='" . $row_role_id . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
        
        print '
        <p><b>Rola:</b> ' .$_row['roles_name'] . '</p>';
        }
        else {
            print '
        <p><b>Rola:</b>Nema role</p>';
        }

		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE id='" . $row_country_id . "'";
		$_result = @mysqli_query($MySQL, $_query);
		$_row = @mysqli_fetch_array($_result);
        
        print '
        <p><b>Datum rođenja:</b> ' . pickerDateToMysql($row['dateofbirth']) . '</p>
        <p><b>Država:</b> ' .$_row['country_name'] . '</p>
        <p><b>Grad:</b> ' .$row['city'] . '</p>
        <p><b>Ulica:</b> ' .$row['street'] . '</p>
		<p><b>Profil izrađen:</b> ' . pickerDateTimeToMysql($row['createdon']) . '</p>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($MySQL, $query);
        $row = @mysqli_fetch_array($result);
        
        $is_active = true;
        $row_country_id = $row['country_id'];
        $row_role_id = $row['role_id'];
		
		print '
		<h2>Uređivanje korisničkog profila</h2>
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="_action_" name="_action_" value="TRUE">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
            <label for="fname">Ime *</label>
			<input type="text" id="fname" name="firstname" value = "' . $row['firstname'] . '" placeholder="Vaše ime..." required>
			<label for="lname">Prezime *</label>
            <input type="text" id="lname" name="lastname" value = "' . $row['lastname'] . '" placeholder="Vaše prezime..." required>
                    
            <label for="ldateofbirth">Datum rođenja *</label>
			<input type="date" id="ldateofbirth" name="dateofbirth" value = "' . $row['dateofbirth'] . '" placeholder="Vaš datum rođenja..." required>
				
			<label for="email">E-mail adresa *</label>
			<input type="email" id="email" name="email" value="' . $row['email'] . '" placeholder="Vaša e-mail adresa..." required>
            
            <label for="username">Korisničko ime:* <small>(Korisničko ime mora imati minimalno 4 znaka)</small></label>
			<input type="username" id="username" name="username" value="' . $row['username'] . '" placeholder="Korisničko ime..." pattern=".{4,}" required>

            <label for="roles">Rola:</label>
			<select name="roles" id="roles">
                <option value="NULL">-</option>';
                
				#Select all roles from database webprog, table roles
				$query  = "SELECT * FROM roles";
				$result = @mysqli_query($MySQL, $query);
				while($_row = @mysqli_fetch_array($result)) {
                    print '<option value="' . $_row['roles_id'] . '"';
                    if ($row_role_id == $_row['roles_id']) { print ' selected'; }
					print '>' . $_row['roles_name'] . '</option>';
				}
			print '
            </select>

            <label for="country">Država:</label>
			<select name="country" id="country">
                <option value="">-</option>';
                
				#Select all countries from database webprog, table countries
				$query  = "SELECT * FROM countries";
				$result = @mysqli_query($MySQL, $query);
				while($_row = @mysqli_fetch_array($result)) {
                    print '<option value="' . $_row['id'] . '"';
                    if ($row_country_id == $_row['id']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
            </select>
            
            <label for="lcity">Grad *</label>
            <input type="text" id="lcity" name="city" value="' . $row['city'] . '" placeholder="Vaš grad..." required>
            
            <label for="lstreet">Ulica *</label>
            <input type="text" id="lstreet" name="street" value="' . $row['street'] . '" placeholder="Vaša ulica..." required>

			</select>
			
			<label for="is_active">Aktivan:</label><br />
            <input type="radio" name="is_active" value="true"'; if($row['is_active'] == true) { echo ' checked="checked"'; $is_active = true; } echo ' /> DA &nbsp;&nbsp;
			<input type="radio" name="is_active" value="false"'; if($row['is_active'] == false) { echo ' checked="checked"'; } echo ' /> NE
			
			<hr>
			
			<input type="submit" value="Spremi">
		</form>
		<p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Natrag</a></p>';
	}
	else {
		print '
		<h2>Popis korisnika</h2>
		<div id="users">
			<table>
				<thead>
					<tr>
						<th width="16"></th>
						<th width="16"></th>
						<th width="16"></th>
						<th>Ime</th>
						<th>Prezime</th>
                        <th>E-mail</th>
                        <th>Rola</th>
                        <th>Država</th>
                        <th>Grad</th>
                        <th>Ulica</th>
						<th width="16"></th>
					</tr>
				</thead>
				<tbody>';
				$query  = "SELECT * FROM users";
				$result = @mysqli_query($MySQL, $query);
				while($row = @mysqli_fetch_array($result)) {

                    $row_country_id = $row['country_id'];
                    $row_role_id = $row['role_id'];
					print '
					<tr>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
						<td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
						<td><strong>' . $row['firstname'] . '</strong></td>
						<td><strong>' . $row['lastname'] . '</strong></td>
                        <td>' . $row['email'] . '</td>
                        <td>';
                        if(isset($row_role_id) == true) {
							$_query  = "SELECT * FROM roles";
							$_query .= " WHERE roles_id='" . $row_role_id . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
                            print $_row['roles_name'];
                        }
                        else {
                            print 'Nema role';
                        } 
                        print '
						</td>
						<td>';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE id='" . $row_country_id . "'";
							$_result = @mysqli_query($MySQL, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
                        </td>
                        <td>' . $row['city'] . '</td>
                        <td>' . $row['street'] . '</td>
						<td>';
							if ($row['is_active'] == false) { print '<img src="img/inactive.png" alt="" title="" />'; }
                            else if ($row['is_active'] == true) { print '<img src="img/active.png" alt="" title="" />'; }
						print '
						</td>
					</tr>';
				}
			print '
				</tbody>
			</table>
		</div>';
	}
	
	# Close MySQL connection
	@mysqli_close($MySQL);
?>