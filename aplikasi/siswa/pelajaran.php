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

$kueri_data_siswa = "	SELECT id_kelas FROM siswa WHERE id_siswa='$id_siswa' ";

$tanggal_hari_ini = date('Y-m-d');

$ambil_data_siswa = mysqli_query($koneksi_database, $kueri_data_siswa);
	$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
	$id_kelas = $data_siswa["id_kelas"];

$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran WHERE id_mata_pelajaran='$id_mata_pelajaran' ");
$data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran);

$kueri_data_pelajaran = "
	SELECT
		pelajaran.id_pelajaran,
		pelajaran.id_jenis_pelajaran,
		pelajaran.pelajaran,

		jenis_pelajaran.nama_jenis_pelajaran,
		guru.nama_guru
	FROM pelajaran
		INNER JOIN jenis_pelajaran ON jenis_pelajaran.id_jenis_pelajaran = pelajaran.id_jenis_pelajaran
		INNER JOIN guru ON guru.id = pelajaran.id_guru
	WHERE
		pelajaran.tanggal = '$tanggal_hari_ini' AND
		pelajaran.id_kelas=$id_kelas AND
		pelajaran.id_mata_pelajaran=$id_mata_pelajaran
";

$ambil_data_pelajaran = mysqli_query($koneksi_database, $kueri_data_pelajaran);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../siswa/jadwal-pelajaran.php">kembali</a> <br><br>

	<h2>daftar pelajaran <?php echo $data_mata_pelajaran["nama_mata_pelajaran"]; ?></h2>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<!-- <th>jenis pelajaran</th> -->
			<!-- <th>nama guru</th> -->
			<th>pelajaran</th>
			<th>aksi</th>
		</tr>
		<?php while($data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran)) : ?>
		<tr>
			<!-- <td><?php echo $data_pelajaran["nama_jenis_pelajaran"]; ?></td> -->
			<!-- <td><?php echo $data_pelajaran["nama_guru"]; ?></td> -->
			<td><?php echo $data_pelajaran["pelajaran"]; ?></td>
			<td>
				<a href="buka-pelajaran.php?id-pelajaran=<?php echo $data_pelajaran['id_pelajaran']; ?>&&id-jenis-pelajaran=<?php echo $data_pelajaran['id_jenis_pelajaran']; ?>">buka</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>