<?php
// koneksi ke database
$conn=mysqli_connect("localhost","root","","db_pengelolaan");


function query($query) {
	global $conn;
	$result =mysqli_query($conn,$query);
	$rows =[];
	while( $row =mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

function tambah($data) {
	global $conn;

	$kode=htmlspecialchars($data["kode"]);
	$nama=htmlspecialchars($data["nama"]);
	$jenis=htmlspecialchars($data["jenis"]);
	$harga=htmlspecialchars($data["harga"]);
	
	// upload gambar
	$gambar=upload();
	if(!$gambar) {
		return false;
	}
	
	$query="INSERT INTO tbl_databarang VALUES ('','$kode','$nama','$jenis','$harga','$gambar')";
	mysqli_query($conn,$query);

	return mysqli_affected_rows($conn);
}

function upload() {
	$namaFile=$_FILES['gambar']['name'];
	$ukuranFile=$_FILES['gambar']['size'];
	$error=$_FILES['gambar']['error'];
	$tmpName=$_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang di upload
	if($error === 4){
		echo "<script>
				alert('pilih gambar!!!!');
				</script>";
				return false;
	}
// cek apkah yang diupload adalah gambar
	$ekstensiGambarValid=['jpg','jpeg','png'];
	$ekstensiGambar=explode('.', $namaFile);
	$ekstensiGambar=strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "
		<script>
		alert('yang anda upload bukan gambar!');
		</script>";
		return false;
	}
// cek jika ukurannya terlalu besar
	if($ukuranFile > 1000000) {
		echo "
		<script>
		alert('ukuran gambar terlalu besar');
		</script>";
		return false;
	}

	// lolos pengecekkan,upload gambar
	// generate nama gambar baru
	$namaFileBaru =uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .=$ekstensiGambar;
	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;
}
function hapus($id) {
	global $conn;
	mysqli_query($conn,"DELETE FROM tbl_databarang WHERE id=$id");
	return mysqli_affected_rows($conn);
}


function ubah($data) {
	global $conn;

	$id=$data["id"];
	$kode=htmlspecialchars($data["kode"]);
	$nama=htmlspecialchars($data["nama"]);
	$jenis=htmlspecialchars($data["jenis"]);
	$harga=htmlspecialchars($data["harga"]);
	$gambarLama=htmlspecialchars($data["gambarLama"]);

// cek apakah user pilih gambar baru atau tidak
	if($_FILES['gambar']['error'] === 4) {
		$gambar =$gambarLama;
	} if(!$gambar) {
		return false;
	} else {
		$gambar=upload();
	}
	

	
	$query="UPDATE tbl_databarang SET 
				kode='$kode',
				nama='$nama',
				jenis='$jenis',
				harga='$harga',
				gambar='$gambar' 
			WHERE id=$id
			";
	mysqli_query($conn,$query);

	return mysqli_affected_rows($conn);
}

function cari($keyword){
	$query="SELECT * FROM tbl_databarang WHERE kode LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR jenis LIKE '%$keyword%' OR harga LIKE '%$keyword%' ";
	return query($query);
}

function registrasi($data) {
	global $conn;

	$ussername= strtolower (stripslashes($data["ussername"]));
	$password= mysqli_real_escape_string($conn, $data["password"]);
	$password2=mysqli_real_escape_string($conn, $data["password2"]);


	// cek ussername sudah ada atau belum
	$result = mysqli_query($conn, "SELECT ussername FROM tbl_user WHERE ussername='$ussername'");
	if(mysqli_fetch_assoc ($result) ) {
		echo "<script>
				alert('Ussername sudah terdaftar')
		</script>";
		return false;
	}

	// cek konfirmasi password
	if( $password !== $password2) {
		echo "<script> 
				alert('Konfirmasi password tidak sesuai');
		</script>";
		return false;
	}
	// enkripsi password
	$password=password_hash($password, PASSWORD_DEFAULT);
	
	// tambahkan user baru ke database
	mysqli_query($conn, "INSERT INTO tbl_user VALUES('','$ussername','$password')");
	return mysqli_affected_rows($conn);
}


?>