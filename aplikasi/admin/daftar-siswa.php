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

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT siswa.id_siswa, siswa.nama_siswa, kelas.nama_kelas FROM siswa INNER JOIN kelas ON kelas.id_kelas = siswa.id_kelas ");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin">kembali</a>

	<h2>daftar siswa</h2>

	<a href="tambah-siswa.php">tambah siswa</a>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>id siswa</th>
			<th>nama siswa</th>
			<th>kelas</th>
		</tr>
		<?php while($data_siswa = mysqli_fetch_assoc($ambil_data_siswa)) : ?>
			<tr>
				<td><?php echo $data_siswa["id_siswa"]; ?></td>
				<td><?php echo $data_siswa["nama_siswa"]; ?></td>
				<td><?php echo $data_siswa["nama_kelas"]; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>