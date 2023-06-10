<?php
//done
include "../connection.php";
// Periksa apakah ID jadwal telah dipilih
if (isset($_GET["id"])) {
  // Deklarasikan ID jadwal yang akan dihapus
  $id_jadwal = $_GET["id"];

  // Membuat prepared statement untuk menjalankan stored procedure hapus_data_jadwal_shift
  $stmt = $conn->prepare("CALL hapus_jadwal_shift(?)");
  $stmt->bind_param("i", $id_jadwal);

  // Menjalankan prepared statement
  if ($stmt->execute()) {
    echo "Data jadwal shift dengan ID " . $id_jadwal . " telah dihapus.";
    header("Location: ../index.php");
    exit();
  } else {
    echo "Terjadi kesalahan saat menghapus data: " . mysqli_error($conn);
  }

  // Menutup prepared statement
  $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
