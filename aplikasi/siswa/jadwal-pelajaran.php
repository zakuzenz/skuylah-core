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

$kueri_data_siswa = "	SELECT
				siswa.nama_siswa,
				siswa.id_kelas,
				kelas.nama_kelas
			FROM siswa
			INNER JOIN kelas ON kelas.id_kelas = siswa.id_kelas
			WHERE siswa.id_siswa='$id_siswa' ";

$ambil_data_siswa = mysqli_query($koneksi_database, $kueri_data_siswa);
$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
// var_dump($data_siswa);

$id_kelas = $data_siswa["id_kelas"];

$kueri_data_jadwal ="
SELECT 
	jadwal.id_kelas,
	jadwal.id_mata_pelajaran,
	jadwal.waktu_mulai,
	jadwal.waktu_selesai,

	hari.nama_hari,
	mata_pelajaran.nama_mata_pelajaran,
	guru.nama_guru
FROM jadwal
	INNER JOIN hari ON hari.id_hari = jadwal.id_hari
	INNER JOIN mata_pelajaran ON mata_pelajaran.id_mata_pelajaran = jadwal.id_mata_pelajaran
	INNER JOIN guru ON guru.id = jadwal.id_guru
WHERE jadwal.id_kelas = $id_kelas
ORDER BY jadwal.id_hari, jadwal.waktu_mulai ASC
					";

$ambil_data_jadwal = mysqli_query($koneksi_database, $kueri_data_jadwal);
// var_dump(mysqli_fetch_assoc($ambil_data_jadwal)); die();
$waktu_saat_ini = date("H:i:s");
$hari_saat_ini = date("l");

if($hari_saat_ini == "Sunday") {
	$hari_saat_ini = "ahad";
} elseif($hari_saat_ini == "Monday") {
	$hari_saat_ini = "senin";
} elseif($hari_saat_ini == "Tuesday") {
	$hari_saat_ini = "selasa";
} elseif($hari_saat_ini == "Wednesday") {
	$hari_saat_ini = "rabu";
} elseif($hari_saat_ini == "Thursday") {
	$hari_saat_ini = "kamis";
} elseif($hari_saat_ini == "Friday") {
	$hari_saat_ini = "jum'at";
} elseif($hari_saat_ini == "Saturday") {
	$hari_saat_ini = "sabtu";
}

// $hari_saat_ini = "senin";

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../siswa">kembali</a> <br><br>

	<h2>Jadwal Pelajaran Kelas <?php echo $data_siswa["nama_kelas"]; ?></h2>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>hari</th>
			<th>mata pelajaran</th>
			<th>guru</th>
			<th>waktu mulai</th>
			<th>waktu selesai</th>
			<th>aksi</th>
		</tr>
		<?php while($data_jadwal = mysqli_fetch_assoc($ambil_data_jadwal)) : ?>
		<tr>
			<td><?php echo $data_jadwal["nama_hari"]; ?></td>
			<td><?php echo $data_jadwal["nama_mata_pelajaran"]; ?></td>
			<td><?php echo $data_jadwal["nama_guru"]; ?></td>
			<td><?php echo $data_jadwal["waktu_mulai"]; ?></td>
			<td><?php echo $data_jadwal["waktu_selesai"]; ?></td>
			<td>
				<?php if ($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini < $data_jadwal["waktu_mulai"]): ?>
					<p>belum waktunya masuk kelas</p>
				<?php elseif($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini > $data_jadwal["waktu_selesai"]) : ?>
					<p>belum waktunya masuk kelas</p>
				<?php elseif($hari_saat_ini != $data_jadwal["nama_hari"] && $waktu_saat_ini >= $data_jadwal["waktu_mulai"] AND $waktu_saat_ini <= $data_jadwal["waktu_selesai"]) : ?>
					<p>belum waktunya masuk kelas</p>
				<?php elseif($hari_saat_ini == $data_jadwal["nama_hari"] && $waktu_saat_ini < $data_jadwal["waktu_mulai"]) : ?>
					<p>belum waktunya masuk kelas</p>
				<?php elseif($hari_saat_ini == $data_jadwal["nama_hari"] && $waktu_saat_ini > $data_jadwal["waktu_selesai"]) : ?>
					<p>waktu sudah lewat</p>
				<?php else: ?>
					<a href="pelajaran.php?id-mata-pelajaran=<?php echo $data_jadwal['id_mata_pelajaran']; ?>">masuk kelas</a>
				<?php endif ?>
			</td>
		</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>