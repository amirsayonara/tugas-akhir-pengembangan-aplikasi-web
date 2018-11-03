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
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a>Manajemen Pengguna</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Manajemen Pengguna</h2>
                <h3>Akun dan Profil</h3>
                <table>
                    <tr>
                        <td>Nama Pengguna</td><td>: <?=pengguna()['nama_pengguna']?></td>
                    </tr>
                    <tr>
                        <td>Jenis Pengguna</td><td>: <?=pengguna()['keterangan']?></td>
                    </tr>
                    <tr>
                        <td>Nama</td><td>: <?=pengguna()['nama']?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td><td>: <?=pengguna()['alamat']?></td>
                    </tr>
                    <tr>
                        <td>Nomor HP</td><td>: <?=pengguna()['nomor_hp']?></td>
                    </tr>
                    <tr>
                        <td>E-mail</td><td>: <a href="mailto:<?=pengguna()['email']?>"><?=pengguna()['email']?></a></td>
                    </tr>
                </table>
                <button>Edit Akun dan Profil</button>
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