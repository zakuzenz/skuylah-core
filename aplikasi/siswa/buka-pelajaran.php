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
				siswa.id,
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

$id_pelajaran = $_GET["id-pelajaran"];
$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];

$ambil_data_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM pelajaran WHERE id_pelajaran='$id_pelajaran' ");
$data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran);

$id_mata_pelajaran = $data_pelajaran["id_mata_pelajaran"];

$id_siswa = $data_siswa["id"];

$cek_kehadiran_siswa = mysqli_query($koneksi_database, "SELECT id_siswa FROM daftar_hadir_siswa WHERE id_siswa='$id_siswa' AND id_pelajaran='$id_pelajaran' ");
// var_dump($cek_kehadiran_siswa);

if(isset($_POST["hadir"])) {

	$tanggal_hari_ini = date('Y-m-d');
	$waktu_menekan_hadir = date('His');
	$id_kelas = $id_kelas;
	$id_pelajaran = $id_pelajaran;
	$id_jenis_pelajaran = $id_jenis_pelajaran;
	$id_siswa = $id_siswa;

	$kueri_hadir = mysqli_query($koneksi_database, "
		INSERT INTO
		daftar_hadir_siswa(tanggal, waktu, id_kelas, id_pelajaran, id_jenis_pelajaran, id_siswa)
		VALUES('$tanggal_hari_ini','$waktu_menekan_hadir','$id_kelas','$id_pelajaran','$id_jenis_pelajaran','$id_siswa')
	");

	if($kueri_hadir) {
		header("location: ../siswa/buka-pelajaran.php?id-pelajaran=$id_pelajaran");
	} else {
		mysqli_error($koneksi_database);
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body onload="countDown();">

	<a href="../siswa/pelajaran.php?id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>">kembali</a> <br><br>

	<iframe src="../file/<?php echo $data_pelajaran["pelajaran"]; ?>" frameborder="0"></iframe>

	<br><br>

	<form method="post">

		<?php if(mysqli_num_rows($cek_kehadiran_siswa) < 1) : ?>
			<span id="timer" hidden=""></span>
			<span id="link"></span>
			<!-- <button disabled="" id="link">hadir</button> -->
		<?php elseif(mysqli_num_rows($cek_kehadiran_siswa) > 0) : ?>
			<p>sudah absen</p>
		<?php endif; ?>

	</form>

<script>
	var counter = 10;
	function countDown() {
	    if(counter>=0) {
	        document.getElementById("timer").innerHTML = counter;
	    }
	    else {
	        download();
	        return;
	    }
	    counter -= 1;

	    var counter2 = setTimeout("countDown()",1000);
	    return;
	}
	function download() {
	    document.getElementById("link").innerHTML = "<button type='submit' name='hadir'>hadir</button>";
	}
</script>
</body>
</html>