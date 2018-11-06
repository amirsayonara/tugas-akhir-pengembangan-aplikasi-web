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
                    <li><a>Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a href="user-management">Manajemen Pengguna</a></li>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Informasi Rekening</h2>
                <form method="POST">
                    <table>
                        <tr>
                            <td><label for="nomor-rekening">Pilih Rekening</label></td>
                            <td>
                                <select name="nomor-rekening" id="nomor-rekening">
                                    <option value="-1">---</option>
                                    <?php
                                    foreach (list_rekening($_SESSION['nama-pengguna']) as $x) echo "<option value=\"{$x['nomor_rekening']}\">{$x['nomor_rekening']}</option>";
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Kirim"></td>
                        </tr>
                    </table>
                </form>
                <?php
                if (!empty($_POST)) {
                    $saldo = info_rekening(@$_POST['nomor-rekening'])['saldo'];
                    if($saldo) {
                        ?><hr>
                        <table>
                            <tr>
                                <td>Rekening</td><td>: <?=$_POST['nomor-rekening']?></td>
                            </tr>
                            <tr>
                                <td>Saldo</td><td>: Rp <?=$saldo?></td>
                            </tr>
                        </table>
                        <?php
                    }
                }
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