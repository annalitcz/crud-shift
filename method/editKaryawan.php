<?php
//done
include "../connection.php";

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if(isset($_POST['submit'])) {
  $id_karyawan = $_POST['id_karyawan'];
  $nama_karyawan = $_POST['nama_karyawan'];
  $jabatan_karyawan = $_POST['jabatan_karyawan'];

  // Panggil stored procedure edit_data_karyawan
  $query = "CALL edit_karyawan('$id_karyawan', '$nama_karyawan', '$jabatan_karyawan')";
  mysqli_query($conn, $query);
  header('Location: ../index.php');
  echo "Data Berhasil di edit";
  echo "<a href='../index.php'>Back</a>";
}

$id_karyawan = $_GET['id'];
$sql = "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $nama_karyawan = $row['nama_karyawan'];
    $jabatan_karyawan = $row['jabatan_karyawan'];
} else {
    echo "Data tidak ditemukan.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
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
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<body>
    <h2>Edit Karyawan</h2>
    <form method="post" action="">
        <input type="hidden" name="id_karyawan" value="<?php echo $id_karyawan; ?>">
        <label for="nama_karyawan">Nama:</label><br>
        <input type="text" id="nama_karyawan" name="nama_karyawan" value="<?php echo $nama_karyawan; ?>"><br>
        <label for="jabatan_karyawan">Jabatan:</label><br>
        <input type="text" id="jabatan_karyawan" name="jabatan_karyawan" value="<?php echo $jabatan_karyawan; ?>"><br><br>
        <button type="submit" name="submit">Simpan</button>
    </form>
</body>
</html>
