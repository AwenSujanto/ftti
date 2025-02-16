<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "toko_buku_ftti");

// Cek koneksi
if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tambah Data
if (isset($_POST['tambah'])) {
    $kode_menu = $_POST['kode_menu'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];

    $query = "INSERT INTO menu (kode_menu, nama, harga, gambar, kategori, status) 
              VALUES ('$kode_menu', '$nama', '$harga', '$gambar', '$kategori', '$status')";
    mysqli_query($koneksi, $query);
}

// Edit Data
if (isset($_POST['edit'])) {
    $id_menu = $_POST['id_menu'];
    $kode_menu = $_POST['kode_menu'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar'];
    $kategori = $_POST['kategori'];
    $status = $_POST['status'];

    $query = "UPDATE menu 
              SET kode_menu='$kode_menu', nama='$nama', harga='$harga', gambar='$gambar', kategori='$kategori', status='$status' 
              WHERE id_menu='$id_menu'";
    mysqli_query($koneksi, $query);
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id_menu = $_GET['hapus'];
    $query = "DELETE FROM menu WHERE id_menu='$id_menu'";
    mysqli_query($koneksi, $query);
}

// Ambil data menu
$query = "SELECT * FROM menu ORDER BY id_menu DESC";
// $query = "SELECT * FROM menu";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Menu</title>
</head>
<body>

    <h1>CRUD Menu</h1>

    <!-- Form Tambah/Edit Menu -->
    <form action="crud_menu.php" method="POST">
        <input type="hidden" name="id_menu" id="id_menu" value="">
        <label for="kode_menu">Kode Menu:</label>
        <input type="text" name="kode_menu" id="kode_menu" required><br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required><br>

        <label for="harga">Harga:</label>
        <input type="number" name="harga" id="harga" required><br>

        <label for="gambar">Gambar:</label>
        <input type="text" name="gambar" id="gambar"><br>

        <label for="kategori">Kategori:</label>
        <input type="text" name="kategori" id="kategori"><br>

        <label for="status">Status:</label>
        <select name="status" id="status"></select>
           
            <option value="tersedia">Tersedia</option>
            <option value="tidak tersedia">Tidak Tersedia</option>
        </select><br>

        <button type="submit" name="tambah">Tambah Menu</button>
        <button type="submit" name="edit">Edit Menu</button>
    </form>

    <h2>Daftar Menu</h2>
    <table border="1">
        <tr>
            <th>ID Menu</th>
            <th>Kode Menu</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id_menu']; ?></td>
                <td><?php echo $row['kode_menu']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td><?php echo $row['gambar']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="crud_menu.php?edit=<?php echo $row['id_menu']; ?>">Edit</a> |
                    <a href="crud_menu.php?hapus=<?php echo $row['id_menu']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php
    // Jika mengedit data
    if (isset($_GET['edit'])) {
        $id_menu = $_GET['edit'];
        $query = "SELECT * FROM menu WHERE id_menu='$id_menu'";
        $result = mysqli_query($koneksi, $query);
        $data = mysqli_fetch_assoc($result);

        // Isi form dengan data menu yang akan diedit
        echo "<script>
                document.getElementById('id_menu').value = '{$data['id_menu']}';
                document.getElementById('kode_menu').value = '{$data['kode_menu']}';
                document.getElementById('nama').value = '{$data['nama']}';
                document.getElementById('harga').value = '{$data['harga']}';
                document.getElementById('gambar').value = '{$data['gambar']}';
                document.getElementById('kategori').value = '{$data['kategori']}';
                document.getElementById('status').value = '{$data['status']}';
              </script>";
    }
    ?>

</body>
<script>
    let status = 1; // atau 0, tergantung nilai yang ingin Anda periksa

let ketersediaan;
if (status === 1) {
    ketersediaan = "Tersedia";
} else {
    ketersediaan = "Tidak Tersedia";
}

console.log(ketersediaan); // Output: "Tersedia" jika status = 1, "Tidak Tersedia" jika status = 0

</script>
</html>
