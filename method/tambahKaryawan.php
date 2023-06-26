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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  h2 {
    text-align: center;
    margin-top: 20px;
  }

  form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background: #f2f2f2;
    border-radius: 5px;
  }

  label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
  }

  input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }
</style>

<body>
  <!-- Form tambah karyawan -->
  <h2>Tambah Data Karyawan</h2>
  <form method="POST" action="">
    <label for="nama_karyawan">Nama Karyawan:</label>
    <input type="text" name="nama_karyawan" required><br>
  
    <label for="jabatan_karyawan">Jabatan Karyawan:</label>
    <input type="text" name="jabatan_karyawan" required><br>
  
    <input type="submit" value="Tambah">
  </form>
</body>
</html>
