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

$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa WHERE id='$id' ");
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
	</table>
	
</body>
</html>