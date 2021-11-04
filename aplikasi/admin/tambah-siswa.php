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

$ambil_data_kelas = mysqli_query($koneksi_database, "SELECT * FROM kelas ");

if(isset($_POST["tambah"])) {
	// var_dump($_POST); die();
	
	$ambil_data_siswa = mysqli_query($koneksi_database, "SELECT id_siswa FROM siswa ORDER BY id DESC LIMIT 1");

	if(mysqli_num_rows($ambil_data_siswa) < 1) {

		$id_siswa = "S0001";

	} else {

		$data_siswa = mysqli_fetch_assoc($ambil_data_siswa);
		
		$id_siswa = $data_siswa["id_siswa"];
		$id_siswa = substr($id_siswa, 1,5);
		$id_siswa = $id_siswa + 1;

		if(strlen($id_siswa) == 1) {

			$id_siswa = "S000" . $id_siswa;

		} elseif(strlen($id_siswa) == 2) {

			$id_siswa = "S00" . $id_siswa;

		} elseif(strlen($id_siswa) == 3) {

			$id_siswa = "S0" . $id_siswa;

		} elseif(strlen($id_siswa) == 4) {

			$id_siswa = "S" . $id_siswa;

		}
	}

	$id_sekolah = $_SESSION["id_sekolah"];
	$nama_siswa = $_POST["nama_siswa"];

	$id_kelas = $_POST["id_kelas"];
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$tanggal_lahir = $_POST["tanggal_lahir"];
	$no_whatsapp = $_POST["no_whatsapp"];
	$nama_ayah = $_POST["nama_ayah"];
	$nama_ibu = $_POST["nama_ibu"];
	$alamat = $_POST["alamat"];

	// var_dump($id_siswa, $nama_siswa, $kelas); die();

	$tambah_siswa = mysqli_query($koneksi_database, "INSERT INTO siswa(id_sekolah, id_siswa, nama_siswa, id_kelas, jenis_kelamin, tanggal_lahir, no_whatsapp, nama_ayah, nama_ibu, alamat) VALUES('$id_sekolah', '$id_siswa' ,'$nama_siswa','$id_kelas','$jenis_kelamin','$tanggal_lahir','$no_whatsapp','$nama_ayah','$nama_ibu','$alamat') ");

	if($tambah_siswa) {
		header("location: ../admin/daftar-siswa.php");
	} else {
		die(mysqli_error($koneksi_database));
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<?php require "../template/head.html"; ?>
<body>

	<a href="../admin/daftar-siswa.php">kembali</a>

	<form method="post">

		<input type="text" name="nama_siswa" placeholder="nama siswa">

		<select name="id_kelas">
			<?php while($data_kelas = mysqli_fetch_assoc($ambil_data_kelas)) : ?>
				<option value="<?php echo $data_kelas["id_kelas"]; ?>"><?php echo $data_kelas["nama_kelas"]; ?></option>
			<?php endwhile; ?>
		</select>

		<input type="radio" id="laki-laki" name="jenis_kelamin" value="laki-laki">
		<label for="laki-laki">laki-laki</label>
		<input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan">
		<label for="perempuan">perempuan</label>

		<input type="date" name="tanggal_lahir">

		<input type="text" name="no_whatsapp" placeholder="no whatsapp">

		<input type="text" name="nama_ayah" placeholder="nama ayah">

		<input type="text" name="nama_ibu" placeholder="nama ibu">

		<textarea name="alamat" cols="30" rows=3 placeholder="alamat"></textarea>

		<button type="submit" name="tambah">tambah</button>
		
	</form>
	
</body>
</html>