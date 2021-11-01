CREATE TABLE sekolah(
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sekolah VARCHAR(255) NOT NULL,
  nama_sekolah VARCHAR(255) NOT NULL
);

INSERT INTO sekolah(id_sekolah, nama_sekolah) VALUES("SMK0001","SMK MUTU WONOSOBO");

CREATE TABLE admin(
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sekolah INT NOT NULL,
  id_admin VARCHAR(255) NOT NULL,
  nama_admin VARCHAR(255) NOT NULL,
  kata_sandi VARCHAR(255) NOT NULL,
  
  CONSTRAINT fk_sekolah_admin FOREIGN KEY (id_sekolah) REFERENCES sekolah (id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO admin(id_sekolah, id_admin, nama_admin, kata_sandi) VALUES(1,"A0001","ADMIN","123");

CREATE TABLE kelas(
  id_kelas INT AUTO_INCREMENT PRIMARY KEY,
  id_sekolah INT NOT NULL,
  nama_kelas VARCHAR(255) NOT NULL,
  
  CONSTRAINT fk_sekolah_kelas FOREIGN KEY (id_sekolah) REFERENCES sekolah (id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO kelas(id_sekolah, nama_kelas) VALUES(1,"10 RPL"),(1,"10 AKL");

CREATE TABLE guru(
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sekolah INT NOT NULL,
  id_guru VARCHAR(255) NOT NULL,
  nama_guru VARCHAR(255) NOT NULL,
  kata_sandi VARCHAR(255) NOT NULL DEFAULT "123",
  
  id_kelas INT,
  CONSTRAINT fk_sekolah_guru FOREIGN KEY (id_sekolah) REFERENCES sekolah (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_kelas_guru FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO guru(id_sekolah, id_guru, nama_guru, kata_sandi) VALUES
  (1, "G0001", "GURU 1", "123"),
  (1, "G0002", "GURU 2", "123");

CREATE TABLE siswa(
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sekolah INT NOT NULL,
  id_siswa VARCHAR(255) NOT NULL,
  nama_siswa VARCHAR(255) NOT NULL,
  kata_sandi VARCHAR(255) NOT NULL DEFAULT "123",
  
  id_kelas INT NOT NULL,
  CONSTRAINT fk_sekolah_siswa FOREIGN KEY (id_sekolah) REFERENCES sekolah (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_kelas_siswa FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO siswa(id_sekolah, id_siswa, nama_siswa, kata_sandi, id_kelas) VALUES
  (1, "S0001", "SISWA 1", "123", 1),
  (1, "S0002", "SISWA 2", "123", 1);

CREATE TABLE hari(
  id_hari INT AUTO_INCREMENT PRIMARY KEY,
  nama_hari VARCHAR(255) NOT NULL
);

INSERT INTO hari(nama_hari) VALUES("senin"),("selasa"),("rabu"),("kamis"),("jum'at"),("sabtu");

CREATE TABLE mata_pelajaran(
  id_mata_pelajaran INT AUTO_INCREMENT PRIMARY KEY,
  nama_mata_pelajaran VARCHAR(255) NOT NULL
);

INSERT INTO mata_pelajaran(nama_mata_pelajaran) VALUES("matematika"),("fisika"),("kimia"),("bahasa");

CREATE TABLE jadwal(
  id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
  id_kelas INT NOT NULL,
  id_hari INT NOT NULL,
  id_mata_pelajaran INT NOT NULL,
  id_guru INT NOT NULL,
  waktu_mulai TIME,
  waktu_selesai TIME,
  
  CONSTRAINT fk_kelas_jadwal FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_hari_jadwal FOREIGN KEY (id_hari) REFERENCES hari(id_hari) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_mata_pelajaran_jadwal FOREIGN KEY (id_mata_pelajaran) REFERENCES mata_pelajaran(id_mata_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_guru_jadwal FOREIGN KEY (id_guru) REFERENCES guru(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO jadwal(id_kelas, id_hari, id_mata_pelajaran, id_guru, waktu_mulai, waktu_selesai) VALUES
  (1, 1, 1, 1, "070000", "160000"),
  (1, 2, 2, 2, "070000", "160000"),
  (1, 3, 3, 1, "070000", "160000"),
  (1, 4, 4, 2, "070000", "160000");

CREATE TABLE jenis_pelajaran(
  id_jenis_pelajaran INT AUTO_INCREMENT PRIMARY KEY,
  nama_jenis_pelajaran VARCHAR(255) NOT NULL
);

INSERT INTO jenis_pelajaran(nama_jenis_pelajaran) VALUES("MATERI"),("TUGAS");

CREATE TABLE pelajaran(
  id_pelajaran INT AUTO_INCREMENT PRIMARY KEY,
  tanggal DATE NOT NULL,
  id_kelas INT NOT NULL,
  id_jenis_pelajaran INT NOT NULL,
  id_mata_pelajaran INT NOT NULL,
  id_guru INT NOT NULL,
  pelajaran VARCHAR(255) NOT NULL,
  
  CONSTRAINT fk_kelas_pelajaran FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_jenis_pelajaran_pelajaran FOREIGN KEY (id_jenis_pelajaran) REFERENCES jenis_pelajaran(id_jenis_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_mata_pelajaran_pelajaran FOREIGN KEY (id_mata_pelajaran) REFERENCES mata_pelajaran(id_mata_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_guru_pelajaran FOREIGN KEY (id_guru) REFERENCES guru(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE daftar_hadir_siswa(
  id_daftar_hadir_siswa INT AUTO_INCREMENT PRIMARY KEY,
  tanggal DATE NOT NULL,
  waktu TIME,
  id_kelas INT NOT NULL,
  id_pelajaran INT NOT NULL,
  id_jenis_pelajaran INT NOT NULL,
  id_siswa INT NOT NULL,
  
  CONSTRAINT fk_kelas_daftar_hadir_siswa FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_pelajaran_daftar_hadir_siswa FOREIGN KEY (id_pelajaran) REFERENCES pelajaran(id_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_jenis_pelajaran_daftar_hadir_siswa FOREIGN KEY (id_jenis_pelajaran) REFERENCES jenis_pelajaran(id_jenis_pelajaran) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_siswa_daftar_hadir_siswa FOREIGN KEY (id_siswa) REFERENCES siswa(id) ON DELETE CASCADE ON UPDATE CASCADE
);