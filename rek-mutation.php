<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN MUTASI REKENING
    AUTHOR: 160411100153 MOCH. AMIR
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
                    <li class="disini">Mutasi Rekening</li>
                    <li><a href="transfer">Transfer</a></li>
                    <li><a href="user-management">Informasi Pengguna</a></li>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <h2>Mutasi Rekening</h2>
                <form method="POST">
                    <div class="isian-luar">
                        <div class="isian">
                            <div class="baris">
                                <div class="l-col"><label for="nomor-rekening">Pilih Rekening</label></div>
                                <div class="r-col">
                                    <select name="nomor-rekening" id="nomor-rekening">
                                        <option value="-1">---</option>
                                        <?php
                                        //menampilkan banyaknya rekening yang dimiliki customer di drop down
                                        foreach (list_rekening($_SESSION['nama-pengguna']) as $x) {
                                            $selected = "";
                                            //mengecek jika yang tersorot (diselect saat ini) adalah rekening itu, maka drop down akan menyorot rekening tsb
                                            if ($x['nomor_rekening']==@$_POST['nomor-rekening']) $selected = " selected";
                                            echo "<option$selected value=\"{$x['nomor_rekening']}\">{$x['nomor_rekening']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><input type="submit" value="Kirim"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if (!empty($_POST)) { //jika data $_POST tidak kosong (sudah ada request dan masukan)
                    $mutasi = mutasi(@$_POST['nomor-rekening']); //memanggil fungsi mutasi di api.php
                    if($mutasi) { //jika ada/valid
                        ?><hr>
                        Rekening: <?=$_POST['nomor-rekening']?><br><br>
                        <table>
                            <tr>
                                <th>No</th><th>Waktu</th><th>Jenis Transaksi</th><th>Nominal</th><th>Keterangan</th>
                            </tr>
                            <?php $no = 1; //membuat variabel penomoran di tabel dan ditambah 1 tiap perulangan
                            foreach ($mutasi as $x) { //menampikan semua transaksi yang dilakukan oleh rekening yang dipilih
                                //jika kolom rekening asal adalah miliknya dan rekening tujuan ada isinya, maka itu adalah proses transaksi transfer ke orang lain
                                if ($x['rekening_asal']==$_POST['nomor-rekening'] & $x['rekening_tujuan']!=false) $ket = 'Transfer ke rekening '.$x['rekening_tujuan'].' atas nama '.info_rekening($x['rekening_tujuan'])['nama'];
                                //jika rekening tujuan adalah miliknya, pastilah itu terima transfer dari orang lain
                                else if ($x['rekening_tujuan']==$_POST['nomor-rekening']) $ket = 'Terima transfer dari rekening '.$x['rekening_asal'].' atas nama '.info_rekening($x['rekening_asal'])['nama'];
                                else $ket = ''; //jika tidak keduanya maka keterangan kosong, alias setoran awal
                                echo "<tr><td>$no</td><td>{$x['waktu']}</td><td>{$x['keterangan']}</td><td>".rp($x['nominal'])."</td><td>$ket</td></tr>";
                                $no++; //penambahan nomor tabel
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