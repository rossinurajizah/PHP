<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");
	exit;
}

require 'functions.php';
$databarang= query("SELECT * FROM tbl_databarang");

// tombol cari ditekan
if( isset($_POST["cari"]) ) {
	$databarang=cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
	<a href="logout.php">Logout</a>

<h1>Data Barang</h1>
<a href="tambah.php">Tambah Data Barang</a>
<br><br>

<form action="" method="post">
	<input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian" autocomplete="off">
	<button type="submit" name="cari">Cari</button>
</form>
<br>
<table border="1" cellpadding="10" cellspacing="0">
	<tr>
		<th>No</th>
		<th>Gambar</th>
		<th>Kode</th>
		<th>Nama</th>
		<th>Jenis</th>
		<th>Harga</th>
		<th>Aksi</th>

	</tr>
	<?php $i =1; ?>
	<?php foreach ($databarang as $row) : ?>
	<tr>
		<td><?= $i; ?></td>
		<td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
		<td><?= $row["kode"]; ?></td>
		<td><?= $row["nama"]; ?></td>
		<td><?= $row["jenis"]; ?></td>
		<td><?= $row["harga"]; ?></td>
		<td>
			<a href="ubah.php?id=<?= $row["id"]; ?> ">Edit</a> | <a href="hapus.php?id=<?= $row["id"]; ?> " onclick="return confirm('Yakin?');">Delete</a>
		</td>
	</tr>
	<?php $i++; ?>
	<?php endforeach; ?>
</table>
</body>
</html>