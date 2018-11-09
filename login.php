<?php include 'includes/api.php'; if (isset($_SESSION['nama-pengguna'])) header('Location: ./');?>
<!--
    Halaman login/masuk
    Author: 160411100142 MOHAMMAD FAISHOL
    -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>C07 Internet Banking - Masuk</title>
</head>
<body>
    <header>
        <div class="konten">
            <h1>C07 Net Banking</h1>
            <nav>
                <ul>
                    <li><a href="help">Bantuan</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="konten-utama">
        <div class="kiri">
            <div class="artikel">
                <?php
                if (!empty($_POST)) { //jika sudah ada data $_POST
                    login_validation(); //melakukan validasi login
                    if (!empty($pesan_error)) include 'includes/login-content.php'; //jika masih ada kesalahan
                } else include 'includes/login-content.php'; //pertamakali diload
                ?>
            </div>
        </div>
        <div class="kanan">
            <img src="images/gambar1.jpg" alt="Coba" width="100%">
            <div class="artikel">
                <h2>Informasi</h2>
                <p>Testing</p>
            </div>
        </div>
    </div>
    <footer>
        <div class="konten">
            <div class="artikel">
                <p>C07 Internet Banking - Pengembangan Aplikasi Web (C) - 2018</p>
            </div>
        </div>
    </footer>
</body>
</html>