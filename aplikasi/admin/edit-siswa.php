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
// var_dump($data_siswa);
$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas ");

if(isset($_POST["edit"])) {
	// var_dump($_POST); die();

	$nama_siswa = $_POST["nama_siswa"];
	$id_kelas = $_POST["id_kelas"];
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$tanggal_lahir = $_POST["tanggal_lahir"];
	$no_whatsapp = $_POST["no_whatsapp"];
	$nama_ayah = $_POST["nama_ayah"];
	$nama_ibu = $_POST["nama_ibu"];
	$alamat = $_POST["alamat"];

	$edit_siswa = mysqli_query($koneksi_database, "UPDATE siswa SET nama_siswa = '$nama_siswa', id_kelas = '$id_kelas', jenis_kelamin = '$jenis_kelamin', tanggal_lahir = '$tanggal_lahir', no_whatsapp = '$no_whatsapp', nama_ayah = '$nama_ayah', nama_ibu = '$nama_ibu', alamat = '$alamat' WHERE id='$id' ");

	if($edit_siswa) {
		header("location: ../admin/detail-siswa.php?id=$id");
	} else {
		die(mysqli_error($koneksi_database));
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/detail-siswa.php?id=<?php echo $id; ?>">kembali</a>

	<br><br>

	<form method="post">

		<input type="text" name="nama_siswa" placeholder="nama siswa" value="<?php echo $data_siswa['nama_siswa']; ?>">

		<select name="id_kelas">
			<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
				<option value="<?php echo $data_kelas["id_kelas"]; ?>"><?php echo $data_kelas["nama_kelas"]; ?></option>
			<?php endwhile; ?>
		</select>

		<?php if ($data_siswa["jenis_kelamin"] == NULL): ?>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
			<label for="perempuan">perempuan</label>
		<?php elseif($data_siswa["jenis_kelamin"] == "perempuan") : ?>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" checked>
		<?php elseif($data_siswa["jenis_kelamin"] == "laki-laki") : ?>
			<label for="perempuan">perempuan</label>
			<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki" checked>
			<label for="laki-laki">laki-laki</label>
			<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
			<label for="perempuan">perempuan</label>
		<?php endif; ?>

		<input type="date" name="tanggal_lahir" value="<?php echo $data_siswa["tanggal_lahir"]; ?>">

		<input type="text" name="no_whatsapp" placeholder="no whatsapp" value="<?php echo $data_siswa["no_whatsapp"]; ?>">

		<input type="text" name="nama_ayah" placeholder="nama ayah" value="<?php echo $data_siswa["nama_ayah"]; ?>">

		<input type="text" name="nama_ibu" placeholder="nama ibu" value="<?php echo $data_siswa["nama_ibu"]; ?>">

		<textarea name="alamat" cols="30" rows=3 placeholder="alamat"><?php echo $data_siswa["alamat"]; ?></textarea>

		<br><br>

		<button type="submit" name="edit">simpan perubahan</button>
		
	</form>
	
</body>
</html>