<?php
	print '
		<h1>Kontakt forma</h1>
		<div id="contact">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2763.295772747134!2d15.868755314912564!3d46.16476769444523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDbCsDA5JzUzLjIiTiAxNcKwNTInMTUuNCJF!5e0!3m2!1shr!2shr!4v1605629655175!5m2!1shr!2shr" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
			<form action="index.php" id="contact_form" name="contact_form" method="POST">
				<br>
				<label for="fname">Ime *</label>
				<input type="text" id="fname" name="firstname" placeholder="Vaše ime..." required>

				<label for="lname">Prezime *</label>
				<input type="text" id="lname" name="lastname" placeholder="Vaše prezime..." required>
				
				<label for="lname">E-mail adresa *</label>
				<input type="email" id="email" name="email" placeholder="Vaša e-mail adresa..." required>

				<label for="country">Država</label>
				<select id="country" name="country">
				  <option value="">Odaberite...</option>
				  <option value="HR" selected>Hrvatska</option>
				  <option value="SL">Slovenija</option>
				  <option value="AT">Austrija</option>
				  <option value="DE">Njemačka</option>
				  <option value="SR">Srbija</option>
				</select>

				<label for="subject">Poruka</label>
				<textarea id="subject" name="subject" placeholder="Upišite poruku..." style="height:200px"></textarea>

				<input type="submit" value="Pošalji">
			</form>
		</div>';
?>