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

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas WHERE NOT EXISTS (SELECT id_kelas FROM guru WHERE kelas.id_kelas = guru.id_kelas) ");

if(!$ambil_data_kelas) {
	$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas");
}

if(isset($_POST["tambah"])) {
	// var_dump($_POST); die();
	
	$ambil_data_guru = mysqli_query($koneksi_database, "SELECT id_guru FROM guru ORDER BY id DESC LIMIT 1");

	if(mysqli_num_rows($ambil_data_guru) < 1) {

		$id_guru = "G0001";

	} else {

		$data_guru = mysqli_fetch_assoc($ambil_data_guru);
		
		$id_guru = $data_guru["id_guru"];
		$id_guru = substr($id_guru, 1,5);
		$id_guru = $id_guru + 1;

		if(strlen($id_guru) == 1) {

			$id_guru = "G000" . $id_guru;

		} elseif(strlen($id_guru) == 2) {

			$id_guru = "G00" . $id_guru;

		} elseif(strlen($id_guru) == 3) {

			$id_guru = "G0" . $id_guru;

		} elseif(strlen($id_guru) == 4) {

			$id_guru = "G" . $id_guru;

		}
	}

	$nama_guru = $_POST["nama_guru"];
	$kelas = $_POST["kelas"];

	// var_dump($id_guru, $nama_guru, $kelas); die();

	$tambah_guru = mysqli_query($koneksi_database, "INSERT INTO guru(id_guru, nama_guru, id_kelas) VALUES('$id_guru' ,'$nama_guru', '$kelas') ");

	if($tambah_guru) {
		header("location: ../admin/daftar-guru.php");
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-guru.php">kembali</a>

	<form method="post">

		<input type="text" name="nama_guru" placeholder="nama guru">

		<select name="kelas">
			<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
				<option value="<?php echo $data_kelas["id_kelas"] ?>"><?php echo $data_kelas["nama_kelas"]; ?></option>
			<?php endwhile; ?>
		</select>

		<button type="submit" name="tambah">tambah</button>
		
	</form>
	
</body>
</html>