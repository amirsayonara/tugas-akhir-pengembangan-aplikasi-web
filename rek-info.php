<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN INFO REKENING
    AUTHOR: 160411100152 NATIQ HASBI ALIM
    -->
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
                    <li class="disini">Informasi Rekening</li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a href="user-management">Informasi Pengguna</a></li>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Informasi Rekening</h2>
                <?php
                echo '<br><table border=1><tr><th>No</th><th>Nomor Rekening</th><th>Saldo</th></tr>';$no = 1; //penomoran tabel
                foreach (pengguna_rinci($_SESSION['nama-pengguna'])['rekening'] as $x) {
                    //menampilkan data rekening yang dimiliki pengguna dan saldonya
                    echo '<tr>';
                    $saldo = info_rekening($x['nomor_rekening'])['saldo'];
                    echo "<td>$no</td><td>{$x['nomor_rekening']}</td><td>".rp($saldo)."</td>";
                    echo '</tr>'; $no++;
                }
                echo '</table>';
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