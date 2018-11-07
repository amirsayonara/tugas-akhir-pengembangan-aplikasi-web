<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>C07 Internet Banking</title>
</head>
<body>
    <header>
        <div class="konten">
            <h1>C07 Net Banking</h1>
            <nav>
                <ul>
                    <li><a href=".">Beranda</a> |</li>
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
                    <table>
                        <tr>
                            <td>Nama</td><td>: <b><?=pengguna()['nama']?></b></td>
                        </tr>
                        <tr>
                            <td>Jenis Pengguna</td><td>: <?=pengguna()['keterangan']?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="artikel">
                <ul>
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a>Transfer</a></li>
                    <li><a href="user-management">Manajemen Pengguna</a></li>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Transfer</h2>
                <?php
                if (!empty($_POST)) {
                    transfer_validation();
                    if (!empty($pesan_error)) include 'includes/transfer-content.php';
                    else {
                        if (!isset($_POST['konfirmasi-transfer'])) {
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
                                    <tr>
                                        <td></td><td><input type="submit" value="Konfirmasi"> <input type="reset" value="Batal" onclick="history.back()"></td>
                                    </tr>
                                </table>
                            </form>
                            <?php
                        } else {
                            echo 'Transfer Berhasil <button onclick="location.replace(\'/transfer\')">Kembali</button>';
                        }
                    }
                } else include 'includes/transfer-content.php';
                ?>
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