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
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$no_whatsapp = $_POST["no_whatsapp"];
	$alamat = $_POST["alamat"];

	$edit_guru = mysqli_query($koneksi_database, "UPDATE guru SET nama_guru = '$nama_guru', jenis_kelamin = '$jenis_kelamin', no_whatsapp = '$no_whatsapp', alamat = '$alamat' WHERE id='$id' ");

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

		<input type="text" name="no_whatsapp" placeholder="no whatsapp" value="<?php echo $data_guru['no_whatsapp']; ?>">

		<?php if ($data_guru["jenis_kelamin"] == NULL): ?>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
			<label for="perempuan">perempuan</label>
		<?php elseif($data_guru["jenis_kelamin"] == "perempuan") : ?>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" checked>
		<?php elseif($data_guru["jenis_kelamin"] == "LAKI-LAKI") : ?>
			<label for="perempuan">perempuan</label>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" checked>
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
			<label for="perempuan">perempuan</label>
		<?php endif; ?>

		<textarea name="alamat" cols="30" rows="3" placeholder="alamat" ><?php echo $data_guru['alamat']; ?></textarea>

		<br><br>

		<button type="submit" name="edit">simpan perubahan</button>
		
	</form>
	
</body>
</html>