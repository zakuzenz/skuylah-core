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

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT siswa.nama_siswa, siswa.kata_sandi, kelas.nama_kelas, siswa.jenis_kelamin, siswa.tanggal_lahir, siswa.no_whatsapp, siswa.nama_ayah, siswa.nama_ibu, siswa.alamat FROM siswa INNER JOIN kelas ON kelas.id_kelas = siswa.id_kelas WHERE id='$id' ");
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-siswa.php">kembali</a>

	<h2>detail siswa</h2>

	<a href="edit-siswa.php?id=<?php echo $id; ?>">edit</a>

	<br><br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama</th>
			<td><?php echo $data_siswa["nama_siswa"]; ?></td>
		</tr>
		<tr>
			<th>kata sandi</th>
			<td><?php echo $data_siswa["kata_sandi"]; ?></td>
		</tr>
		<tr>
			<th>kelas</th>
			<td><?php echo $data_siswa["nama_kelas"]; ?></td>
		</tr>
		<tr>
			<th>jenis kelamin</th>
			<td><?php echo $data_siswa["jenis_kelamin"]; ?></td>
		</tr>
		<tr>
			<th>tanggal lahir</th>
			<td><?php echo $data_siswa["tanggal_lahir"]; ?></td>
		</tr>
		<tr>
			<th>no whatsapp</th>
			<td><?php echo $data_siswa["no_whatsapp"]; ?></td>
		</tr>
		<tr>
			<th>nama ayah</th>
			<td><?php echo $data_siswa["nama_ayah"]; ?></td>
		</tr>
		<tr>
			<th>nama ibu</th>
			<td><?php echo $data_siswa["nama_ibu"]; ?></td>
		</tr>
		<tr>
			<th>alamat</th>
			<td><?php echo $data_siswa["alamat"]; ?></td>
		</tr>
	</table>
	
</body>
</html>