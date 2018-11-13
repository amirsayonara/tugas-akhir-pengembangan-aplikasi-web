<?php include 'includes/api.php'; require 'includes/sudah-masuk.php' ?>
<!--
    HALAMAN MANAJEMEN PENGGUNA
    AUTHOR: 160411100153 NATIQ HASBI ALIM
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
                    <li class="disini">Manajemen Pengguna</li>
                    <?php } else {?>
                    <li><a href="rek-info">Informasi Rekening</a></li>
                    <li><a href="rek-mutation">Mutasi Rekening</a></li>
                    <li><a href="transfer">Transfer</a></li>
                    <li class="disini">Informasi Pengguna</li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <?php if (pengguna()['jenis_pengguna']==0) {//jika yang login adalah pengguna berlevel admin?>
                <h2>Manajemen Pengguna</h2>
                    <?php switch (@$_GET['action']) {
                        /**
                         * Algoritma pindah action dengan switch variabel action di URL
                         * Author: 160411100153 MOCH. AMIR dibantu 160411100145 ABDUR ROHMAN
                         */
                        case 'delete-user':
                            //validasi jika nama pengguna tidak ada (memasukkan username pengguna di url dan tidak sah) maka didirect ke halaman awal manajemen user
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']) header('Location: user-management');
                            //menghitung banyaknya pengguna bertipe admin
                            $banyak_admin = 0;
                            foreach (list_pengguna() as $x) {
                                if ($x['jenis_pengguna']=='0') $banyak_admin++;
                            }
                            //validasi jika belum ada index 'konfirmasi' di data $_POST
                            if (@$_POST['konfirmasi']) {
                                //validasi jika adminnya tinggal 1, dan yang dihapus adalah admin maka tidak boleh menghapus pengguna ybs
                                if ($banyak_admin < 2 & pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0') {
                                    echo 'Tidak dapat menghapus. Harus terdapat minimal 1 (satu) admin';
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else if (pengguna()['nama_pengguna']==$_GET['nama-pengguna']) {
                                    //validasi jika yang dihapus adalah dirinya sendiri
                                    echo 'Tidak dapat menghapus akun anda sendiri.';
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else {
                                    //validasi jika tidak ada pelanggaran/warning -> berhasil
                                    hapus_pengguna($_GET['nama-pengguna']);
                                    echo "Akun dengan nama pengguna {$_GET['nama-pengguna']} berhasil dihapus.";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                }
                            } else {
                                //pernyataan konfirmasi dan akan menambahkan index 'konfirmasi'=true di data $_POST
                                echo "Akun dengan nama pengguna {$_GET['nama-pengguna']} akan dihapus. Pengguna tidak akan dapat login kembali menggunakan akun tersebut.";
                                if (pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']!=0)
                                    echo ' Semua rekening dan saldo yang dimiliki oleh akun customer tersebut akan non-aktif dan tidak dapat dikembalikan.';
                                echo '<form method="POST"><input type="hidden" value="true" name="konfirmasi"><input type="submit" value="Konfirmasi"> ';
                                echo '<input type="reset" onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'" value="Batal"></form>';
                            }
                        break;
                        case 'add-user-admin':
                            echo '<h3>Tambah Admin</h3>';
                            //validasi jika sudah/belum ada data $_POST
                            if (!empty($_POST)) {
                                add_user_validation(0);
                                if (empty($pesan_error)) {
                                    //validasi jika tidak ada pesan kesalahan
                                    echo "Berhasil menambahkan Admin dengan nama pengguna {$_POST['nama-pengguna']}.";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                } else include 'includes/add-user-admin-content.php'; //jika masih ada kesalahan
                            } else include 'includes/add-user-admin-content.php'; //jika tidak ada data $_POST
                        break;
                        case 'add-user-customer':
                            echo '<h3>Tambah Customer</h3>';
                            //algoritmanya sama dengan tambah admin di atas, cuma diberi penanda 1 di parameter validasi
                            if (!empty($_POST)) {
                                add_user_validation(1);
                                if (empty($pesan_error)) {
                                    echo "Berhasil menambahkan Customer dengan nama {$_POST['nama']}, nomor rekening $tmp, dan setoran awal ".rp($_POST['set-awal']).".";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                } else include 'includes/add-user-customer-content.php';
                            } else include 'includes/add-user-customer-content.php';
                        break;
                        case 'edit-profile':
                            //validasi jika nama pengguna tidak ada (memasukkan username pengguna di url dan tidak sah) maka didirect ke halaman awal manajemen user
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']) header('Location: user-management');
                            echo '<h3>Edit Profil</h3>';
                            //algoritmanya sama dengan tambah customer di atas
                            if (!empty($_POST)) {
                                save_user_management_validation_admin();
                                if (empty($pesan_error)) {
                                    header('Location: user-management?nama-pengguna='.$_POST['nama-pengguna']);
                                } else include 'includes/edit-user-profile-content-admin.php';
                            } else include 'includes/edit-user-profile-content-admin.php';
                        break;
                        case 'delete-bank-account':
                            $ada = false; //algoritma mengecek rekening di URL ada/tidak di pengguna ybs
                            foreach (pengguna_rinci($_GET['nama-pengguna'])['rekening'] as $x)
                                if ($x['nomor_rekening']==$_GET['account-number']) {
                                    $ada = true;
                                    break;
                                }
                            //validasi masukan URL, jika ada yang tidak beres (sengaja dimasukkan manual dan tidak valid) maka akan didirect ke halaman manajemen user awal
                            if (!$ada|pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0'|count(pengguna_rinci($_GET['nama-pengguna'])['rekening'])<2) header('Location: user-management');
                            echo '<h3>Hapus Rekening Customer</h3>';
                            if (@$_POST['konfirmasi']) { //pengecekan konfirmasi di data $_POST, jika sudah ada, berarti fix dihapus
                                hapus_rekening($_GET['account-number']);
                                echo "Nomor rekening {$_GET['account-number']} atas nama ".info_rekening($_GET['account-number'])['nama']." berhasil dihapus.";
                                echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                            } else {
                                //jika belum ada index 'konfirmasi' di data $_POST
                                echo "Nomor rekening {$_GET['account-number']} atas nama ".info_rekening($_GET['account-number'])['nama']." akan dihapus. Saldo saat ini dengan nominal ".rp(info_rekening($_GET['account-number'])['saldo'])." juga nomor rekening tidak dapat dikembalikan.";
                                echo '<form method="POST"><input type="hidden" value="true" name="konfirmasi"><input type="submit" value="Konfirmasi"> ';
                                echo '<input type="reset" onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'" value="Batal"></form>';
                            }
                        break;
                        case 'add-bank-account':
                            echo '<h3>Tambah Rekening Customer</h3>';
                            //validasi jika ada yang tidak beres (sengaja memasukkan url manual dan tidak valid seperti menambah rekening pada pengguna berlevel admin) langsung dikembalikan ke halaman awal
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']|pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0') header('Location: user-management');
                            if (!empty($_POST)) { //algoritma pengecekan data $_POST, jika belum ada
                                add_bank_account_validation();
                                if (empty($pesan_error)) {
                                    echo "Rekening berhasil ditambah dengan nomor $tmp dan setoran awal ".rp($_POST['set-awal']);
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else include 'includes/add-bank-account-content.php'; //jika masih ada error
                            } else include 'includes/add-bank-account-content.php'; //pertama kali di load
                        break;
                        default: ?>
                            <h3>Detail Pengguna</h3>
                            <form>
                                <table>
                                    <tr>
                                        <td><label for="nama-pengguna">Pilih pengguna</label></td>
                                        <td>
                                            <select name="nama-pengguna" id="nama-pengguna">
                                                <option value="-1">---</option>
                                                <?php foreach (list_pengguna() as $x) { 
                                                    $selected = '';
                                                    if ($x['nama_pengguna']==@$_GET['nama-pengguna']) $selected = 'selected';
                                                    echo "<option $selected value=\"{$x['nama_pengguna']}\">{$x['nama']} - {$x['email']}</option>";
                                                }?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td><td><input type="submit" value="Pilih"></td>
                                    </tr>
                                </table>
                            </form>
                            <?php
                            /**
                             * Algoritma pengguna rinci
                             * Author: 160411100142 MOHAMMAD FAISHOL
                             */
                            $pengguna_rinci = pengguna_rinci(@$_GET['nama-pengguna']);
                            if ($pengguna_rinci['pengguna']) { //validasi jika data pengguna rinci ada/valid, maka ditampilkan detailnya di bawah ini
                                echo '<hr><h4>Pengguna</h4>';
                                ?>
                                <table>
                                    <tr>
                                        <td>Nama Pengguna</td><td>: <?=$pengguna_rinci['pengguna']['nama_pengguna']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td><td>: <?=$pengguna_rinci['pengguna']['nama']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td><td>: <?=$pengguna_rinci['pengguna']['alamat']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor HP</td><td>: <?=$pengguna_rinci['pengguna']['nomor_hp']?></td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td><td>: <?=$pengguna_rinci['pengguna']['email']?></td>
                                    </tr>
                                </table>
                                <?php
                                //membuat tombol dengan action ke halaman href di bawah dan auto berdasarkan nama pengguna
                                echo "<button onclick=\"location.href='user-management?action=edit-profile&nama-pengguna={$_GET['nama-pengguna']}'\">Edit Profil Pengguna</button>";
                                if (count($pengguna_rinci['rekening']) > 0) { //jika pengguna memiliki rekening (pastinya customer, bukan admin)
                                    echo '<hr><h4>Rekening</h4><ul>';
                                    foreach ($pengguna_rinci['rekening'] as $x) {
                                        $hapus = '';
                                        //pengecekan jika rekening lebih dari 1, maka akan ada tombol hapus di semua rekening dan mengarah ke action hapus
                                        if (count($pengguna_rinci['rekening']) > 1) $hapus = " - <a href=\"user-management?action=delete-bank-account&account-number={$x['nomor_rekening']}&nama-pengguna={$_GET['nama-pengguna']}\">Hapus</a>";
                                        echo "<li>{$x['nomor_rekening']} - [".rp(info_rekening($x['nomor_rekening'])['saldo'])."]$hapus</li>";
                                    }
                                    echo '</ul>';
                                    //membuat tombol untuk menambah rekening
                                    echo "<button onclick=\"location.href='user-management?action=add-bank-account&nama-pengguna={$_GET['nama-pengguna']}'\">Tambah Tekening</button>";
                                }
                                echo '<hr><h4>Tindakan</h4>';
                                //membuat tombol untuk menghapus pengguna
                                echo "<button onclick=\"location.href='user-management?action=delete-user&nama-pengguna={$_GET['nama-pengguna']}'\">Hapus Pengguna</button><br>";
                            }
                            echo '<hr>';
                            //tombol untuk menambah customer baru
                            echo "<button onclick=\"location.href='user-management?action=add-user-customer'\">Tambah Pengguna Customer</button> ";
                            //tombol untuk menambah admin baru
                            echo "<button onclick=\"location.href='user-management?action=add-user-admin'\">Tambah Pengguna Admin</button>";
                        break;
                    }
                    ?>
                <?php } else { //jika yang login adalah customer (bukan admin), akses yang diberikan hanya mengedit dirinya sendiri
                //algoritmanya sama dengan pengeditan user di level admin, jika selesai akan ditampilkan detail dirinya sendiri
                    //mengecek jika data $_GET ada edit ?edit=true maka dianggap ingin mengedit profil, jika tidak maka ditampilkan profilnya
                echo '<h2>Informasi Pengguna</h2>';
                    if (@$_GET['edit']) { ?>
                    <h3>Edit Akun dan Profil</h3><?php
                        if (!empty($_POST)) { //mengecek data $_POST, jika ada, maka dianggap telah mengedit dan mengisi dan divalidasi untuk disimpan
                            save_user_management_validation();
                            if (!empty($pesan_error)) { 
                                include 'includes/edit-user-profile-content.php';
                            } else {
                                header('Location: user-management');
                            }
                        } else {
                            include 'includes/edit-user-profile-content.php';
                        }
                    } else {?>
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
                    <button onclick="location.href='user-management?edit=true'">Edit Akun dan Profil</button>
                    <?php }
                } ?>
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