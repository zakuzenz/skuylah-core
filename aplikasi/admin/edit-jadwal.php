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

$id_jadwal = $_GET["id"];

$kueri_data_jadwal = "
SELECT
	jadwal.id_jadwal,
	kelas.id_kelas,
	kelas.nama_kelas,
	hari.id_hari,
	hari.nama_hari,
	mata_pelajaran.id_mata_pelajaran,
	mata_pelajaran.nama_mata_pelajaran,
	guru.id,
	guru.nama_guru,
	jadwal.waktu_mulai,
	jadwal.waktu_selesai
FROM jadwal
	INNER JOIN kelas ON kelas.id_kelas = jadwal.id_kelas
	INNER JOIN hari ON hari.id_hari = jadwal.id_hari
	INNER JOIN mata_pelajaran ON mata_pelajaran.id_mata_pelajaran = jadwal.id_mata_pelajaran
	INNER JOIN guru ON guru.id = jadwal.id_guru
WHERE id_jadwal = '$id_jadwal'
";

$ambil_data_jadwal = mysqli_query($koneksi_database, $kueri_data_jadwal);
$data_jadwal = mysqli_fetch_assoc($ambil_data_jadwal);

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas");

$ambil_data_hari = mysqli_query($koneksi_database, "SELECT * FROM hari");

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran");

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru");

if (isset($_POST["edit"])) {
	// var_dump($_POST); die();
	$id_kelas = $_POST["id_kelas"];
	$id_hari = $_POST["id_hari"];
	$id_mata_pelajaran = $_POST["id_mata_pelajaran"];
	$id_guru = $_POST["id_guru"];
	$waktu_mulai = $_POST["waktu_mulai"];
	$waktu_selesai = $_POST["waktu_selesai"];


	$kueri_edit = mysqli_query($koneksi_database, "UPDATE jadwal SET id_kelas = '$id_kelas', id_hari = '$id_hari', id_mata_pelajaran = '$id_mata_pelajaran', id_guru = '$id_guru', waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai' WHERE id_jadwal = '$id_jadwal' ");

	if($kueri_edit) {
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

	<h2>edit jadwal</h2>

	<form method="post">

		<select name="id_kelas">
				<option value="<?php echo $data_jadwal["id_kelas"]; ?>"><?php echo $data_jadwal["nama_kelas"]; ?></option>
			<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
				<option value="<?php echo $data_kelas["id_kelas"]; ?>"><?php echo $data_kelas["nama_kelas"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_hari">
				<option value="<?php echo $data_jadwal["id_hari"]; ?>"><?php echo $data_jadwal["nama_hari"]; ?></option>
			<?php while($data_hari = mysqli_fetch_assoc($ambil_data_hari)) : ?>
				<option value="<?php echo $data_hari["id_hari"]; ?>"><?php echo $data_hari["nama_hari"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_mata_pelajaran">
				<option value="<?php echo $data_jadwal["id_mata_pelajaran"]; ?>"><?php echo $data_jadwal["nama_mata_pelajaran"]; ?></option>
			<?php while($data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran)) : ?>
				<option value="<?php echo $data_mata_pelajaran["id_mata_pelajaran"]; ?>"><?php echo $data_mata_pelajaran["nama_mata_pelajaran"]; ?></option>
			<?php endwhile; ?>
		</select>

		<select name="id_guru">
				<option value="<?php echo $data_jadwal["id"]; ?>"><?php echo $data_jadwal["nama_guru"]; ?></option>
			<?php while($data_guru = mysqli_fetch_assoc($ambil_data_guru)) : ?>
				<option value="<?php echo $data_guru["id"]; ?>"><?php echo $data_guru["nama_guru"]; ?></option>
			<?php endwhile; ?>
		</select>
		
		<input type="time" name="waktu_mulai" value="<?php echo $data_jadwal["waktu_mulai"]; ?>">
		
		<input type="time" name="waktu_selesai"  value="<?php echo $data_jadwal["waktu_selesai"]; ?>">

		<button type="submit" name="edit">edit</button>

	</form>

</body>
</html>