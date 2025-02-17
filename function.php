<?php


$koneksi = mysqli_connect("localhost", "root", "root", "toko_buku_ftti");


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pesan']) ) {
        tambah_pesanan($_POST);
    }
}

/**
 * Tambahkan pesanan ke database.
 *
 * @param array $data Data pesanan
 *                      - id_menu: ID menu yang dipesan
 *                      - jumlah: Jumlah menu yang dipesan
 *                      - harga: Harga menu yang dipesan
 *
 * @return void
 */
function tambah_pesanan($data) {
    global $koneksi;

    $id_user = $_SESSION['user_id'] ?? 0;
    $id_menu = $data['id_menu'];
    $jumlah = $data['jumlah'];
    $harga = $data['harga'];
    $total_harga = $jumlah * $harga;

    $query = "INSERT INTO pesanan (id_user, id_menu, jumlah, total_harga) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("iiid", $id_user, $id_menu, $jumlah, $total_harga);

    // Update stok di tabel menu
        $update_query = "UPDATE menu SET stok = stok - ? WHERE id_menu = ?";
        $update_stmt = $koneksi->prepare($update_query);
        $update_stmt->bind_param("ii", $jumlah, $id_menu);
        $update_stmt->execute();

    if ($stmt->execute()) {
        header("Location: index.php?pesan=sukses");
    } else {
        header("Location: index.php?pesan=gagal");
    }
    exit();
}

// Funtion Register

function register_akun()

