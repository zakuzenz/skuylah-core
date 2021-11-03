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

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru WHERE id='$id' ");
$data_guru = mysqli_fetch_assoc($ambil_data_guru);

if(isset($_POST["edit"])) {
	// var_dump($_POST); die();

	$nama_guru = $_POST["nama_guru"];

	$edit_guru = mysqli_query($koneksi_database, "UPDATE guru SET nama_guru = '$nama_guru' WHERE id='$id' ");

	if($edit_guru) {
		header("location: ../admin/detail-guru.php?id=$id");
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/detail-guru.php?id=<?php echo $id; ?>">kembali</a>

	<br><br>

	<form method="post">

		<input type="text" name="nama_guru" placeholder="nama guru" value="<?php echo $data_guru['nama_guru']; ?>">

		<br><br>

		<button type="submit" name="edit">simpan perubahan</button>
		
	</form>
	
</body>
</html>