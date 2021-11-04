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

$id_pelajaran = $_GET["id"];
$id_jenis_pelajaran = $_GET["id-jenis-pelajaran"];
$id_kelas = $_GET["id-kelas"];
$id_mata_pelajaran = $_GET["id-mata-pelajaran"];

require "../koneksi-database.php";
$ambil_data_pelajaran = mysqli_query($koneksi_database, "SELECT pelajaran FROM pelajaran WHERE id_pelajaran = '$id_pelajaran' ");
$data_pelajaran = mysqli_fetch_assoc($ambil_data_pelajaran);

unlink($data_pelajaran["pelajaran"]);

$kueri_hapus_pelajaran = mysqli_query($koneksi_database, "DELETE FROM pelajaran WHERE id_pelajaran='$id_pelajaran' ");

if($kueri_hapus_pelajaran) {


	header("location: ../guru/pelajaran.php?id-jenis-pelajaran=$id_jenis_pelajaran&&id-kelas=$id_kelas&&id-mata-pelajaran=$id_mata_pelajaran");
} else {
	die(mysqli_error($koneksi_database));
}

?>