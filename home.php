<?php include 'includes/api.php'; require 'includes/sudah-masuk.php' ?>
<!--
    Halaman index/utama
    Author: 160411100142 MOHAMMAD FAISHOL
    -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/favicon.png">
    <script type="text/javascript" src="js/main.js"></script>
    <title>Seven Bank - Internet Banking</title>
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
                    <img src="images/user-images.png" alt="user-image" width="90"><br>
                    <b><?=pengguna()['nama']?></b><br>
                    <?=pengguna()['keterangan']?><br>
                </div>
            </div>
            <hr class="hr-besar">
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
                <p>Selamat datang <?=pengguna()['nama']?> di Seven Bank - Internet Banking!</p>
            </div>
        </div>
    </div>
    <footer>
        <div class="konten">
            <div class="footer_kanan">
                : Jl. Panglima Sudirman No. 7 - Jakarta Pusat<br>
                : customer@sevenbank.co.id<br>
                : (021) 1000000<br>
                : (021) 1777777 (Bebas Pulsa)<br>
            </div>
            <div class="footer_kanan">
                Kantor Pusat<br>
                E-mail<br>
                Telp.<br>
                
            </div>
            <div class="footer_kiri">
                Copyright &copy; 2018 Seven BANK
            </div>
        </div>
    </footer>
</body>
</html>