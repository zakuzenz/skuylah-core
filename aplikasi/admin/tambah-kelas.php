<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "guru") {
	header("location: ../guru");
} elseif($_SESSION["peran"] == "siswa") {
	header("location: ../siswa");
}

require "../koneksi-database.php";

if(isset($_POST["tambah"])) {
	
	$id_sekolah = $_SESSION["id_sekolah"];
	$nama_kelas = $_POST["nama_kelas"];

	$cek_nama_kelas = mysqli_query($koneksi_database, "SELECT nama_kelas FROM kelas WHERE nama_kelas='$nama_kelas' ");

	if(mysqli_num_rows($cek_nama_kelas) > 0) {
		echo "nama kelas sudah digunakan";
	} else {
		$tambah_kelas = mysqli_query($koneksi_database, "INSERT INTO kelas(id_sekolah, nama_kelas) VALUES('$id_sekolah', '$nama_kelas') ");

		if($tambah_kelas) {
			header("location: ../admin/daftar-kelas.php");
		} else {
			die(mysqli_error($koneksi_database));
		}

	}


}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-kelas.php">kembali</a>

	<form method="post">

		<input type="text" name="nama_kelas" placeholder="nama kelas">

		<button type="submit" name="tambah">tambah</button>
		
	</form>
	
</body>
</html>