<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "admin") {
	header("location: ../admin");
} elseif($_SESSION["peran"] == "siswa") {
	header("location: ../siswa");
}

$id_guru = $_SESSION["id_guru"];

require "../koneksi-database.php";

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru WHERE id_guru='$id_guru' ");
$data_guru = mysqli_fetch_assoc($ambil_data_guru);

$id_guru = $data_guru["id"];

if(isset($_POST["ubah"])) {
	$kata_sandi = $_POST["kata_sandi"];

	$kueri_ubah = mysqli_query($koneksi_database, "UPDATE guru SET kata_sandi = '$kata_sandi' WHERE id = '$id_guru' ");

	if($kueri_ubah) {
		header("location: profil.php");
	} else {
		die(mysqli_error($koneksi_database));
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="profil.php">kembali</a>

	<br><br>

	<form method="post">

		<input type="password" name="kata_sandi" placeholder="kata sandi baru">

		<button type="submit" name="ubah">ubah</button>
		
	</form>
	
</body>
</html>