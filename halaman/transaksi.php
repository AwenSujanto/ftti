<?php
require_once "config.php"; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'])) {
        $id_pesanan = $_POST['id_pesanan'];
        $new_status = $_POST['new_status'];
        $update_query = "UPDATE pesanan SET status = ? WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("si", $new_status, $id_pesanan);
        $stmt->execute();
    }

    if (isset($_POST['delete_order'])) {
        $id_pesanan = $_POST['id_pesanan'];
        $delete_query = "DELETE FROM pesanan WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($delete_query);
        $stmt->bind_param("i", $id_pesanan);
        $stmt->execute();
    }

    if (isset($_POST['update_jumlah'])) {
        $id_pesanan = $_POST['id_pesanan'];
        $new_jumlah = $_POST['new_jumlah'];
        $update_query = "UPDATE pesanan SET jumlah = ?, total_harga = jumlah * (SELECT harga FROM menu WHERE id_menu = pesanan.id_menu) WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("ii", $new_jumlah, $id_pesanan);
        $stmt->execute();
    }
}

$query = "
    SELECT p.id_pesanan, u.id_user, u.username, m.nama AS nama_menu, p.jumlah, p.total_harga, p.status, p.created_at
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
$canPrintInvoice = true;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
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
                    echo "</table>";
                    if ($canPrintInvoice) {
                        echo "<a href='cetak_struk_admin.php?id_user={$row['id_user']}' target='_blank' class='btn btn-primary'>Cetak Struk</a><br><br>";
                    }
                }
                $currentUser = $row['username'];
                $canPrintInvoice = true;
                echo "<h3>" . htmlspecialchars($currentUser) . "</h3>";
                echo "<table class='table table-bordered table-hover' style='margin-top: 20px;'>
                        <tr class='text-bg-success'>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Waktu Pesanan</th>
                            <th>Aksi</th>
                        </tr>";
                $i = 1;
            }
            echo "<tr style='background-color: white;'>";
            echo "<td>" . $i++ . "</td>";
            echo "<td>" . htmlspecialchars($row['nama_menu']) . "</td>";
            echo "<td>";
            if ($row['status'] == 'pending') {
                echo "<form method='post' action=''>
                        <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                        <input type='number' name='new_jumlah' value='" . htmlspecialchars($row['jumlah']) . "' min='1' onchange='this.form.submit()'>
                        <input type='hidden' name='update_jumlah' value='1'>
                      </form>";
                $canPrintInvoice = false;
            } else {
                echo htmlspecialchars($row['jumlah']);
            }
            echo "</td>";
            echo "<td>Rp. " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
            echo "<td>
                    <form method='post' action='' onchange='this.submit()' style='display: inline-block;'>
                        <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                        <select class='form-select form-select-sm' name='new_status'>
                            <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                            <option value='lunas cash'" . ($row['status'] == 'lunas cash' ? ' selected' : '') . ">Lunas Cash</option>
                            <option value='lunas tf'" . ($row['status'] == 'lunas tf' ? ' selected' : '') . ">Lunas TF</option>
                        </select>
                        <input type='hidden' name='update_status' value='1'>
                    </form>
                  </td>";
            echo "<td>" . date('d/m/y h:i', strtotime($row['created_at'])) . "</td>";
            echo "<td>
                    <form method='post' action='' style='display: inline-block;' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');\">
                        <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                        <button type='submit' name='delete_order' value='1' class='btn btn-danger btn-sm'>Hapus</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        if ($currentUser != '' && isset($row)) {
            echo "</table>";
            if ($canPrintInvoice) {
                echo "<a href='cetak_struk_admin.php?id_user={$row['id_user']}' target='_blank' class='btn btn-primary'>Cetak Struk</a><br><br>";
            }
        }
        ?>
    </div>
</body>

</html>