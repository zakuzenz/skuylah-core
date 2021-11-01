<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "admin") {
	header("location: ../admin");
} elseif($_SESSION["peran"] == "guru") {
	header("location: ../guru");
}

$id_siswa = $_SESSION["id_siswa"];

require "../koneksi-database.php";

$kueri = "	SELECT * FROM siswa WHERE siswa.id_siswa='$id_siswa' ";

$ambil_data_siswa = mysqli_query($koneksi_database, $kueri);
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../keluar.php">keluar</a>
	<h2><?php echo $data_siswa["nama_siswa"]; ?></h2>

	<a href="jadwal-pelajaran.php">jadwal pelajaran</a>
	
</body>
</html>