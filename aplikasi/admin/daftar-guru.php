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

$ambil_data_guru = mysqli_query($koneksi_database, "SELECT * FROM guru");

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin">kembali</a>

	<h2>daftar guru</h2>

	<a href="tambah-guru.php">tambah guru</a>

	<br><br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>id guru</th>
			<th>nama guru</th>
			<th>aksi</th>
		</tr>
		<?php while($data_guru = mysqli_fetch_assoc($ambil_data_guru)) : ?>
			<tr>
				<td><?php echo $data_guru["id_guru"]; ?></td>
				<td><?php echo $data_guru["nama_guru"]; ?></td>
				<td>
					<a href="detail-guru.php?id=<?php echo $data_guru["id"]; ?>">detail</a> |
					<a href="hapus-data.php?data=guru&&id-data=<?php echo $data_guru["id"]; ?>" onclick="return confirm('serius mau dihapus?');">hapus</a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>