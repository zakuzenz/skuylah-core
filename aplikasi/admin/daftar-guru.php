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

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT guru.id_guru, guru.nama_guru, kelas.nama_kelas FROM guru INNER JOIN kelas ON kelas.id_kelas = guru.id_kelas ");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin">kembali</a>

	<h2>daftar guru</h2>

	<a href="tambah-guru.php">tambah guru</a>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>id guru</th>
			<th>nama guru</th>
			<th>wali kelas</th>
		</tr>
		<?php while($data_guru = mysqli_fetch_assoc($ambil_data_guru)) : ?>
			<tr>
				<td><?php echo $data_guru["id_guru"]; ?></td>
				<td><?php echo $data_guru["nama_guru"]; ?></td>
				<td><?php echo $data_guru["nama_kelas"]; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>