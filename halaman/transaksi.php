<?php

// Mengecek apakah terdapat request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kode untuk update status dan delete order tetap sama, tidak diubah
}

$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : null;
$prev_id_user = $id_user; // Menyimpan id_user untuk penggunaan cetak struk

$query = "SELECT u.id_user, u.username, m.nama as nama_menu, p.jumlah, p.total_harga, p.status, p.created_at, p.id_pesanan
          FROM pesanan p
          JOIN user u ON p.id_user = u.id_user
          JOIN menu m ON p.id_menu = m.id_menu" . ($id_user ? " WHERE u.id_user = $id_user" : "") . "
          ORDER BY u.username, p.created_at DESC";

$result = mysqli_query($koneksi, $query);

$currentUser = '';
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
                    <th>Aksi</th>
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
    echo "<td>
            <!-- Aksi untuk update status dan delete order -->
            <form method='POST' action='' style='display: inline-block;'>
                <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                <!-- Select untuk update status -->
                <select class='form-select form-select-sm' name='new_status' onchange='this.form.submit()'>
                    <option value=''>Ubah Status</option>
                    <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                    <option value='lunas cash'" . ($row['status'] == 'lunas cash' ? ' selected' : '') . ">Lunas Cash</option>
                    <option value='lunas tf'" . ($row['status'] == 'lunas tf' ? ' selected' : '') . ">Lunas TF</option>
                </select>
                <input type='hidden' name='update_status' value='1'>
            </form>
            <!-- Form untuk delete order -->
            <form method='POST' action='' style='display: inline-block;' onsubmit=\"return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');\">
                <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                <button type='submit' name='delete_order' value='1' class='btn btn-danger btn-sm'>Hapus</button>
            </form>
            <!-- Link untuk cetak struk -->
            <a href='cetak_struk_admin.php?id_user={$row['id_user']}' target='_blank' class='btn btn-primary btn-sm'>Cetak Struk</a>
          </td>";
    echo "</tr>";
}
// Menutup tabel terakhir jika ada data
if ($currentUser != '') {
    echo "</table>";
}
?>