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

$kueri_data_jadwal = "
SELECT
	jadwal.id_jadwal,
	kelas.id_kelas,
	kelas.nama_kelas,
	hari.id_hari,
	hari.nama_hari,
	mata_pelajaran.id_mata_pelajaran,
	mata_pelajaran.nama_mata_pelajaran,
	guru.id,
	guru.nama_guru,
	jadwal.waktu_mulai,
	jadwal.waktu_selesai
FROM jadwal
INNER JOIN kelas ON kelas.id_kelas = jadwal.id_kelas
INNER JOIN hari ON hari.id_hari = jadwal.id_hari
INNER JOIN mata_pelajaran ON mata_pelajaran.id_mata_pelajaran = jadwal.id_mata_pelajaran
INNER JOIN guru ON guru.id = jadwal.id_guru
";

$ambil_data_jadwal = mysqli_query($koneksi_database, $kueri_data_jadwal);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin">kembali</a>

	<h2>daftar jadwal</h2>

	<a href="tambah-jadwal.php">tambah jadwal</a>

	<br><br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>kelas</th>
			<th>hari</th>
			<th>mata pelajaran</th>
			<th>guru</th>
			<th>waktu mulai</th>
			<th>waktu selesai</th>
			<th>aksi</th>
		</tr>
		<?php while($data_jadwal = mysqli_fetch_assoc($ambil_data_jadwal)) : ?>
		<tr>
			<td><?php echo $data_jadwal["nama_kelas"]; ?></td>
			<td><?php echo $data_jadwal["nama_hari"]; ?></td>
			<td><?php echo $data_jadwal["nama_mata_pelajaran"]; ?></td>
			<td><?php echo $data_jadwal["nama_guru"]; ?></td>
			<td><?php
				$waktu_mulai = $data_jadwal["waktu_mulai"];
				$waktu_mulai = explode(":", $waktu_mulai);
				$waktu_mulai = $waktu_mulai[0] . ":" . $waktu_mulai[1];

				echo $waktu_mulai;
			?></td>
			<td><?php
				$waktu_selesai = $data_jadwal["waktu_selesai"];
				$waktu_selesai = explode(":", $waktu_selesai);
				$waktu_selesai = $waktu_selesai[0] . ":" . $waktu_selesai[1];

				echo $waktu_selesai;
			?></td>
			<td>
				<a href="edit-jadwal.php?id=<?php echo $data_jadwal["id_jadwal"]; ?>">edit</a> |
				<a href="hapus-data.php?data=jadwal&&id-data=<?php echo $data_jadwal["id_jadwal"]; ?>">hapus</a>
			</td>
		</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>