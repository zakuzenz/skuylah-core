<?php  

$data = $_GET["data"];
$id_data = $_GET["id-data"];

// var_dump($data == "kelas");

if($data == "kelas") {

	$nama_tabel = "kelas";
	$id = "id_kelas";
	$alamat_kembali = "daftar-kelas.php";

} elseif($data == "guru") {

	$nama_tabel = "guru";
	$id = "id";
	$alamat_kembali = "daftar-guru.php";

} elseif($data == "siswa") {

	$nama_tabel = "siswa";
	$id = "id";
	$alamat_kembali = "daftar-siswa.php";

} elseif($data == "jadwal") {

	$nama_tabel = "jadwal";
	$id = "id_jadwal";
	$alamat_kembali = "daftar-jadwal.php";

}

// echo $nama_tabel . " " . $id . " " . $alamat_kembali;

require "../koneksi-database.php";

$perintah_hapus = mysqli_query($koneksi_database, "DELETE FROM $nama_tabel WHERE $id='$id_data' ");
// var_dump($perintah_hapus); die();

if($perintah_hapus) {
	header("location: ../admin/$alamat_kembali");
}

?>