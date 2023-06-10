<?php
//done
include "../connection.php";

if(isset($_GET["kode"])) {
    $kode_shift = $_GET["kode"];

    //memanggil stored procedure hapus_shift
    $sql = "CALL hapus_data_shift('$kode_shift')";
    if(mysqli_query($conn, $sql)) {
        echo "Data shift berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: ../index.php"); //redirect ke halaman shift setelah menghapus data
}
?>
