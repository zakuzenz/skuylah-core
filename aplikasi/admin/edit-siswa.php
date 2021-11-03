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

$id = $_GET["id"];

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa WHERE id='$id' ");
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);

if(isset($_POST["edit"])) {
	// var_dump($_POST); die();

	$nama_siswa = $_POST["nama_siswa"];

	$edit_siswa = mysqli_query($koneksi_database, "UPDATE siswa SET nama_siswa = '$nama_siswa' WHERE id='$id' ");

	if($edit_siswa) {
		header("location: ../admin/detail-siswa.php?id=$id");
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-siswa.php">kembali</a>

	<br><br>

	<form method="post">

		<input type="text" name="nama_siswa" placeholder="nama siswa" value="<?php echo $data_siswa['nama_siswa']; ?>">

		<br><br>

		<button type="submit" name="edit">simpan perubahan</button>
		
	</form>
	
</body>
</html>