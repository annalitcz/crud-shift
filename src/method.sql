-- Stored Procedure edit data shift :
DELIMITER //

CREATE PROCEDURE edit_data_shift(p_kode_shift CHAR(5), p_nama_shift VARCHAR(20), p_jam_mulai TIME, p_jam_selesai TIME)
BEGIN
  UPDATE shift
  SET nama_shift = p_nama_shift, jam_mulai = p_jam_mulai, jam_selesai = p_jam_selesai
  WHERE kode_shift = p_kode_shift;
END //

DELIMITER ;

-- Stored Procedure edit jadwal shift :
DELIMITER //

CREATE PROCEDURE update_jadwal_shift(p_id_jadwal INT, p_kode_shift CHAR(5), p_id_karyawan INT, p_tanggal DATE)
BEGIN
  UPDATE jadwal_shift
  SET kode_shift = p_kode_shift, id_karyawan = p_id_karyawan, tanggal = p_tanggal
  WHERE id_jadwal = p_id_jadwal;
END //

DELIMITER ;

-- Stored Procedure edit karyawan :
DELIMITER //

CREATE PROCEDURE edit_karyawan(p_id_karyawan INT, p_nama_karyawan VARCHAR(20), p_jabatan_karyawan VARCHAR(20))
BEGIN
  UPDATE karyawan
  SET nama_karyawan = p_nama_karyawan, jabatan_karyawan = p_jabatan_karyawan
  WHERE id_karyawan = p_id_karyawan;
END //

DELIMITER ;

-- Stored Procedure hapus data shift :
DELIMITER //

CREATE PROCEDURE hapus_data_shift(p_kode_shift CHAR(5))
BEGIN
  DELETE FROM shift WHERE kode_shift = p_kode_shift;
END //

DELIMITER ;

-- Stored Procedure hapus jadwal shift :
DELIMITER //

CREATE PROCEDURE hapus_jadwal_shift(p_id_jadwal INT)
BEGIN
  DELETE FROM jadwal_shift WHERE id_jadwal = p_id_jadwal;
END //

DELIMITER ;

-- Stored Procedure hapus karyawan :
DELIMITER //

CREATE PROCEDURE hapus_karyawan(p_id_karyawan INT)
BEGIN
  DELETE FROM karyawan WHERE id_karyawan = p_id_karyawan;
END //

DELIMITER ;

-- Stored Procedure tambah data karyawan :
DELIMITER //

CREATE PROCEDURE tambah_data_karyawan(p_nama_karyawan VARCHAR(20), p_jabatan_karyawan VARCHAR(20))
BEGIN
  INSERT INTO karyawan (nama_karyawan, jabatan_karyawan)
  VALUES (p_nama_karyawan, p_jabatan_karyawan);
END //

DELIMITER ;

-- Stored Procedure tambah data shift :
DELIMITER //

CREATE PROCEDURE tambah_data_shift(p_kode_shift CHAR(5), p_nama_shift VARCHAR(20), p_jam_mulai TIME, p_jam_selesai TIME)
BEGIN
  INSERT INTO shift (kode_shift, nama_shift, jam_mulai, jam_selesai)
  VALUES (p_kode_shift, p_nama_shift, p_jam_mulai, p_jam_selesai);
END //

DELIMITER ;

-- Stored Procedure tambah jadwal shift :
DELIMITER //

CREATE PROCEDURE insert_jadwal_shift(p_kode_shift CHAR(5), p_id_karyawan INT, p_tanggal DATE)
BEGIN
  INSERT INTO jadwal_shift (kode_shift, id_karyawan, tanggal)
  VALUES (p_kode_shift, p_id_karyawan, p_tanggal);
END //

DELIMITER ;

-- VIEW shift pagi :
CREATE VIEW v_shift_pagi AS
SELECT k.nama_karyawan AS nama_karyawan, js.tanggal AS tanggal, s.nama_shift AS nama_shift, s.jam_mulai AS jam_mulai, s.jam_selesai AS jam_selesai
FROM db_jadwal.karyawan k
JOIN db_jadwal.jadwal_shift js ON k.id_karyawan = js.id_karyawan
JOIN db_jadwal.shift s ON js.kode_shift = s.kode_shift
WHERE s.jam_mulai >= '07:00:00' AND s.jam_selesai <= '12:00:00';

-- VIEW  shift siang :
CREATE VIEW v_shift_siang AS
SELECT k.nama_karyawan AS nama_karyawan, js.tanggal AS tanggal, s.nama_shift AS nama_shift, s.jam_mulai AS jam_mulai, s.jam_selesai AS jam_selesai
FROM db_jadwal.karyawan k
JOIN db_jadwal.jadwal_shift js ON k.id_karyawan = js.id_karyawan
JOIN db_jadwal.shift s ON js.kode_shift = s.kode_shift
WHERE s.jam_mulai >= '12:00:00' AND s.jam_selesai <= '17:00:00';


-- Stored Function

-- Built In Function jumlah karyawan:
SELECT s.nama_shift AS "Nama Shift", COUNT(js.id_karyawan) AS "Jumlah Karyawan"
FROM shift s
LEFT JOIN jadwal_shift js ON s.kode_shift = js.kode_shift
GROUP BY s.kode_shift
UNION ALL
SELECT 'Total' AS "Nama Shift", COUNT(js.id_karyawan) AS "Jumlah Karyawan"
FROM jadwal_shift js;

-- Trigger insert old karyawan :
DELIMITER //

CREATE TRIGGER trg_hapus_karyawan
AFTER DELETE ON karyawan
FOR EACH ROW
BEGIN
  INSERT INTO karyawan_old (id_karyawan_old, nama_karyawan_old, jabatan_karyawan_old, tanggal_keluar)
  VALUES (OLD.id_karyawan, OLD.nama_karyawan, OLD.jabatan_karyawan, CURDATE());
END //

DELIMITER ;