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

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT guru.nama_guru, guru.kata_sandi, guru.jenis_kelamin, guru.no_whatsapp, guru.alamat, kelas.nama_kelas FROM guru INNER JOIN kelas ON kelas.id_kelas = guru.id_kelas WHERE id='$id' ");
$data_guru = mysqli_fetch_assoc($ambil_data_guru);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-guru.php">kembali</a>

	<h2>detail guru</h2>

	<a href="edit-guru.php?id=<?php echo $id; ?>">edit</a>

	<br><br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama</th>
			<td><?php echo $data_guru["nama_guru"]; ?></td>
		</tr>
		<tr>
			<th>kata sandi</th>
			<td><?php echo $data_guru["kata_sandi"]; ?></td>
		</tr>
		<tr>
			<th>wali kelas</th>
			<td><?php echo $data_guru["nama_kelas"]; ?></td>
		</tr>
		<tr>
			<th>jenis kelamin</th>
			<td><?php echo $data_guru["jenis_kelamin"]; ?></td>
		</tr>
		<tr>
			<th>no_whatsapp</th>
			<td><?php echo $data_guru["no_whatsapp"]; ?></td>
		</tr>
		<tr>
			<th>alamat</th>
			<td><?php echo $data_guru["alamat"]; ?></td>
		</tr>
	</table>
	
</body>
</html>