<?php

session_start();

if(!$_SESSION) {
	// echo "kosong";
} else {

	if($_SESSION["login"] == true && $_SESSION["peran"] == "admin") {
		header("location: admin");
	} elseif($_SESSION["login"] == true && $_SESSION["peran"] == "guru") {
		header("location: guru");
	} elseif($_SESSION["login"] == true && $_SESSION["peran"] == "siswa") {
		header("location: siswa");
	}

}

require "koneksi-database.php";

$pesan_kesalahan = "";

if(isset($_POST["masuk"])) {
	
	$nama_pengguna = $_POST["nama_pengguna"];
	$kata_sandi = $_POST["kata_sandi"];

	$nama_pengguna = explode(".", $nama_pengguna);

	$id_sekolah = $nama_pengguna[0];
	
	$id_pengguna = $nama_pengguna[1];

	if($id_pengguna == NULL) {
		$pesan_kesalahan = "nama pengguna yang anda masukkan salah";
	}

	$cek_id_sekolah = mysqli_query($koneksi_database, "SELECT * FROM sekolah WHERE id_sekolah='$id_sekolah' ");
	$data_sekolah = mysqli_fetch_assoc($cek_id_sekolah);

	if(mysqli_num_rows($cek_id_sekolah) > 0) {

		$cek_id_admin = mysqli_query($koneksi_database, "SELECT * FROM admin WHERE id_admin='$id_pengguna' ");
		
		$cek_id_guru = mysqli_query($koneksi_database, "SELECT * FROM guru WHERE id_guru='$id_pengguna' ");

		$cek_id_siswa = mysqli_query($koneksi_database, "SELECT * FROM siswa WHERE id_siswa='$id_pengguna' ");
		
		if(mysqli_num_rows($cek_id_admin) > 0) {

			$data_admin = mysqli_fetch_assoc($cek_id_admin);

			if($kata_sandi == $data_admin["kata_sandi"]) {

				$_SESSION["login"] = true;
				$_SESSION["id_sekolah"] = $data_sekolah["id"];
				$_SESSION["peran"] = "admin";
				$_SESSION["id_admin"] = $data_admin["id_admin"];

				header("location: admin");

			} else {

				$pesan_kesalahan = "kata sandi yang anda masukkan salah";

			}

		} elseif(mysqli_num_rows($cek_id_guru) > 0) {

			$data_guru = mysqli_fetch_assoc($cek_id_guru);

			if($kata_sandi == $data_guru["kata_sandi"]) {

				$_SESSION["login"] = true;
				$_SESSION["id_sekolah"] = $data_sekolah["id"];
				$_SESSION["peran"] = "guru";
				$_SESSION["id_guru"] = $data_guru["id_guru"];

				header("location: guru");

			} else {

				$pesan_kesalahan = "kata sandi yang anda masukkan salah";

			}

		} elseif(mysqli_num_rows($cek_id_siswa) >0) {

			$data_siswa = mysqli_fetch_assoc($cek_id_siswa);

			if($kata_sandi == $data_siswa["kata_sandi"]) {

				$_SESSION["login"] = true;
				$_SESSION["id_sekolah"] = $data_sekolah["id"];
				$_SESSION["peran"] = "siswa";
				$_SESSION["id_siswa"] = $data_siswa["id_siswa"];

				header("location: siswa");

			} else {

				$pesan_kesalahan = "kata sandi yang anda masukkan salah";

			}

		} else {

			$pesan_kesalahan = "id pengguna yang anda masukkan salah";

		}

	} else {

			$pesan_kesalahan = "id sekolah yang anda masukkan salah";

	}

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
	  <link rel="shortcut icon" href="../assets/img/logo.png" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>skuylah-core</title>
	<link rel="stylesheet" href="../assets/css/login.css">
  </head>
  <body>
    <div class="center">
      <h1>Login</h1>
      <p><?php echo $pesan_kesalahan; ?></p>
      <form method="post">
        <div class="txt_field">
          <input type="text" name="nama_pengguna"  autocomplete="off" required />
          <span></span>
          <label>Nama Pengguna</label>
        </div>
        <div class="txt_field">
          <input type="password"  name="kata_sandi"  required />
          <span></span>
          <label>Password</label>
        </div>
        <input type="submit"  name="masuk" value="Login" />
        <div class="signup_link"><a href="https://wa.link/n6fzwc">Lupa Password ?</a></div>
      </form>
    </div>
  </body>
</html>