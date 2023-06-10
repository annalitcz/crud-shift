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
--VIEW tanpa params
CREATE VIEW V_jadwal AS
SELECT j.id_jadwal,
  s.nama_shift,
  k.nama_karyawan,
  j.tanggal
FROM jadwal_shift j
  JOIN shift s ON j.kode_shift = s.kode_shift
  JOIN karyawan k ON j.id_karyawan = k.id_karyawan;
SELECT *
FROM V_jadwal;
--SP tampil data tanpa params
DELIMITER $$ CREATE PROCEDURE show_jadwal_shift() BEGIN
SELECT *
FROM jadwal_shift;
END $$ DELIMITER;
CALL show_jadwal_shift();
-- SP tampil data dengan params
DELIMITER $$ CREATE PROCEDURE show_shift_detail(IN shift_code CHAR(10)) BEGIN
SELECT k.nama_karyawan AS "Nama",
  k.jabatan_karyawan AS "Jabatan",
  s.nama_shift AS "Shift",
  s.jam_mulai AS "Mulai",
  s.jam_selesai AS "Selesai"
FROM karyawan k
  INNER JOIN jadwal_shift js ON k.id_karyawan = js.id_karyawan
  INNER JOIN shift s ON js.kode_shift = s.kode_shift
WHERE s.kode_shift = shift_code;
END $$ DELIMITER;
CALL show_shift_detail('P');
-- SP tambah data jadwal
DELIMITER / / CREATE PROCEDURE add_jadwal_shift(
  IN id_jadwal INT,
  IN k_shift CHAR(10),
  IN id_karyawan INT,
  IN tanggal DATE
) BEGIN
INSERT INTO jadwal_shift (id_jadwal, k_shift, id_karyawan, tanggal)
VALUES (id_jadwal, k_shift, id_karyawan, tanggal);
END / / DELIMITER;
CALL add_jadwal_shift(5, 'P', 1, '2023-05-09');
-- SP tambah karyawan
DELIMITER / / CREATE PROCEDURE add_karyawan(
  IN nama_karyawan VARCHAR(50),
  IN jabatan_karyawan VARCHAR(50)
) BEGIN
INSERT INTO karyawan (nama_karyawan, jabatan_karyawan)
VALUES (nama_karyawan, jabatan_karyawan);
END / / DELIMITER;
-- SP hapus karyawan (err)
DELIMITER / / CREATE PROCEDURE delete_karyawan(IN id_karyawan INT) BEGIN
DELETE FROM karyawan
WHERE id_karyawan = id_karyawan;
END / / DELIMITER;
CALL delete_karyawan(5);
--SP hapus data jadwal (err)
DELIMITER / / CREATE PROCEDURE delete_jadwal(IN id_jadwal INT) BEGIN
DELETE FROM jadwal_shift
WHERE id_jadwal = id_jadwal;
END / / DELIMITER;
CALL delete_jadwal(3)