<?php
//done
include "../connection.php";

//mengecek koneksi
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//mengambil data dari form tambah karyawan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_karyawan = $_POST["nama_karyawan"];
  $jabatan_karyawan = $_POST["jabatan_karyawan"];

  //memanggil stored procedure tambah_data_karyawan
  $sql = "CALL tambah_data_karyawan('$nama_karyawan', '$jabatan_karyawan')";

  if (mysqli_query($conn, $sql)) {
    echo "Data karyawan berhasil ditambahkan<br>";
    echo "<a href='../index.php'>Back</a>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
//menutup koneksi database
mysqli_close($conn);
?>

<!-- Form tambah karyawan -->
<h2>Tambah Data Karyawan</h2>
<form method="POST" action="">
  <label for="nama_karyawan">Nama Karyawan:</label>
  <input type="text" name="nama_karyawan" required><br>

  <label for="jabatan_karyawan">Jabatan Karyawan:</label>
  <input type="text" name="jabatan_karyawan" required><br>

  <input type="submit" value="Tambah">
</form>
