<?php
require_once '../config.php'; // Sesuaikan path ke file config anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pesanan = $_POST['id_pesanan'] ?? null;
    $new_status = $_POST['new_status'] ?? null;

    if ($id_pesanan && $new_status) {
        $query = "UPDATE pesanan SET status = ? WHERE id_pesanan = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("si", $new_status, $id_pesanan);

        if ($stmt->execute()) {
            echo "Status berhasil diupdate.";
        } else {
            echo "Gagal mengupdate status.";
        }
    } else {
        echo "Data tidak lengkap.";
    }
}
?>