<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Shift</title>
    <link rel="stylesheet" href="./index.css"/>
</head>
<body>
    <h3>&copy; Anzz App</h3>
    <div class="flex">
        <form method="post" action="">
            <select name="tabel">
                <option selected>Pilih</option>
                <option value="shift">Shift</option>
                <option value="karyawan">Karyawan</option>
                <option value="jadwal_shift">Jadwal Shift</option>
                <option value="info_jml_karyawan">Jumlah Karyawan Per-shift</option>
                <option value="resign">Karyawan Old</option>
                <option value="jadwal_pagi">Shift pagi</option>
                <option value="jadwal_siang">Shift siang</option>
            </select>
            <input type="text" name="search" class="search-input" placeholder="Cari...">
            <button type="submit">Tampilkan Data</button>
        </form>
        <button id="infoButton">Tutorial Pencarian</button>
    </div>
    <div class="info-div">
        <p>1. tabel shift : pilih tabel shift + masukkan nama shift <br>
            2. tabel karyawan : pilih tabel karyawan + masukkan nama karwayan <br>
            3. tabel jadwal shift : pilih tabel jadwal shift + masukkan tanggal dengan formart 2023-05-08</p>
    </div>

    <script>
        var infoButton = document.getElementById('infoButton');
        var infoDiv = document.querySelector('.info-div');

        infoButton.addEventListener('click', function() {
            if (infoDiv.style.display === 'none') {
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        });
        window.addEventListener('DOMContentLoaded', function() {
            infoDiv.style.display = 'none';
        });
    </script>

    <?php
    include "./connection.php"; //import file connection.php untuk menggunakan variabel $conn

    // Cek koneksi
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") { //Jika metode permintaan adalah "POST", maka blok kode di bawahnya akan dieksekusi.
        $tabel = $_POST["tabel"]; //variabel untuk menyimpan nilai tabel yang dipilih melalui option yang tersedia
        $search = $_POST["search"]; //variabel untuk menyimpan 

        switch ($tabel) { //logika untuk menampilkan tabel sesuai yang dipilih
            case "shift": //memeriksa apakah nilai yang dievaluasi sama dengan "shift"
                $sql = "SELECT * FROM shift WHERE nama_shift LIKE '%$search%'";
                $result = mysqli_query($conn, $sql); //eksekusi query

                if (mysqli_num_rows($result) > 0) { //memeriksa apakah ada hasil (baris) yang dikembalikan oleh query. Jika ada hasil, blok kode di dalam kurung kurawal pertama akan dieksekusi.

                    // output data dari setiap baris
                    echo "<h3 class='txt-center'>Shift</h3>";
                    echo "<div class='box-db'>";
                    echo "<table border='1'";
                    echo "<tr>
                        <th>Kode shift</th>
                        <th>Nama shift</th>
                        <th>Jam mulai</th>
                        <th>Jam selesai</th>
                        <th>Aksi</th>
                      </tr>";
                    while ($row = mysqli_fetch_assoc($result)) { //mengambil setiap baris hasil query
                        echo "<tr>
                            <td>" . $row["kode_shift"] . "</td>
                            <td>" . $row["nama_shift"] . "</td>
                            <td>" . $row["jam_mulai"] . "</td>
                            <td>" . $row["jam_selesai"] . "</td>";
                        echo "  <td>
                                <a href='./method/editShift.php?kode=" . $row["kode_shift"] . "'>Edit</a> |
                                <a href='./method/hapusShift.php?kode=" . $row["kode_shift"] . "' onclick='return confirm(\"Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>
                          </tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "0 results";
                }
                echo "<br><a href='./method/tambahShift.php'>Tambah</a>";
                break; //mengakhiri blok case "shift" dalam switch statement.

            case "karyawan":
                $sql = "SELECT * FROM karyawan WHERE nama_karyawan LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);

                $sql_total = "SELECT hitung_total_karyawan() AS 'total'";
                $resultTotal = $conn->query($sql_total);
                $rowTotal = $resultTotal->fetch_assoc();

                if (mysqli_num_rows($result) > 0) { ?>
                    <h3 class="txt-center">Karyawan</h3>
                    <div class="box-db">
                        <table border='1'>
                            <thead>
                                <tr>
                                    <th>ID karyawan</th>
                                    <th>Nama karyawan</th>
                                    <th>Jabatan karyawan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row["id_karyawan"]; ?></td>
                                        <td><?php echo $row["nama_karyawan"]; ?></td>
                                        <td><?php echo $row["jabatan_karyawan"]; ?></td>
                                        <td>
                                            <a href='./method/editKaryawan.php?id=<?php echo $row["id_karyawan"]; ?>'>Edit</a> |
                                            <a href='./method/hapusKaryawan.php?id=<?php echo $row["id_karyawan"]; ?>' onclick='return confirm("Anda yakin ingin menghapus data ini?")'>Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='3'>Total Karyawan</td>
                                    <td><?php echo $rowTotal['total'] ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php
                } else {
                    echo "0 results";
                }
                echo "<br><a href='./method/tambahKaryawan.php'>Tambah</a>";
                break;

            case "jadwal_shift":
                $sql = "SELECT jadwal_shift.id_jadwal, shift.nama_shift, karyawan.nama_karyawan, jadwal_shift.tanggal
                    FROM jadwal_shift
                    JOIN shift ON jadwal_shift.kode_shift = shift.kode_shift
                    JOIN karyawan ON jadwal_shift.id_karyawan = karyawan.id_karyawan
                    WHERE jadwal_shift.tanggal LIKE '%$search%' 
                    ORDER BY jadwal_shift.id_jadwal ASC";
                $result = mysqli_query($conn, $sql);

                // Query untuk menghitung total jumlah jadwal shift
                $sql_total = "SELECT hitung_total_jadwal() AS total_jadwal_shift";
                $result_total = mysqli_query($conn, $sql_total);
                $row_total = $result_total->fetch_assoc();
                if (mysqli_num_rows($result) > 0) { ?>
                    <h3 class="txt-center">Jadwal Shift</h3>
                    <div class='box-db'>
                        <table border='1'>
                            <thead>
                                <tr>
                                    <th>ID jadwal</th>
                                    <th>Nama shift</th>
                                    <th>Nama karyawan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?> 
                                    <tr>
                                        <td><?php echo $row["id_jadwal"]; ?></td>
                                        <td><?php echo $row["nama_shift"]; ?></td>
                                        <td><?php echo $row["nama_karyawan"]; ?></td>
                                        <td><?php echo $row["tanggal"]; ?></td>
                                        <td>
                                            <a href='./method/editJadwal.php?id=<?php echo $row["id_jadwal"]; ?>'>Edit</a> |
                                            <a href='./method/hapusJadwal.php?id=<?php echo $row["id_jadwal"]; ?>' onclick='return confirm("Anda yakin ingin menghapus data ini?")'>Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">Total Jadwal Shift</td>
                                    <td><?php echo $row_total['total_jadwal_shift']; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php
                } else {
                    echo "0 results";
                }
                echo "<br><a href='./method/tambahJadwal.php'>Tambah</a>";
                break;
            case "info_jml_karyawan":
                $sqlShift = "SELECT s.nama_shift AS 'Nama Shift', COUNT(js.id_karyawan) AS 'Jumlah Karyawan'
                             FROM shift s
                             LEFT JOIN jadwal_shift js ON s.kode_shift = js.kode_shift
                             GROUP BY s.kode_shift";
                $resultShift = $conn->query($sqlShift);

                // Mengambil total jumlah karyawan
                $sqlTotal = "SELECT COUNT(*) AS 'Jumlah Karyawan' FROM jadwal_shift";
                $resultTotal = $conn->query($sqlTotal);
                $rowTotal = $resultTotal->fetch_assoc(); //mengambil baris pertama dari hasil query sebagai array asosiatif.
                if ($resultShift->num_rows > 0) { ?>
                    <h3>Jumlah Karyawan per-shift</h3>
                    <?php echo "<table border='1'>
                            <thead>
                                <tr>
                                    <th>Nama Shift</th>
                                    <th>Jumlah Karyawan</th>
                                </tr>
                            </thead>
                            <tbody>";
                    // Menampilkan data shift dan jumlah karyawan
                    while ($row = $resultShift->fetch_assoc()) { //loop while yang akan terus berjalan selama ada baris (rekaman) dalam hasil query dari tabel "shift" yang disimpan dalam variabel $resultShift
                        echo "<tr>
                                <td>" . $row['Nama Shift'] . "</td>
                                <td>" . $row['Jumlah Karyawan'] . "</td>
                            </tr>";
                    }
                    echo "</tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>" . $rowTotal['Jumlah Karyawan'] . "</td>
                            </tr>
                        </tfoot>
                    </table>";
                } else {
                    echo "Tidak ada data yang ditemukan.";
                }
                break;
            case "resign":
                $sql = "SELECT * FROM karyawan_old WHERE nama_karyawan_old LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    ?>
                    <h3 class="txt-center">Karyawan Old</h3>
                    <div class="box-db">
                        <?php
                        echo "<table border='1'>";
                        echo "<thead>
                                <tr>
                                    <th>ID karyawan</th>
                                    <th>Nama karyawan</th>
                                    <th>Jabatan karyawan</th>
                                    <th>Tanggal Resign</th>
                                </tr>
                            </thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row["id_karyawan_old"] . "</td>
                                    <td>" . $row["nama_karyawan_old"] . "</td>
                                    <td>" . $row["jabatan_karyawan_old"] . "</td>
                                    <td>" . $row["tanggal_keluar"] . "</td>
                                </tr>";
                        }
                        echo "</tbody>";
                        echo "<tfoot>
                                <tr>
                                    <td colspan='3'>Total Karyawan Resign</td>
                                    <td>";
                        $query_total_resign = "SELECT hitung_total_karyawan_keluar() AS total_resign";
                        $result_total_resign = mysqli_query($conn, $query_total_resign);
                        $row_total_resign = mysqli_fetch_assoc($result_total_resign);
                        echo $row_total_resign["total_resign"];
                        echo "</td>
                                </tr>
                              </tfoot>";
                        echo "</table>";
                        ?>
                    </div>
                <?php
                } else {
                    echo "0 results";
                }
                break;
            case "jadwal_pagi":
                $sql = "SELECT * FROM v_shift_pagi";

                $result = mysqli_query($conn, $sql); ?>
                <h3 class="txt-center">Jadwal Pagi</h3>
                <div class="box-db">
                    <?php
                    echo "<table border='1'>";
                    echo "<tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                  </tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['nama_karyawan'] . "</td>";
                        echo "<td>" . $row['tanggal'] . "</td>";
                        echo "<td>" . $row['nama_shift'] . "</td>";
                        echo "<td>" . $row['jam_mulai'] . "</td>";
                        echo "<td>" . $row['jam_selesai'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>"; ?>
                </div>
            <?php
                break;
            case "jadwal_siang":
                $sql = "SELECT * FROM v_shift_siang";
                $result = mysqli_query($conn, $sql);
            ?>
                <h3 class="txt-center">Jadwal Siang</h3>
                <div class="box-db">
                    <?php
                    echo "<table border='1'>";
                    echo "<tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                  </tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['nama_karyawan'] . "</td>";
                        echo "<td>" . $row['tanggal'] . "</td>";
                        echo "<td>" . $row['nama_shift'] . "</td>";
                        echo "<td>" . $row['jam_mulai'] . "</td>";
                        echo "<td>" . $row['jam_selesai'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>"; ?>
                </div>
    <?php
                break;
            default:
                echo "<h3>Tidak ada tabel yang terpilih, silahkan pilih tabel pada menu dropdown.</h3>";
        }
        mysqli_close($conn);
    }

    ?>
</body>
</html>