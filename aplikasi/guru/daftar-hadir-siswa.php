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
// var_dump($data_guru);

$id_guru = $data_guru["id"];

$id_kelas = $_GET["id-kelas"];
$id_pelajaran = $_GET["id-pelajaran"];

$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];

$kueri_data_daftar_hadir = "
	SELECT
		siswa.nama_siswa
	FROM daftar_hadir_siswa
	INNER JOIN siswa ON siswa.id = daftar_hadir_siswa.id_siswa
	WHERE
	daftar_hadir_siswa.id_kelas = '$id_kelas' AND
	daftar_hadir_siswa.id_pelajaran = '$id_pelajaran'
";

$ambil_data_daftar_hadir = mysqli_query($koneksi_database, $kueri_data_daftar_hadir);


?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="pelajaran.php?
	id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&
	id-kelas=<?php echo $id_kelas; ?>">kembali</a>

	<br><br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama siswa</th>
		</tr>
		<?php while($data_daftar_hadir = mysqli_fetch_assoc($ambil_data_daftar_hadir)) : ?>
		<tr>
			<td><?php echo $data_daftar_hadir["nama_siswa"]; ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>