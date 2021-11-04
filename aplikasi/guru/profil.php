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

$id_guru = $data_guru["id"];

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT guru.nama_guru, guru.id_guru, guru.kata_sandi, guru.jenis_kelamin, guru.no_whatsapp, guru.alamat, kelas.nama_kelas FROM guru INNER JOIN kelas ON kelas.id_kelas = guru.id_kelas WHERE id='$id_guru' ");

if(mysqli_num_rows($ambil_data_guru) < 1) {
	$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru");
}
$data_guru = mysqli_fetch_assoc($ambil_data_guru);
?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../guru">kembali</a>

	<h2>profil guru</h2>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama</th>
			<td colspan="2"><?php echo $data_guru["nama_guru"]; ?></td>
		</tr>
		<tr>
			<th>id pengguna</th>
			<td colspan="2"><?php echo $data_guru["id_guru"]; ?></td>
		</tr>
		<tr>
			<th>kata sandi</th>
			<td><?php echo $data_guru["kata_sandi"]; ?></td>
			<td>
				<a href="ubah-kata-sandi.php">ubah</a>
			</td>
		</tr>
		<tr>
			<th>wali kelas</th>
			<td colspan="2"><?php echo $data_guru["nama_kelas"]; ?></td>
		</tr>
		<tr>
			<th>jenis kelamin</th>
			<td colspan="2"><?php echo $data_guru["jenis_kelamin"]; ?></td>
		</tr>
		<tr>
			<th>no_whatsapp</th>
			<td colspan="2"><?php echo $data_guru["no_whatsapp"]; ?></td>
		</tr>
		<tr>
			<th>alamat</th>
			<td colspan="2"><?php echo $data_guru["alamat"]; ?></td>
		</tr>
	</table>
	
</body>
</html>