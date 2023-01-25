<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: login.php");
	exit;
}
require 'functions.php';

// ambil daa di URL
$id=$_GET["id"];
// query dataa berdasarkan id
$data=query("SELECT * FROM tbl_databarang WHERE id=$id")[0];

// cek tombol submit
if( isset($_POST["submit"]) ) {
	
	// cek data apakah berhasil diubah
	if(ubah($_POST) > 0){
		echo "
		<script>
		alert('Data Berhasil Diubah');
		document.location.href='index.php';
		</script>
		" ;
	} else {
		echo "
		<script>
		alert('Data Gagal Diubah');
		document.location.href='index.php';
		</script>
		" ;
		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah data</title>
</head>
<body>
	<h1>Ubah Data Barang</h1>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $data["id"]; ?>">
		<input type="hidden" name="gambarLama" value="<?= $data["gambar"]; ?>">
		<label for="kode">Kode Barang :</label>
		<input type="text" name="kode" id="kode" required value="<?= $data["kode"]; ?>" >
		<br><br>
		<label for="nama">Nama Barang :</label>
		<input type="text" name="nama" id="nama" value="<?= $data["nama"]; ?>">
		<br><br>
		<label for="jenis">Jenis Barang :</label>
		<input type="text" name="jenis" id="jenis" value="<?= $data["jenis"]; ?>">
		<br><br>
		<label for="harga">Harga Barang :</label>
		<input type="text" name="harga" id="harga" value="<?= $data["harga"]; ?>">
		<br><br>
		<label for="gambar">Gambar :</label><br>
		<img src="img/<? = $data['gambar']; ?>" width="40"> <br>
		<input type="file" name="gambar" id="gambar">
		<br><br>
		<button type="submit" name="submit">Kirim</button>

	</form>

</body>
</html>