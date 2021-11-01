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

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas");
$ambil_data_jenis_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM jenis_pelajaran");
$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran");


$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];
$id_kelas = $_GET["id-kelas"];
$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas' ");
$data_kelas = mysqli_fetch_assoc($ambil_data_kelas);

$ambil_data_jenis_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM jenis_pelajaran WHERE id_jenis_pelajaran='$id_jenis_pelajaran' ");
$data_jenis_pelajaran = mysqli_fetch_assoc($ambil_data_jenis_pelajaran);

$ambil_data_mata_pelajaran = mysqli_query($koneksi_database, "SELECT * FROM mata_pelajaran WHERE id_mata_pelajaran='$id_mata_pelajaran' ");
$data_mata_pelajaran = mysqli_fetch_assoc($ambil_data_mata_pelajaran);

if(isset($_POST["unggah"])) {

	// var_dump($_FILES); die();

	$ekstensi_diperbolehkan	= array('pdf','docx');
	$nama_pelajaran = $_FILES['pelajaran']['name'];

	$x = explode('.', $nama_pelajaran);
	$ekstensi = strtolower(end($x));
	$ukuran	= $_FILES['pelajaran']['size'];
	$file_tmp = $_FILES['pelajaran']['tmp_name'];

	$tanggal_hari_ini = date('Ymd');
	
	$nama_pelajaran_baru = $tanggal_hari_ini . "-" . $data_kelas['nama_kelas'] . '-' . $data_jenis_pelajaran['nama_jenis_pelajaran'] . "-" . $data_mata_pelajaran['nama_mata_pelajaran'] . '-' . $data_guru['nama_guru'] . '-' . $nama_pelajaran ;
	// var_dump($nama_pelajaran_baru); die();

	$kelas = $id_kelas;
	$jenis_pelajaran = $id_jenis_pelajaran;
	$mata_pelajaran = $id_mata_pelajaran;

	$id_guru = $id_guru;

	// var_dump($tanggal_hari_ini, $kelas, $jenis_pelajaran, $mata_pelajaran, $id_guru, $nama_pelajaran); die();

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){

			$cek_nama_file = mysqli_query($koneksi_database, "SELECT * FROM pelajaran WHERE pelajaran='$nama_pelajaran_baru' ");
			// var_dump($cek_nama_file); die();
			if(mysqli_num_rows($cek_nama_file) > 0) {
				echo "ubah nama file terlebih dahulu";
			} else {
				$kueri_unggah = "
					INSERT INTO pelajaran
						(tanggal, id_kelas, id_jenis_pelajaran, id_mata_pelajaran, id_guru, pelajaran)
					VALUES
						($tanggal_hari_ini, $kelas, $jenis_pelajaran, $mata_pelajaran, $id_guru, '$nama_pelajaran_baru')
				";

				$unggah = mysqli_query($koneksi_database, $kueri_unggah);

				if($unggah) {
					move_uploaded_file($file_tmp, '../file/'.$nama_pelajaran_baru);
					header("location: ../guru/pelajaran.php?id-jenis-pelajaran=$id_jenis_pelajaran&&id-kelas=$id_kelas&&id-mata-pelajaran=$id_mata_pelajaran ");
				} else {
					echo "nama file terlalu panjang";
				}
			}

		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="pelajaran.php?
		id-jenis-pelajaran=<?php echo $id_jenis_pelajaran; ?>&&
		id-kelas=<?php echo $id_kelas; ?>&&
		id-mata-pelajaran=<?php echo $id_mata_pelajaran; ?>
	">kembali</a> | <br>

	<h2><?php echo "unggah " . $data_jenis_pelajaran['nama_jenis_pelajaran'] . " " . $data_mata_pelajaran['nama_mata_pelajaran'] . " kelas " . $data_kelas["nama_kelas"]; ?></h2>

	<form method="post" enctype="multipart/form-data">

		<!-- <input type="text" name="pelajaran"> -->

		<input type="file" name="pelajaran">

		<button type="submit" name="unggah">unggah</button>
		
	</form>
	
</body>
</html>