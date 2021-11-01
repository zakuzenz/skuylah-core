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

$id_admin = $_SESSION["id_admin"];

require "../koneksi-database.php";

$ambil_data_admin = mysqli_query($koneksi_database, "SELECT * FROM admin WHERE id_admin='$id_admin' ");
$data_admin = mysqli_fetch_assoc($ambil_data_admin);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../keluar.php">keluar</a>

	<h2><?php echo $data_admin["nama_admin"]; ?></h2>

	<a href="daftar-kelas.php">daftar kelas</a> |
	<a href="daftar-guru.php">daftar guru</a> |
	<a href="daftar-siswa.php">daftar siswa</a> |
	
</body>
</html>