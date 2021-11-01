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
	
	$nama_kelas = $_POST["nama_kelas"];
	$kelas = $_POST["kelas"];

	$tambah_kelas = mysqli_query($koneksi_database, "INSERT INTO kelas(nama_kelas) VALUES('$nama_kelas') ");

	if($tambah_kelas) {
		header("location: ../admin/daftar-kelas.php");
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