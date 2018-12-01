<?php include 'includes/api.php'; require 'includes/sudah-masuk-customer.php' ?>
<!--
    HALAMAN MUTASI REKENING
    AUTHOR: 160411100153 MOCH. AMIR
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
                        <table class="tabel-khusus">
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
                                if ($no%2==0) $w = ' class="warna-baris"';
                                else $w = "";
                                echo "<tr$w><td>$no</td><td>{$x['waktu']}</td><td>{$x['keterangan']}</td><td>".rp($x['nominal'])."</td><td>$ket</td></tr>";
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