{

    global $koneksi;



    $username = htmlspecialchars($_POST["username"]);

    $password = md5(htmlspecialchars($_POST["password"]));

    $konfirmasi_password = md5(htmlspecialchars($_POST["konfirmasi-password"]));



    $cek_username = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `user` WHERE username = '$username'"));



    if ($cek_username != null) {

        echo "<script>

            alert('Username sudah ada!');

        </script>";

        return -1;
    } else if ($password != $konfirmasi_password) {

        echo "<script>

            alert('Password Tidak Sesuai!');

        </script>";

        return -1;
    }



    mysqli_query($koneksi, "INSERT INTO `user`

                            VALUES ('', '$username', '$password')

    ");

    return mysqli_affected_rows($koneksi);
}



// Function Login

function login_akun()

{

    global $koneksi;



    $username = htmlspecialchars($_POST["username"]);

    $password = md5(htmlspecialchars($_POST["password"]));



    $cek_akun_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `admin` 

                                                           WHERE username = '$username' AND 

                                                                `password` = '$password'

    "));

    $cek_akun_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `user` 

                                                           WHERE username = '$username' AND 

                                                                `password` = '$password'

    "));



    if ($cek_akun_admin == null && $cek_akun_user == null) return false;

    if ($cek_akun_user != null) {

        $_SESSION["akun-user"] = [

            "username" => $username,

            "password" => $password

        ];
    }
    if ($cek_akun_admin != null) {

        $_SESSION["akun-admin"] = [

            "username" => $username,

            "password" => $password

        ];
    }

    header("Location: index.php");

    exit;
}



// Function Select Data

function ambil_data($query)

{

    global $koneksi;



    $db = [];

    $sql_query = mysqli_query($koneksi, $query);

    while ($q = mysqli_fetch_assoc($sql_query)) {

        array_push($db, $q);
    }

    return $db;
}



// Function Tambah Data

function tambah_data_menu()

{

    global $koneksi;



    $nama = htmlspecialchars($_POST["nama"]);

    $harga = (int) htmlspecialchars($_POST["harga"]);

    $gambar = htmlspecialchars($_FILES["gambar"]["name"]);

    $kategori = htmlspecialchars($_POST["kategori"]);

    $status = htmlspecialchars($_POST["status"]);



    // Generate Kode Menu

    $kode_menu = "MN" . ambil_data("SELECT MAX(SUBSTR(kode_menu, 3)) AS kode FROM menu")[0]["kode"] + 1;



    // cek format gambar

    $format_gambar = ["jpg", "jpeg", "png", "gif"];

    $cek_gambar = explode(".", $gambar);

    $cek_gambar = strtolower(end($cek_gambar));

    if (!in_array($cek_gambar, $format_gambar)) {

        echo "<script>

            alert('File yang diupload bukan merupakan image!');

        </script>";

        return -1;
    }



    // upload file
    $nama_gambar = uniqid() . ".$cek_gambar";
    move_uploaded_file($_FILES["gambar"]["tmp_name"], "src/img/$nama_gambar");



    // eksekusi query insert

    $id_menu = ambil_data("SELECT MAX(SUBSTR(kode_menu, 3)) AS kode FROM menu")[0]["kode"] + 1;

    mysqli_query($koneksi, "INSERT INTO menu

                            VALUES ($id_menu, '$kode_menu', '$nama', $harga, '$nama_gambar', '$kategori', '$status')

    ");

    return mysqli_affected_rows($koneksi);
}



// Function Edit Data Menu

function edit_data_menu()

{

    global $koneksi;



    $id_menu = $_POST["id_menu"];

    $nama = htmlspecialchars($_POST["nama"]);

    $harga = (int) htmlspecialchars($_POST["harga"]);

    $gambar = htmlspecialchars($_FILES["gambar"]["name"]);

    $kategori = htmlspecialchars($_POST["kategori"]);

    $status = htmlspecialchars($_POST["stok"]);

    $kode_menu = htmlspecialchars($_POST["kode_menu"]);



    // cek format gambar

    $format_gambar = ["jpg", "jpeg", "png", "gif"];

    $cek_gambar = explode(".", $gambar);

    $cek_gambar = strtolower(end($cek_gambar));

    if (!in_array($cek_gambar, $format_gambar) && strlen($gambar) != 0) {

        echo "<script>

            alert('File yang diupload bukan merupakan image!');

        </script>";

        return -1;
    }



    // cek jika admin mengupload gambar yang baru

    $gambar_lama = $_POST["gambar-lama"];



    if (strlen($gambar) == 0) {

        $gambar = $gambar_lama;
    } else if ($gambar != $gambar_lama && strlen($gambar) != 0) {

        move_uploaded_file($_FILES["gambar"]["tmp_name"], "src/img/$gambar");

        unlink("src/img/$gambar_lama");
    }



    // eksekusi query update

    mysqli_query($koneksi, "UPDATE menu

                            SET kode_menu = '$kode_menu',

                                nama = '$nama',

                                harga = $harga,

                                gambar = '$gambar',

                                kategori = '$kategori',

                                `stok` = '$status'

                            WHERE id_menu = $id_menu

    ");
//UPDATE `menu` SET `stok` = '0' WHERE `menu`.`id_menu` = 74;
    return mysqli_affected_rows($koneksi);
}



// Function Hapus Data Menu

function hapus_data_menu()

{

    global $koneksi;



    $id_menu = $_GET["id_menu"];



    // hapus file gambar

    $file_gambar = ambil_data("SELECT * FROM menu WHERE id_menu = $id_menu")[0]["gambar"];

    unlink("src/img/$file_gambar");



    // eksekusi query delete

    mysqli_query($koneksi, "DELETE FROM menu

                            WHERE id_menu = $id_menu

    ");

    return mysqli_affected_rows($koneksi);
}



// Tambah Data Pesanan & Transaksi

function tambah_data_pesanan()

{

    global $koneksi;



    // Nama Pelanggan

    $pelanggan = htmlspecialchars($_POST["pelanggan"]);

    // Generate Kode Pesanan

    $kode_pesanan = uniqid();



    // Mengambil Data Qty dan Kode Menu

    $list_pesanan = [];

    $max_menu = count(ambil_data("SELECT * FROM menu"));

    for ($i = 1; $i <= $max_menu; $i++) {

        if ((int) $_POST["qty$i"] != 0) {

            array_push($list_pesanan, [

                "kode_menu" => $_POST["kode_menu$i"],

                "qty" => (int) $_POST["qty$i"]

            ]);
        }
    }


    // Cek Jika Memesan Tapi Kosong
    if (count($list_pesanan) == 0) {
        echo "<script>
            alert('Anda belum memesan menu!');
        </script>";
        return -1;
    }

    // Tambah Data Pesanan

    foreach ($list_pesanan as $lp) {

        $kode_menu = $lp["kode_menu"];

        $qty = $lp["qty"];

        //hitung stok setelah pesanan
        //$stok_menu = (int)ambil_data("SELECT stok FROM menu where menu.kode_menu='$kode_menu'");
        //$stok_akhir = $stok_menu-$qty;

        mysqli_query($koneksi, "INSERT INTO pesanan

                                VALUES ('', '$kode_pesanan', '$kode_menu', $qty);

        ");
        /*mysqli_query($koneksi, "UPDATE `menu` 

                                 SET `stok` = '$stok_akhir' WHERE `menu`.`kode_menu` = '$kode_menu';

        ");*/
        //UPDATE `menu` SET `stok` = '0' WHERE `menu`.`id_menu` = 74;
        
    }

    //Update stok setelah dikurangi

    $stok_menu[]  = ambil_data("SELECT stok FROM menu where menu.kode_menu='$kode_menu'");
    //$jumlah_pesanan = (int) $_POST["qty$i"];
    $sm = (int) $stok_menu[0];
    $stok_akhir = $sm - $qty;

    mysqli_query($koneksi, "UPDATE `menu` 

                                 SET `stok` = '$stok_akhir' WHERE `menu`.`kode_menu` = '$kode_menu';

     ");


    // Tambah Data Transaksi

    mysqli_query($koneksi, "INSERT INTO transaksi

                            VALUES ('', '$kode_pesanan', '$pelanggan', NOW())

    ");

    return mysqli_affected_rows($koneksi);
}



// Hapus Data Pesanan & Transaksi

function hapus_data_pesanan()

{

    global $koneksi;



    $kode_pesanan = $_GET["kode_pesanan"];

    // eksekusi query delete

    mysqli_query($koneksi, "DELETE FROM transaksi

                            WHERE kode_pesanan = '$kode_pesanan'

    ");

    mysqli_query($koneksi, "DELETE FROM pesanan

                            WHERE kode_pesanan = '$kode_pesanan'

    ");

    return mysqli_affected_rows($koneksi);
}