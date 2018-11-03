<?php include 'includes/api.php'; require 'includes/sudah-masuk.php' ?>
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
                    <?php if (pengguna()['jenis_pengguna']=='0') {?>
                    <li>Manajemen Pengguna</li>
                    <?php } else {?>
                    <li>Informasi Rekening</li>
                    <li>Mutasi Rekening</li>
                    <li>Transfer</li>
                    <li>Manajemen Pengguna</li>
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
                <p>C07 Internet Banking - Pengembangan Aplikasi Web (C) - 2018</p>
            </div>
        </div>
    </footer>
</body>
</html>