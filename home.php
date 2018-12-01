<?php include 'includes/api.php'; require 'includes/sudah-masuk.php' ?>
<!--
    Halaman index/utama
    Author: 160411100142 MOHAMMAD FAISHOL
    -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/favicon.png">
    <title>Se7en Bank - Internet Banking</title>
</head>
<body>
    <header>
        <div class="konten">
            <h1><img src="images/logo.png" alt="logo"></h1>
            <nav>
                <ul>
                    <li><a class="dipilih">Beranda</a> |</li>
                    <li><a href="help">Bantuan </a> |</li>
                    <li><a href="logout">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="konten-utama">
        <div class="kiri">
            <div class="artikel">
                <h3>Info Pengguna</h3>
                <div class="info-pengguna">
                    <div class="isian">
                        <div class="baris">
                            <div class="l-col">Nama</div>
                            <div class="r-col">: <b><?=pengguna()['nama']?></b></div>
                        </div>
                        <div class="baris">
                            <div class="l-col">Jenis Pengguna</div>
                            <div class="r-col">: <?=pengguna()['keterangan']?></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="artikel">
                <ul>
                    <?php if (pengguna()['jenis_pengguna']=='0') {?>
                    <!-- Mengecek jika yang login adalah admin, maka hanya dapat melakukan manajemen pengguna level admin
                         dan jika yang login adalah customer, maka dapat melakukan transaksi dan fitur customer lainnya -->
                    <li><a href="user-management">Manajemen Pengguna</a></li>
                    <?php } else {?>
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a href="user-management">Informasi Pengguna</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Halaman Depan</h2>
                <p>Selamat datang <?=pengguna()['nama']?> di C07 Internet Banking!</p>
            </div>
        </div>
    </div>
    <footer>
        <div class="konten">
            <div class="artikel">
                <p>Copyright &copy; 2018 Se7en Bank - Internet Banking</p>
            </div>
        </div>
    </footer>
</body>
</html>