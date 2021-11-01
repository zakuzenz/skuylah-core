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

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin">kembali</a>

	<h2>daftar kelas</h2>

	<a href="tambah-kelas.php">tambah kelas</a>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama kelas</th>
		</tr>
		<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
			<tr>
				<td><?php echo $data_kelas["nama_kelas"]; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>