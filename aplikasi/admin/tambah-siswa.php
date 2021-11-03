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
	// var_dump($_POST); die();
	
	$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT id_siswa FROM siswa ORDER BY id DESC LIMIT 1");

	if(mysqli_num_rows($ambil_data_siswa) < 1) {

		$id_siswa = "S0001";

	} else {

		$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
		
		$id_siswa = $data_siswa["id_siswa"];
		$id_siswa = substr($id_siswa, 1,5);
		$id_siswa = $id_siswa + 1;

		if(strlen($id_siswa) == 1) {

			$id_siswa = "S000" . $id_siswa;

		} elseif(strlen($id_siswa) == 2) {

			$id_siswa = "S00" . $id_siswa;

		} elseif(strlen($id_siswa) == 3) {

			$id_siswa = "S0" . $id_siswa;

		} elseif(strlen($id_siswa) == 4) {

			$id_siswa = "S" . $id_siswa;

		}
	}

	$id_sekolah = $_SESSION["id_sekolah"];
	$nama_siswa = $_POST["nama_siswa"];

	// var_dump($id_siswa, $nama_siswa, $kelas); die();

	$tambah_siswa = mysqli_query($koneksi_database, "INSERT INTO siswa(id_sekolah, id_siswa, nama_siswa) VALUES('$id_sekolah', '$id_siswa' ,'$nama_siswa') ");

	if($tambah_siswa) {
		header("location: ../admin/daftar-siswa.php");
	} else {
		die(mysqli_error($koneksi_database));
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-siswa.php">kembali</a>

	<form method="post">

		<input type="text" name="nama_siswa" placeholder="nama siswa">

		<button type="submit" name="tambah">tambah</button>
		
	</form>
	
</body>
</html>