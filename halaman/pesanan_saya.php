<?php
session_start();
require_once 'config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil daftar pesanan user
$query = "SELECT p.id, m.nama, p.jumlah, p.total_harga, p.status, p.created_at 
          FROM pesanan p 
          JOIN menu m ON p.id_menu = m.id_menu 
          WHERE p.id_user = ?
          ORDER BY p.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);

// Proses CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                hapus_pesanan($_POST['id']);
                break;
            case 'update':
                update_pesanan($_POST['id'], $_POST['jumlah']);
                break;
        }
    }
}

function hapus_pesanan($id) {
    global $conn;
    $query = "DELETE FROM pesanan WHERE id = ? AND id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: pesanan_saya.php");
    exit();
}

function update_pesanan($id, $jumlah) {
    global $conn;
    $query = "UPDATE pesanan SET jumlah = ?, total_harga = (SELECT harga FROM menu WHERE id_menu = pesanan.id_menu) * ? WHERE id = ? AND id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $jumlah, $jumlah, $id, $_SESSION['user_id']);
    $stmt->execute();
    header("Location: pesanan_saya.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Pesanan Saya</h1>
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
                        <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="number" name="jumlah" value="<?= $p['jumlah'] ?>" min="1" style="width: 60px;">
                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                        </form>
                        <form action="" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-primary">Kembali ke Menu</a>
    </div>
</body>

</html>