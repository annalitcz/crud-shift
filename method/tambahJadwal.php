<?php
//done
include "../connection.php";

//mengecek koneksi
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//mengambil data shift dari database
$shift_query = "SELECT kode_shift, nama_shift FROM shift";
$shift_result = mysqli_query($conn, $shift_query);

//mengambil data karyawan dari database
$karyawan_query = "SELECT id_karyawan, nama_karyawan FROM karyawan";
$karyawan_result = mysqli_query($conn, $karyawan_query);

//mengambil data dari form tambah karyawan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $kode_shift = $_POST["kode_shift"];
  $id_karyawan  = $_POST["id_karyawan"];
  $tanggal = $_POST["tanggal"];

  //memanggil stored procedure tambah_data_karyawan
  $sql = "CALL tambah_jadwal_shift('$kode_shift', '$id_karyawan', '$tanggal')";

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

  select,
  input[type="date"] {
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
  <h2>Tambah Data Jadwal Shift</h2>
  <form method="POST" action="">
    <label for="kode_shift">Kode Shift:</label>
    <select name="kode_shift" required>
      <?php while ($shift_row = mysqli_fetch_assoc($shift_result)) { ?>
        <option value="<?php echo $shift_row['kode_shift']; ?>"><?php echo $shift_row['nama_shift']; ?></option>
      <?php } ?>
    </select><br>
  
    <label for="id_karyawan">ID Karyawan:</label>
    <select name="id_karyawan" required>
      <?php while ($karyawan_row = mysqli_fetch_assoc($karyawan_result)) { ?>
        <option value="<?php echo $karyawan_row['id_karyawan']; ?>"><?php echo $karyawan_row['id_karyawan']." - ".$karyawan_row['nama_karyawan']; ?></option>
      <?php } ?>
    </select><br>
  
    <label for="tanggal">Tanggal:</label>
    <input type="date" name="tanggal" required><br>
  
    <input type="submit" value="Tambah">
  </form>
</body>
</html>