CREATE DATABASE db_jadwal;
USE db_jadwal;
CREATE TABLE shift (
  kode_shift CHAR(5) PRIMARY KEY,
  nama_shift VARCHAR(20),
  jam_mulai TIME,
  jam_selesai TIME
);
CREATE TABLE karyawan (
  id_karyawan INT AUTO_INCREMENT PRIMARY KEY,
  nama_karyawan VARCHAR(50),
  jabatan_karyawan VARCHAR(20)
);
CREATE TABLE jadwal_shift (
  id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
  kode_shift CHAR(5),
  id_karyawan INT,
  tanggal DATE,
  FOREIGN KEY (kode_shift) REFERENCES shift(kode_shift),
  FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan)
);

CREATE TABLE karyawan_old (
  id_karyawan_old INT AUTO_INCREMENT,
  nama_karyawan_old VARCHAR(50),
  jabatan_karyawan_old VARCHAR(20),
  tanggal_keluar DATE,
  PRIMARY KEY (id_karyawan_old)
);

INSERT INTO shift (kode_shift, nama_shift, jam_mulai, jam_selesai)
VALUES ('P', 'Shift Pagi', '07:00:00', '12:00:00'),
  ('S', 'Shift Siang', '12:00:00', '17:00:00');
INSERT INTO karyawan (nama_karyawan, jabatan_karyawan)
VALUES ('Andi', 'Kasir'),
  ('Budi', 'Security'),
  ('Farhan', 'Security'),
  ('Citra', 'Kasir');
INSERT INTO jadwal_shift (kode_shift, id_karyawan, tanggal)
VALUES ('P', 1, '2023-05-08'),
  ('S', 2, '2023-05-08'),
  ('P', 3, '2023-05-08'),
  ('S', 4, '2023-05-08');