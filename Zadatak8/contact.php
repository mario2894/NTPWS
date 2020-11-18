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
		<div class="banner-image"></div>
		<nav>
			<ul>
			  <li><a href="index.php">Početna stranica</a></li>
			  <li><a href="news.php">Novosti</a></li>
			  <li><a href="contact.php">Kontakt</a></li>
			  <li><a href="#">O nama</a></li>
			  <li><a href="gallery.php">Galerija</a></li>
			</ul>
		</nav>
	</header>
	<main>
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
		</div>
	</main>
	<footer>
		<p>Copyright &copy; 2020 Mario Tušek. <a href="https://github.com/mario2894/ntpws"><img src="img/GitHub.png" title="Github" alt="Github"></a></p>
	</footer>
</body>
</html>