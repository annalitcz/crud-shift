<!DOCTYPE html>
<html>
<head>
	<title>Form Tambah Shift</title>
</head>
<body>
	<h2>Form Tambah Shift</h2>
	<form action="" method="post">
		<label for="kode_shift">Kode Shift:</label>
		<input type="text" name="kode_shift" required><br><br>

		<label for="nama_shift">Nama Shift:</label>
		<input type="text" name="nama_shift" required><br><br>

		<label for="jam_mulai">Jam Mulai:</label>
		<input type="time" name="jam_mulai" required><br><br>

		<label for="jam_selesai">Jam Selesai:</label>
		<input type="time" name="jam_selesai" required><br><br>

		<input type="submit" name="submit" value="Tambah Shift">
	</form>
</body>
</html>
<!--done-->
<?php
include "../connection.php";
if (isset($_POST['submit'])) {
    $kode_shift = $_POST['kode_shift'];
    $nama_shift = $_POST['nama_shift'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // panggil SP untuk menambah data ke tabel shift
    $query = "CALL tambah_data_shift('$kode_shift', '$nama_shift', '$jam_mulai', '$jam_selesai')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Tambah data gagal: " . mysqli_error($conn));
    } else {
        echo "Data berhasil ditambahkan ke tabel shift.<br>";
        echo "<a href='../index.php'>Back</a>";
    }
}
mysqli_close($conn);
?>