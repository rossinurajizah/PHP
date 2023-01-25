<?php
session_start();

if( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
}

require 'functions.php';

if(isset($_POST["login"]) ) {
	$ussername = $_POST["ussername"];
	$password = $_POST["password"];

	$result=mysqli_query($conn, "SELECT * FROM tbl_user WHERE ussername = '$ussername'");

	// cek ussername
	if( mysqli_num_rows($result) === 1) {

		// cek password
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row["password"]) ) {
			// set sssion
			$_SESSION["login"] = true;

			header("Location: index.php");
			exit;
		}
	}

	$error = true;
}






?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="css/Stylelogin.css">
</head>
<body>
<div class="container">
<h1>Login</h1>

<?php if(isset($error) ) : ?>
	<p style="color:red; font-style: italic;">Ussername/Password Salah</p>
<?php endif; ?>

<form action="" method="post">

	<label for="ussername">Ussername :</label>
	<input type="text" name="ussername" id="ussername">
	<br><br>
	<label for="password">Password :</label>
	<input type="password" name="password" id="password">
	<br><br>
	<button type="submit" name="login">Login</button>

</form>
</div>
</body>
</html>