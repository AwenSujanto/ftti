<?php

    $user_id = $_SESSION["akun-user"]['id_user'];


$query = "SELECT p.id_pesanan, m.nama, p.jumlah, p.total_harga, p.status, p.created_at 
          FROM pesanan p 
          JOIN menu m ON p.id_menu = m.id_menu 
          WHERE p.id_user = ?
          ORDER BY p.created_at DESC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['kurangi'])) {
        kurangi_pesanan($_POST['id_pesanan']);
    } elseif (isset($_POST['hapus'])) {
        hapus_pesanan($_POST['id_pesanan']);
    }
}

function kurangi_pesanan($id_pesanan) {
    global $koneksi;
    
    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Ambil informasi pesanan
        $query = "SELECT id_menu, jumlah FROM pesanan WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_pesanan);
        $stmt->execute();
        $result = $stmt->get_result();
        $pesanan = $result->fetch_assoc();

        if ($pesanan['jumlah'] > 1) {
            // Kurangi jumlah pesanan
            $query = "UPDATE pesanan SET jumlah = jumlah - 1, 
                      total_harga = total_harga - (SELECT harga FROM menu WHERE id_menu = pesanan.id_menu) 
                      WHERE id_pesanan = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();

            // Update stok di tabel menu
            $query = "UPDATE menu SET stok = stok + 1 WHERE id_menu = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $pesanan['id_menu']);
            $stmt->execute();
        } else {
            // Jika jumlah pesanan tinggal 1, hapus pesanan
            $query = "DELETE FROM pesanan WHERE id_pesanan = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();

            // Update stok di tabel menu
            $query = "UPDATE menu SET stok = stok + 1 WHERE id_menu = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $pesanan['id_menu']);
            $stmt->execute();
        }

        // Commit transaksi
        $koneksi->commit();
        header("Location: index.php?pesanan_saya");
        exit();

    } catch (Exception $e) {
        // Rollback jika terjadi error
        $koneksi->rollback();
        // Handle error (misalnya, log error atau tampilkan pesan ke user)
        error_log($e->getMessage());
    }
}

function hapus_pesanan($id_pesanan) {
    global $koneksi;
    
    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Ambil informasi pesanan sebelum dihapus
        $query = "SELECT id_menu, jumlah FROM pesanan WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_pesanan);
        $stmt->execute();
        $result = $stmt->get_result();
        $pesanan = $result->fetch_assoc();

        if ($pesanan) {
            // Hapus pesanan
            $query = "DELETE FROM pesanan WHERE id_pesanan = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_pesanan);
            $stmt->execute();

            // Update stok di tabel menu
            $query = "UPDATE menu SET stok = stok + ? WHERE id_menu = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ii", $pesanan['jumlah'], $pesanan['id_menu']);
            $stmt->execute();

            // Commit transaksi
            $koneksi->commit();
        header("Location: index.php?pesanan_saya");
        exit();
        } else {
            // Jika pesanan tidak ditemukan, rollback transaksi
            $koneksi->rollback();

        header("Location: index.php?pesanan_saya");
        exit();
        }


    } catch (Exception $e) {
        // Rollback jika terjadi error
        $koneksi->rollback();
        // Handle error (misalnya, log error atau tampilkan pesan ke user)
        error_log($e->getMessage());
    }

    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan Saya</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Daftar Pesanan Saya</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $p['nama'] ?></td>
                    <td><?= $p['jumlah'] ?></td>
                    <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                    <td><?= $p['status'] ?></td>
                    <td><?= $p['created_at'] ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id_pesanan" value="<?= $p['id_pesanan'] ?>">
                            <button type="submit" name="kurangi" class="btn btn-warning btn-sm">Kurangi</button>
                            <button type="submit" name="hapus" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <a href="index.php" class="btn btn-primary">Kembali ke Menu</a>
        <a href="halaman/cetak_struk.php" target="_blank" class="btn btn-success">Cetak Struk</a>
    </div>
</body>

</html>