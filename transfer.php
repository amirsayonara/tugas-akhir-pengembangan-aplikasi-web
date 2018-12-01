<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN TRANSFER
    AUTHOR: 160411100145 ABDUR ROHMAN
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
                    <li><a href="home">Beranda</a> |</li>
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
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li class="disini">Transfer</li>
                    <li><a href="user-management">Informasi Pengguna</a></li>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Transfer</h2>
                <?php
                if (!empty($_POST)) {//pengecekan data $_POST, jika sudah ada maka melakukan validasi di bawah ini
                    transfer_validation();
                    if (!empty($pesan_error)) include 'includes/transfer-content.php'; //jika masih ada pesan error
                    else { //jika tidak ada pesan error
                        if (!isset($_POST['konfirmasi-transfer'])) { //mengecek index di data $_POST, jika belum ada maka dianggap belum konfirmasi
                            ?>
                            <form method="POST">
                                Anda akan mentransfer uang dengan rincian sebagai berikut:<br><br>
                                <input type="hidden" name="nomor-rekening" value="<?=$_POST['nomor-rekening']?>">
                                <input type="hidden" name="nomor-rekening-tujuan" value="<?=$_POST['nomor-rekening-tujuan']?>">
                                <input type="hidden" name="nominal" value="<?=$_POST['nominal']?>">
                                <input type="hidden" name="konfirmasi-transfer" value="1">
                                <table class="tabel-khusus">
                                    <tr>
                                        <td>Dari Rekening</td><td class="min-300">: <?=$_POST['nomor-rekening']?></td>
                                    </tr>
                                    <tr class="warna-baris">
                                        <td>Rekening Tujuan</td><td>: <?=$_POST['nomor-rekening-tujuan']?></td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td><td>: <?=info_rekening($_POST['nomor-rekening-tujuan'])['nama']?></td>
                                    </tr>
                                    <tr class="warna-baris">
                                        <td>Nominal</td><td>: <?=rp($_POST['nominal'])?></td>
                                    </tr>
                                </table><br><br>
                                <input type="submit" value="Konfirmasi"> <input type="reset" value="Batal" onclick="history.back()">
                            </form>
                            <?php
                        } else {
                            //jika sudah ada konfirmasi dan tidak ada pesan error
                            echo 'Transfer Berhasil <button onclick="location.replace(\'/transfer\')">Kembali</button>';
                        }
                    }
                    //pertamakali diload (belum ada data $_POST)
                } else include 'includes/transfer-content.php';
                ?>
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