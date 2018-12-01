<?php include 'includes/api.php'; if (isset($_SESSION['nama-pengguna'])) header('Location: ./home');?>
<!--
    Halaman login/masuk
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
            <div class="slider">
				<figure>
					<img src="images/slide1.jpg" alt="slide1">
					<img src="images/slide2.jpg" alt="slide2">
					<img src="images/slide3.jpg" alt="slide3">
				</figure>
			</div>
            <div class="artikel c1">
                <h2>Tips Keamanan</h2>
                <ol>
                    <li>Pastikan Semua Data Perbankan Tidak Diketahui Orang Lain Termasuk Pegawai Bank</li>
                    <li>Batasi Transaksi Hanya Di tempat Tertentu</li>
                    <li>Pastikan Website Internet Banking Terlindungi dan Aman</li>
                    <li>Ubah Password Anda Secara Berkala</li>
                    <li>Pastikan Keluar Dari Browser Internet Banking Melalui Cara yang Benar</li>
                    <li>Pastikan Transaksi Internet Banking Melalui Smartphone Aman</li>
                    <li>Segera Menginformasikan Bank Jika mengalami kondisi Darurat</li>
                </ol>
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