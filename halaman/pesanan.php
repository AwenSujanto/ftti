<?php
require_once "config.php"; // Pastikan Anda memiliki file konfigurasi untuk koneksi database

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan data pesanan dari database
$query = "
    SELECT u.username, m.nama AS nama_menu, p.jumlah, p.total_harga, p.status, p.created_at
    FROM pesanan p
    JOIN user u ON p.id_user = u.id_user
    JOIN menu m ON p.id_menu = m.id_menu
    ORDER BY u.username, p.created_at DESC
";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

$currentUser = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Data Pesanan</h1>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            if ($currentUser != $row['username']) {
                if ($currentUser != '') {
                    // Menutup tabel sebelumnya jika bukan user pertama
                    echo "</table><br>";
                }
                $currentUser = $row['username'];
                // Header tabel untuk setiap user
                echo "<h3>" . htmlspecialchars($currentUser) . "</h3>";
                echo "<table class='table table-bordered table-hover' style='margin-top: 20px;'>
                        <tr class='text-bg-success'>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Waktu Pesanan</th>
                        </tr>";
                $i = 1;
            }
            // Baris data untuk setiap pesanan
            echo "<tr style='background-color: white;'>";
            echo "<td>" . $i++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nama_menu']) . "</td>";
            echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
            echo "<td>Rp. " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
            echo "</tr>";
        }
        // Menutup tabel terakhir jika ada data
        if ($currentUser != '') {
            echo "</table>";
        }
        ?>
    </div>
</body>

</html>