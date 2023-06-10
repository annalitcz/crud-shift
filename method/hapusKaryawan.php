<?php
//done
include "../connection.php";

// cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET["id"])) {
    $id_karyawan = $_GET["id"];

    // panggil stored procedure hapus_data_karyawan
    $query = "CALL hapus_karyawan($id_karyawan)";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Gagal menghapus data karyawan: " . mysqli_error($conn));
    }

    // redirect ke halaman karyawan setelah berhasil dihapus
    header("Location: ../index.php");
    exit();
}
?>
