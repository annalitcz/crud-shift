<?php
include "../connection.php";

// proses edit jadwal shift
if (isset($_POST['submit'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $kode_shift = $_POST['kode_shift'];
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];

    $sql = "CALL edit_jadwal_shift($id_jadwal, '$kode_shift', $id_karyawan, '$tanggal')";

    if (mysqli_query($conn, $sql)) {
        header('Location: ../index.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Jadwal Shift</title>
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

  .form-container {
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
    <h2>Edit Jadwal Shift</h2>
    <form method="POST" action="" class="form-container">
        <?php
        $id_jadwal = $_GET['id']; // Mengambil ID jadwal dari parameter URL
        $sql_jadwal = "SELECT * FROM jadwal_shift WHERE id_jadwal = $id_jadwal";
        $result_jadwal = mysqli_query($conn, $sql_jadwal);
        $row_jadwal = mysqli_fetch_assoc($result_jadwal);

        // Query untuk mengambil data kode shift
        $sql_shift = "SELECT * FROM shift";
        $result_shift = mysqli_query($conn, $sql_shift);

        // Query untuk mengambil data karyawan
        $sql_karyawan = "SELECT * FROM karyawan";
        $result_karyawan = mysqli_query($conn, $sql_karyawan);
        ?>

        <input type="hidden" id="id_jadwal" name="id_jadwal" value="<?php echo $id_jadwal; ?>"><br>

        <label for="kode_shift">Kode Shift:</label>
        <select id="kode_shift" name="kode_shift">
            <?php
            while ($row_shift = mysqli_fetch_assoc($result_shift)) {
                $selected = ($row_shift['kode_shift'] == $row_jadwal['kode_shift']) ? "selected" : "";
                echo "<option value='" . $row_shift['kode_shift'] . "' $selected>" . $row_shift['kode_shift'] ." - ".$row_shift['nama_shift']. "</option>";
            }
            ?>
        </select><br>

        <label for="id_karyawan">ID Karyawan:</label>
        <select id="id_karyawan" name="id_karyawan">
            <?php
            while ($row_karyawan = mysqli_fetch_assoc($result_karyawan)) {
                $selected = ($row_karyawan['id_karyawan'] == $row_jadwal['id_karyawan']) ? "selected" : "";
                echo "<option value='" . $row_karyawan['id_karyawan'] . "' $selected>" . $row_karyawan['id_karyawan'] ." - ".$row_karyawan['nama_karyawan'] ."</option>";
            }
            ?>
        </select><br>

        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $row_jadwal['tanggal']; ?>"><br>

        <input type="submit" name="submit" value="Edit">
    </form>
</body>
</html>