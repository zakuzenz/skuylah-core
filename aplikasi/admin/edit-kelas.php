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

$id_kelas = $_GET["id"];

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas WHERE id_kelas='$id_kelas' ");
$data_kelas = mysqli_fetch_assoc($ambil_data_kelas);

if(isset($_POST["edit"])) {
	
	$id_sekolah = $_SESSION["id_sekolah"];
	$nama_kelas = $_POST["nama_kelas"];

	$edit_kelas = mysqli_query($koneksi_database, "UPDATE kelas SET nama_kelas = '$nama_kelas' WHERE id_kelas = '$id_kelas' ");

	if($edit_kelas) {
		header("location: ../admin/daftar-kelas.php");
	} else {
		die(mysqli_error($koneksi_database));
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-kelas.php">kembali</a>

	<form method="post">

		<input type="text" name="nama_kelas" placeholder="nama kelas" value="<?php echo $data_kelas["nama_kelas"]; ?>">

		<button type="submit" name="edit">edit</button>
		
	</form>
	
</body>
</html>