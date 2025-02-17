<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesan'])) {
    $id_user = $_SESSION['user_id'] ?? 0; // Pastikan user sudah login
    $id_menu = $_POST['id_menu'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $total_harga = $jumlah * $harga;

    $query = "INSERT INTO pesanan (id_user, id_menu, jumlah, total_harga) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiid", $id_user, $id_menu, $jumlah, $total_harga);

    if ($stmt->execute()) {
        header("Location: menu.php?pesan=sukses");
        exit();
    } else {
        header("Location: menu.php?pesan=gagal");
        exit();
    }
} else {
    header("Location: menu.php");
    exit();
}