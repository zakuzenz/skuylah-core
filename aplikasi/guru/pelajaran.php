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
// var_dump($data_guru);

$id_guru = $data_guru["id"];

$id_kelas = $_GET["id-kelas"];
$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];
$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

// var_dump($id_guru, $id_kelas, $id_jenis_pelajaran);

$kueri_data_pelajaran = "
	SELECT
		id_pelajaran,
		tanggal,
		pelajaran
	FROM pelajaran
	WHERE
	id_kelas = '$id_kelas' AND
	id_jenis_pelajaran = '$id_jenis_pelajaran' AND
	id_guru = '$id_guru'
	ORDER BY tanggal DESC
";

$ambil_data_pelajaran = mysqli_query($koneksi_database, $kueri_data_pelajaran);
// var_dump($ambil_data_pelajaran);

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas' ");
$data_kelas = mysqli_fetch_assoc($ambil_data_kelas);

$ambil_data_jenis_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM jenis_pelajaran WHERE id_jenis_pelajaran='$id_jenis_pelajaran' ");
$data_jenis_pelajaran = mysqli_fetch_assoc($ambil_data_jenis_pelajaran);

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran WHERE id_mata_pelajaran='$id_mata_pelajaran' ");
$data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran);



?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../guru/jadwal-mengajar.php">kembali</a> |
	<a href="unggah.php?
		id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&id-kelas=<?php echo $id_kelas; ?>&&id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>">unggah</a>
	<br><br>

	<h2><?php echo $data_jenis_pelajaran["nama_jenis_pelajaran"] . " " . $data_mata_pelajaran["nama_mata_pelajaran"] . " kelas " . $data_kelas["nama_kelas"]; ?></h2>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>no.</th>
			<th>tanggal</th>
			<th>pelajaran</th>
			<th>aksi</th>
		</tr>
		<?php $no = 1; ?>
		<?php while($data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran)) : ?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $data_pelajaran["tanggal"]; ?></td>
			<td><?php echo $data_pelajaran["pelajaran"]; ?></td>
			<td>
				<a href="daftar-hadir-siswa.php?
					id-kelas=<?php echo $id_kelas; ?>&&
					id-pelajaran=<?php echo $data_pelajaran['id_pelajaran']; ?>&&
					id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&
					id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>
				">daftar hadir siswa</a> |
				<a href="../file/hapus-pelajaran.php?id=<?php echo $data_pelajaran['id_pelajaran']; ?>&&id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&id-kelas=<?php echo $id_kelas; ?>&&id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>" onclick="return confirm('serius mau dihapus?');">hapus</a>
			</td>
		</tr>
		<?php $no++; ?>
		<?php endwhile; ?>
	</table>

</body>
</html>