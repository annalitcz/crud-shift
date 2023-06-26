<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Shift</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    h1 {
        margin-top: 50px;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }

    select {
        padding: 10px;
        margin-right: 10px;
        border-radius: 5px;
        border: none;
    }

    button {
        margin-left: 10px;
        padding: 10px;
        background-color: #0077b6;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    table {
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 30px;
        max-height: 400px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    table th,
    table td {
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #0077b6;
        color: #fff;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    a {
        text-decoration: none;
        color: #0077b6;
    }

    a:hover {
        text-decoration: underline;
    }

    .box-db {
        margin-top: 0;
        max-height: 300px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    .info-div {
        display: none;
        width: 800px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        gap: 0px;
    }

    .info-div p {
        text-align: justify;
    }

    .search-input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        width: 300px;
    }

    .search-input::placeholder {
        color: #999;
    }

    .txt-center {
        text-align: center;
        padding: 0;
        margin-top: 5;
        margin-bottom: 0;

    }

    tfoot td {
        font-weight: bold;
        color: #fff;
        background-color: #0077b6;
        padding: 8px;
        border-top: 1px solid #ddd;
    }
</style>

<body>
    <h3>Anzz App</h3>
    <form method="post" action="">
        <select name="tabel">
            <option selected>Pilih</option>
            <option value="shift">Shift</option>
            <option value="karyawan">Karyawan</option>
            <option value="jadwal_shift">Jadwal Shift</option>
            <option value="info_jml_karyawan">Jumlah Karyawan</option>
            <option value="resign">Karyawan Old</option>
            <option value="jadwal_pagi">Shift pagi</option>
            <option value="jadwal_siang">Shift siang</option>
        </select>
        <input type="text" name="search" class="search-input" placeholder="Cari...">
        <button type="submit">Tampilkan Data</button>
    </form>
    <button id="infoButton">Tutorial Pencarian</button>
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
    include "./connection.php";

    // Cek koneksi
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tabel = $_POST["tabel"];
        $search = $_POST["search"];

        switch ($tabel) {
            case "shift":
                $sql = "SELECT * FROM shift WHERE nama_shift LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
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
                    while ($row = mysqli_fetch_assoc($result)) {
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
                break;
            case "karyawan":
                $sql = "SELECT * FROM karyawan WHERE nama_karyawan LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) { ?>
                    <h3 class="txt-center">Karyawan</h3>
                    <div class="box-db">
                        <?php
                        echo "<table border='1'";
                        echo "<tr>
                        <th>ID karyawan</th>
                        <th>Nama karyawan</th>
                        <th>Jabatan karyawan</th>
                        <th>Aksi</th>
                      </tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . $row["id_karyawan"] . "</td>
                            <td>" . $row["nama_karyawan"] . "</td>
                            <td>" . $row["jabatan_karyawan"] . "</td>";
                            echo "  <td>
                              <a href='./method/editKaryawan.php?id=" . $row["id_karyawan"] . "'>Edit</a> | 
                              <a href='./method/hapusKaryawan.php?id=" . $row["id_karyawan"] . "' onclick='return confirm(\"Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>
                          </tr>";
                        }
                        echo "</table>"; ?>
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
                    WHERE jadwal_shift.tanggal LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) { ?>
                    <h3 class="txt-center">Jadwal Shift</h3>
                    <div class='box-db'>
                        <?php
                        echo "<table border='1'";
                        echo "<tr>
                        <th>ID jadwal</th>
                        <th>Nama shift</th>
                        <th>Nama karyawan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . $row["id_jadwal"] . "</td>
                            <td>" . $row["nama_shift"] . "</td>
                            <td>" . $row["nama_karyawan"] . "</td>
                            <td>" . $row["tanggal"] . "</td>";
                            echo "  <td>
                                <a href='./method/editJadwal.php?id=" . $row["id_jadwal"] . "'>Edit</a> | 
                                <a href='./method/hapusJadwal.php?id=" . $row["id_jadwal"] . "' onclick='return confirm(\"Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                            </td>
                          </tr>";
                        }
                        echo "</table>"; ?>
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
                $rowTotal = $resultTotal->fetch_assoc();
                if ($resultShift->num_rows > 0) {
                    echo "<table>
                            <thead>
                                <tr>
                                    <th>Nama Shift</th>
                                    <th>Jumlah Karyawan</th>
                                </tr>
                            </thead>
                            <tbody>";
                    // Menampilkan data shift dan jumlah karyawan
                    while ($row = $resultShift->fetch_assoc()) {
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
                if (mysqli_num_rows($result) > 0) { ?>
                    <h3 class="txt-center">Karyawan Old</h3>
                    <div class="box-db">
                        <?php
                        echo "<table border='1'";
                        echo "<tr>
                        <th>ID karyawan</th>
                        <th>Nama karyawan</th>
                        <th>Jabatan karyawan</th>
                        <th>Tanggal Resign</th>
                      </tr>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . $row["id_karyawan_old"] . "</td>
                            <td>" . $row["nama_karyawan_old"] . "</td>
                            <td>" . $row["jabatan_karyawan_old"] . "</td>
                            <td>" . $row["tanggal_keluar"] . "</td>
                          </tr>";
                        }
                        echo "</table>"; ?>
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
                echo "<h3>Pilih dulu coy tabel yang akan ditampilkan</h3>";
        }
        mysqli_close($conn);
    }

    ?>
</body>

</html>