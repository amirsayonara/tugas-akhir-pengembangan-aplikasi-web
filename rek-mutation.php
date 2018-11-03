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
                    <?php if (pengguna()['jenis_pengguna']=='0') {?>
                    <li>Manajemen Pengguna</li>
                    <?php } else {?>
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a>Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a href="user-management">Manajemen Pengguna</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Mutasi Rekening</h2>
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
                    $mutasi = mutasi(@$_POST['nomor-rekening']);
                    if($mutasi) {
                        ?><hr>
                        Rekening: <?=$_POST['nomor-rekening']?><br><br>
                        <table border="1">
                            <tr>
                                <th>No</th><th>Waktu</th><th>Jenis Transaksi</th><th>Nominal</th><th>Keterangan</th>
                            </tr>
                            <?php $no = 1;
                            foreach ($mutasi as $x) {
                                if ($x['rekening_asal']==$_POST['nomor-rekening'] & $x['rekening_tujuan']!=false) $ket = 'Transfer ke rekening '.$x['rekening_tujuan'].'atas nama '.info_rekening($x['rekening_tujuan'])['nama'];
                                else if ($x['rekening_tujuan']==$_POST['nomor-rekening']) $ket = 'Terima transfer dari rekening '.$x['rekening_asal'].'atas nama '.info_rekening($x['rekening_asal'])['nama'];
                                else $ket = '';
                                echo "<tr><td>$no</td><td>{$x['waktu']}</td><td>{$x['keterangan']}</td><td>{$x['nominal']}</td><td>$ket</td></tr>";
                                $no++;
                            }
                            ?>
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