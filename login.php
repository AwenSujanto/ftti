<?php
error_reporting(0);

session_start();

require_once "function.php";

    if (isset($_POST["login"])) {
        $login = login_akun();
        if ($login) {
            $_SESSION['user_id'] = $login['id'];
            $_SESSION['username'] = $login['username'];
            header("Location: index.php");
            exit();
        }

} else if (isset($_POST["register"])) {

    $register = register_akun();

    echo $register > 0

        ? "<script>

            alert('Berhasil Registrasi!');

            location.href = 'login.php';

        </script>"

        : "<script>

            alert('Gagal Registrasi!');

            location.href = 'login.php';

        </script>";


    }

    
    
?>

<!DOCTYPE html>

<html lang="en">
<style>
    body {
        background-image: url('src/img/ftti-bg.jpeg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }
</style>



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./src/css/bootstrap-5.2.0/css/bootstrap.min.css">

    <title>Toko Buku FTTI</title>

</head>



<body>
    <!-- <img src="src/img/ftti-bg.jpeg" witdh="100%" height="100%"> -->


    <div class="container">


        <div id="judul-form" class="text-center h1 mt-5">Toko Buku FTTI</div><br>

        <div class="mx-auto rounded p-5" style="width: 500px; background-color: white;">

            <!-- Tab Login & Register -->

            <div class="d-flex justify-content-between">

                <button id="tab-login" class="btn btn-primary fw-bold" style="width: 190px;">LOGIN</button>

                <button class="btn btn-outline-primary fw-bold" style="width: 190px;">REGISTER</button>

            </div><br>

            <!-- Jika Username & Password Login Salah -->

            <?php if (isset($_POST["login"])) {

                    if (!$login) { ?>

            <div class="alert alert-danger alert-dismissible">

                * username/password salah

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>

            <?php }

            } ?>

            <!-- Form Login & Register -->

            <form id="form" action="login.php" method="POST">

                <input class="form-control mx-auto d-block" type="text" autocomplete="off" name="username"
                    value="serius" placeholder="Username" required><br>

                <input class="form-control mx-auto d-block" type="password" autocomplete="off" name="password"
                    value="serius" placeholder="Password" required><br>

                <button class="btn btn-primary" name="login">Login</button>

            </form>

        </div>

    </div>

    <script src="./src/css/bootstrap-5.2.0/js/bootstrap.bundle.min.js"></script>

    <script src="./src/js/login.js"></script>

</body>



</html>