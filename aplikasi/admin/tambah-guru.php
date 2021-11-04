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
	
	$ambil_data_guru = mysqli_query($koneksi_database, "SELECT id_guru FROM guru ORDER BY id DESC LIMIT 1");

	if(mysqli_num_rows($ambil_data_guru) < 1) {

		$id_guru = "G0001";

	} else {

		$data_guru = mysqli_fetch_assoc($ambil_data_guru);
		
		$id_guru = $data_guru["id_guru"];
		$id_guru = substr($id_guru, 1,5);
		$id_guru = $id_guru + 1;

		if(strlen($id_guru) == 1) {

			$id_guru = "G000" . $id_guru;

		} elseif(strlen($id_guru) == 2) {

			$id_guru = "G00" . $id_guru;

		} elseif(strlen($id_guru) == 3) {

			$id_guru = "G0" . $id_guru;

		} elseif(strlen($id_guru) == 4) {

			$id_guru = "G" . $id_guru;

		}
	}

	$id_sekolah = $_SESSION["id_sekolah"];
	$nama_guru = $_POST["nama_guru"];

	$no_whatsapp = $_POST["no_whatsapp"];
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$alamat = $_POST["alamat"];

	// var_dump($id_sekolah, $id_guru, $nama_guru); die();

	$tambah_guru = mysqli_query($koneksi_database, "INSERT INTO guru(id_sekolah, id_guru, nama_guru, no_whatsapp, jenis_kelamin, alamat) VALUES('$id_sekolah', '$id_guru', '$nama_guru', '$no_whatsapp', '$jenis_kelamin', '$alamat') ");

	if($tambah_guru) {
		header("location: ../admin/daftar-guru.php");
	} else {
		die(mysqli_error($koneksi_database));
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-guru.php">kembali</a>

	<br><br>

	<form method="post">

		<input type="text" name="nama_guru" placeholder="nama guru">

		<input type="text" name="no_whatsapp" placeholder="no whatsapp">

		<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
		<label for="laki-laki">laki-laki</label>
		<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
		<label for="perempuan">perempuan</label>

		<textarea name="alamat" cols="30" rows="3" placeholder="alamat" ></textarea>

		<button type="submit" name="tambah">tambah</button>
		
	</form>
	
</body>
</html>