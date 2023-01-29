<?php
require 'functions.php';

if(isset($_POST["register"]) ) {

	if (registrasi($_POST ) > 0) {
		echo "<script>
				alert('User baru berhasil ditambahkan!');
		</script>";
	} else{
		echo mysqli_error($conn);
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Registrasi</title>
	<link rel="stylesheet" type="text/css" href="css/styleregistrasi.css">
</head>
<body>
<div class="container">
<h1>Registrasi</h1>

<form action="" method="post">
	<label for="ussername">Username :</label>
	<input type="text" name="ussername" id="ussername"required>
	<br><br>
	<label for="password">Password :</label>
	<input type="password" name="password" id="password"required>
	<br><br>
	<label for="password2">Konfirmasi Password :</label>
	<input type="password" name="password2" id="password2"required>
	<br><br>
	<button type="submit" name="register">Kirim</button>
	<br><br>
	<label>Anda sudah punya akun?</label>
	<a href="login.php" >Masuk!</a>	


</form>
</div>
</body>
</html>