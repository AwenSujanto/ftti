<!-- Search & Tambah -->

<div class="d-flex flex-wrap justify-content-between">

    <nav class="navbar navbar-light">

        <form action="index.php" method="GET" class="form-inline d-flex">

            <input class="form-control mx-sm-2" type="search" autocomplete="off" name="key-search" placeholder="Cari..">

            <button class="btn btn-success mx-2" name="search">Search</button>

        </form>

    </nav>

    <?php if (isset($_SESSION["akun-admin"])) { ?>

    <nav class="navbar navbar-light">

        <a class="btn btn-success fw-bold mx-2" href="tambah.php">+ Tambah Menu Barang</a>

    </nav>

    <?php } ?>

</div>



<div class="row">

    <?php 

    $i = 1;

   foreach ($menu as $i => $m): ?>
    <div class="col-sm-4 mx-auto m-2">
        <div class="card">
            <h5 class="card-header bg-info"><?= $m["nama"] ?></h5>
            <div class="card-body">
                <img class="rounded mb-3" src="src/img/<?= $m["gambar"] ?>" width="150" alt="<?= $m["nama"] ?>">
                <form name="tambah_pesanan" action="function.php" method="POST">
                    <input type="hidden" name="id_menu" value="<?= $m["id_menu"] ?>">
                    <input type="hidden" name="harga" value="<?= $m["harga"] ?>">
                    <table class="table table-striped table-responsive-sm">
                        <tr>
                            <td>Harga</td>
                            <td>:</td>
                            <td>Rp<?= $m["harga"] ?></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td><?= $m["kategori"] ?></td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td><?= $m["stok"] ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td>:</td>
                            <td><input min="1" max="<?= $m["stok"] ?>" type="number" name="jumlah" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" name="pesan" class="btn btn-primary btn-block">Pesan</button>
                            </td>
                            <td colspan="1">
                                <a href="index.php?pesanan_saya">Lihat Pesanan
                                    Saya</a>
                            </td>
                        </tr>
                    </table>
                </form>
                <?php if (isset($_SESSION["akun-admin"])): ?>
                <div class="mt-3">
                    <a class="btn btn-warning" href="edit.php?id_menu=<?= $m["id_menu"] ?>">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </a>
                    <a class="btn btn-danger" href="hapus.php?id_menu=<?= $m["id_menu"] ?>"
                        onclick="return confirm('Ingin Menghapus Menu?')">
                        <i class="bi bi-trash3-fill"></i> Hapus
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </form>

</div>