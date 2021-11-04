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

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas");

$ambil_data_hari = mysqli_query($koneksi_database, "SELECT * FROM hari");

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran");

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru");

if (isset($_POST["tambah"])) {
	var_dump($_POST);
	$id_kelas = $_POST["id_kelas"];
	$id_hari = $_POST["id_hari"];
	$id_mata_pelajaran = $_POST["id_mata_pelajaran"];
	$id_guru = $_POST["id_guru"];
	$waktu_mulai = $_POST["waktu_mulai"];
	$waktu_selesai = $_POST["waktu_selesai"];


	$kueri_tambah = mysqli_query($koneksi_database, "INSERT INTO jadwal(id_kelas, id_hari, id_mata_pelajaran, id_guru, waktu_mulai, waktu_selesai) VALUES('$id_kelas','$id_hari','$id_mata_pelajaran','$id_guru','$waktu_mulai','$waktu_selesai') ");

	if($kueri_tambah) {
		header("location: ../admin/daftar-jadwal.php");
	} else {
		die(mysqli_error($koneksi_database));
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-jadwal.php">kembali</a>

	<h2>tambah jadwal</h2>

	<form method="post">

		<select name="id_kelas">
			<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
				<option value="<?php echo $data_kelas["id_kelas"]; ?>"><?php echo $data_kelas["nama_kelas"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_hari">
			<?php while($data_hari = mysqli_fetch_assoc($ambil_data_hari)) : ?>
				<option value="<?php echo $data_hari["id_hari"]; ?>"><?php echo $data_hari["nama_hari"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_mata_pelajaran">
			<?php while($data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran)) : ?>
				<option value="<?php echo $data_mata_pelajaran["id_mata_pelajaran"]; ?>"><?php echo $data_mata_pelajaran["nama_mata_pelajaran"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_guru">
			<?php while($data_guru = mysqli_fetch_assoc($ambil_data_guru)) : ?>
				<option value="<?php echo $data_guru["id"]; ?>"><?php echo $data_guru["nama_guru"]; ?></option>
			<?php endwhile; ?>
		</select>
		
		<input type="time" name="waktu_mulai">
		
		<input type="time" name="waktu_selesai">

		<button type="submit" name="tambah">tambah</button>

	</form>

</body>
</html>