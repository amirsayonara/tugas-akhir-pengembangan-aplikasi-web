<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN TRANSFER
    AUTHOR: 160411100145 ABDUR ROHMAN
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
                                Anda akan mentransfer uang dengan rincian sbb:
                                <input type="hidden" name="nomor-rekening" value="<?=$_POST['nomor-rekening']?>">
                                <input type="hidden" name="nomor-rekening-tujuan" value="<?=$_POST['nomor-rekening-tujuan']?>">
                                <input type="hidden" name="nominal" value="<?=$_POST['nominal']?>">
                                <input type="hidden" name="konfirmasi-transfer" value="1">
                                <table>
                                    <tr>
                                        <td>Dari Rekening</td><td>: <?=$_POST['nomor-rekening']?></td>
                                    </tr>
                                    <tr>
                                        <td>Rekening Tujuan</td><td>: <?=$_POST['nomor-rekening-tujuan']?></td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td><td>: <?=info_rekening($_POST['nomor-rekening-tujuan'])['nama']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nominal</td><td>: <?=rp($_POST['nominal'])?></td>
                                    </tr>
                                </table>
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
            <div class="artikel">
                <p>Copyright &copy; 2018 Se7en Bank - Internet Banking</p>
            </div>
        </div>
    </footer>
</body>
</html>