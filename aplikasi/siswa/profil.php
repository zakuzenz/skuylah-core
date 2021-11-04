<?php

session_start();

if(!isset($_SESSION["login"])) {
	header("location: ../masuk.php");
}

if($_SESSION["peran"] == "admin") {
	header("location: ../admin");
} elseif($_SESSION["peran"] == "guru") {
	header("location: ../guru");
}

$id_siswa = $_SESSION["id_siswa"];

require "../koneksi-database.php";

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa WHERE id_siswa='$id_siswa' ");
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);

$id_siswa = $data_siswa["id"];

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT siswa.nama_siswa, siswa.id_siswa, siswa.kata_sandi, siswa.jenis_kelamin, siswa.no_whatsapp, siswa.alamat, kelas.nama_kelas FROM siswa INNER JOIN kelas ON kelas.id_kelas = siswa.id_kelas WHERE id='$id_siswa' ");

if(mysqli_num_rows($ambil_data_siswa) < 1) {
	$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa");
}
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../siswa">kembali</a>

	<h2>profil siswa</h2>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama</th>
			<td colspan="2"><?php echo $data_siswa["nama_siswa"]; ?></td>
		</tr>
		<tr>
			<th>id pengguna</th>
			<td colspan="2"><?php echo $data_siswa["id_siswa"]; ?></td>
		</tr>
		<tr>
			<th>kata sandi</th>
			<td><?php echo $data_siswa["kata_sandi"]; ?></td>
			<td>
				<a href="ubah-kata-sandi.php">ubah</a>
			</td>
		</tr>
		<tr>
			<th>kelas</th>
			<td colspan="2"><?php echo $data_siswa["nama_kelas"]; ?></td>
		</tr>
		<tr>
			<th>jenis kelamin</th>
			<td colspan="2"><?php echo $data_siswa["jenis_kelamin"]; ?></td>
		</tr>
		<tr>
			<th>no_whatsapp</th>
			<td colspan="2"><?php echo $data_siswa["no_whatsapp"]; ?></td>
		</tr>
		<tr>
			<th>alamat</th>
			<td colspan="2"><?php echo $data_siswa["alamat"]; ?></td>
		</tr>
	</table>
	
</body>
</html>