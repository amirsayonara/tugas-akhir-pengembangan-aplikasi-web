<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN INFO REKENING
    AUTHOR: 160411100152 NATIQ HASBI ALIM
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
                echo '<br><table class="tabel-khusus"><tr><th>No</th><th>Nomor Rekening</th><th>Saldo</th></tr>';$no = 1; //penomoran tabel
                foreach (pengguna_rinci($_SESSION['nama-pengguna'])['rekening'] as $x) {
                    if ($no%2==0) $w = ' class="warna-baris"';
                    else $w = "";
                    //menampilkan data rekening yang dimiliki pengguna dan saldonya
                    echo "<tr$w>";
                    $saldo = info_rekening($x['nomor_rekening'])['saldo'];
                    echo "<td>$no</td><td class=\"min-300\">{$x['nomor_rekening']}</td><td class=\"min-200\">".rp($saldo)."</td>";
                    echo '</tr>'; $no++;
                }
                echo '</table>';
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