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

$kueri_data_guru = "
SELECT
	guru.id_kelas,
	kelas.nama_kelas
FROM guru
INNER JOIN kelas ON kelas.id_kelas = guru.id_kelas
WHERE id_guru='$id_guru'
";

$ambil_data_guru = mysqli_query($koneksi_database, $kueri_data_guru);
$data_guru = mysqli_fetch_assoc($ambil_data_guru);

$id_kelas = $data_guru["id_kelas"];
// var_dump($id_kelas);
$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa WHERE id_kelas='$id_kelas' ");

$tanggal_hari_ini = date("Y-m-d");

$kueri_data_pelajaran = "SELECT COUNT(pelajaran) AS 'jumlah_pelajaran' FROM pelajaran WHERE id_kelas = $id_kelas AND id_jenis_pelajaran = 1 ";

$ambil_data_pelajaran = mysqli_query($koneksi_database, $kueri_data_pelajaran);
$data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran);
// var_dump($data_pelajaran);

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../guru">kembali</a> <br>

	<h2>daftar hadir siswa kelas <?php echo $data_guru["nama_kelas"]; ?></h2>

	<p>jumlah pelajaran yang diunggah : <?php echo $data_pelajaran["jumlah_pelajaran"]; ?></p>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>nama siswa</th>
			<th>jumlah hadir</th>
			<th>jumlah tidak hadir</th>
		</tr>
		<?php while($data_siswa = mysqli_fetch_assoc($ambil_data_siswa)) : ?>
		<tr>
			<td><?php echo $data_siswa["nama_siswa"]; ?></td>
			<td>
				<?php

				$id_siswa = $data_siswa['id'];

$kueri_jumlah_hadir_siswa = "SELECT COUNT(id_siswa) AS jumlah_hadir FROM daftar_hadir_siswa WHERE id_siswa = $id_siswa AND id_jenis_pelajaran = 1";
$ambil_data_jumlah_hadir_siswa = mysqli_query($koneksi_database, $kueri_jumlah_hadir_siswa);
$data_jumlah_hadir_siswa = mysqli_fetch_assoc($ambil_data_jumlah_hadir_siswa);
echo $data_jumlah_hadir_siswa["jumlah_hadir"];

				?>
			</td>
			<td>
				<?php

$jumlah_tidak_hadir = $data_pelajaran["jumlah_pelajaran"] - $data_jumlah_hadir_siswa["jumlah_hadir"];
echo $jumlah_tidak_hadir;

				?>
			</td>
		</tr>
		<?php endwhile; ?>
	</table>
	
</body>
</html>