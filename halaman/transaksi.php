<?php
// require_once '../config.php';

$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : null;

$query = "SELECT u.id_user, u.username, m.nama as nama_menu, p.jumlah, p.total_harga, p.status, p.created_at, p.id_pesanan
          FROM pesanan p
          JOIN user u ON p.id_user = u.id_user
          JOIN menu m ON p.id_menu = m.id_menu" . ($id_user ? " WHERE u.id_user = $id_user" : "") . "
          ORDER BY u.username, p.created_at DESC";

$result = mysqli_query($koneksi, $query);
?>

<table class="table table-bordered table-hover" style="margin-top: 100px;">
    <tr class="text-bg-success">
        <th>No</th>
        <th>Nama Pelanggan</th>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Total Harga</th>
        <th>Status</th>
        <th>Waktu Pesanan</th>
        <th>Aksi</th>
    </tr>
    <?php 
    $i = 1;
    $current_user = '';
    $total_per_user = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($current_user != $row['username']) {
            if ($current_user != '') {
                echo "<tr><td colspan='8' class='text-end'>";
                echo "<a href='cetak_struk_admin.php?id_user={$prev_id_user}' target='_blank' class='btn btn-primary btn-sm'>Cetak Struk</a>";
                echo "</td></tr>";
                echo "</tbody>";
            }
            echo "<tr class='table-secondary'><td colspan='8'><strong>Pelanggan: {$row['username']}</strong></td></tr>";
            echo "<tbody id='user-{$row['id_user']}'>";
            $current_user = $row['username'];
            $prev_id_user = $row['id_user'];
            $i = 1;
            $total_per_user = 0;
        }
        $total_per_user += $row['total_harga'];
    ?>
    <tr style="background-color: white;">
        <td><?= $i++; ?></td>
        <td><?= $row['username']; ?></td>
        <td><?= $row['nama_menu']; ?></td>
        <td><?= $row['jumlah']; ?></td>
        <td>Rp. <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
        <td class="status-cell"><?= $row['status']; ?></td>
        <td><?= date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
        <td>
            <form method="POST" action="">
                <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                <select class="form-select form-select-sm" name="new_status" onchange="this.form.submit()">
                    <option value="">Ubah Status</option>
                    <option value="pending" <?= ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="lunas cash" <?= ($row['status'] == 'lunas cash') ? 'selected' : ''; ?>>Lunas Cash
                    </option>
                    <option value="lunas tf" <?= ($row['status'] == 'lunas tf') ? 'selected' : ''; ?>>Lunas TF</option>
                </select>
                <input type="hidden" name="update_status" value="1">
            </form>
            <a href="hapus.php?id_pesanan=<?= $row['id_pesanan']; ?>" class="btn btn-danger btn-sm mt-1"
                onclick="return confirm('Hapus pesanan ini?')">Hapus</a>
        </td>
    </tr>
    <?php 
    }
    if ($current_user != '') {
        echo "<tr><td colspan='8' class='text-end'>";
        echo "<a href='cetak_struk_admin.php?id_user={$prev_id_user}' target='_blank' class='btn btn-primary btn-sm'>Cetak Struk</a>";
        echo "</td></tr>";
        echo "</tbody>";
    }
    ?>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(() => {
                        const userId = this.querySelector('input[name="id_user"]').value;
                        const newStatus = this.querySelector('select[name="new_status"]')
                            .value;
                        const userRows = document.querySelectorAll(
                            `#user-${userId} .status-cell`);
                        userRows.forEach(cell => {
                            cell.textContent = newStatus;
                        });
                    });
            });
        });
    });
</script>