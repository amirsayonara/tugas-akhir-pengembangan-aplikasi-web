<?php include 'includes/api.php'; ?>
<!--
    Halaman help/bantuan
    Author: 160411100152 NATIQ HASBI ALIM
    -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/favicon.png">
    <script type="text/javascript" src="js/main.js"></script>
    <title>Seven Bank - Internet Banking - Bantuan</title>
</head>
<body>
    <header>
        <div class="konten">
            <h1><img src="images/logo.png" alt="logo"></h1>
            <nav>
                <ul>
                    <li><a href="home">Beranda</a> |</li>
                    <li><a class="dipilih">Bantuan</a>
                    <?php if (isset($_SESSION['nama-pengguna'])) { //mengecek jika sudah login, maka akan ada menu tambahan 'logout' di paling kanan ?>
                    |</li>
                    <li><a href="logout">Logout</a></li> <?php } else { ?>
                    </li><?php } ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="konten-utama">
        <div class="kiri">
            <div class="artikel">
                <h2>Menu</h2>
                <?php
                /**
                 * Algorima pindah tab dan konten
                 * Author: 160411100153 MOCH. AMIR
                 */

                //inisialisasi awal jika berada di halaman bantuan utama
                $hal_depan = '<li><a href="help">Halaman Depan</a></li>';
                $hal_login = '<li><a href="help?tab=login">Masuk</a></li>';
                $hal_info_rek = '<li><a href="help?tab=rek-info">Informasi Rekening</a></li>';
                $hal_rek_mut = '<li><a href="help?tab=rek-mutation">Mutasi Rekening</a></li>';
                $hal_transfer = '<li><a href="help?tab=transfer">Transfer</a></li>';
                $hal_user_manage = '<li><a href="help?tab=user-management">Manajemen Pengguna</a></li>';
                //jika salah satu menu sebelah kiri dipilih maka akan mengubah class dan menghapus tag <a> pada menu tersebut
                switch(@$_GET['tab']) {
                    default:
                        $hal_depan = '<li class="disini">Halaman Depan</li>';
                    break;
                    case 'login':
                        $hal_login = '<li class="disini">Masuk</li>';
                    break;
                    case 'rek-info':
                        $hal_info_rek = '<li class="disini">Informasi Rekening</li>';
                    break;
                    case 'rek-mutation':
                        $hal_rek_mut = '<li class="disini">Mutasi Rekening</li>';
                    break;
                    case 'transfer':
                        $hal_transfer = '<li class="disini">Transfer</li>';
                    break;
                    case 'user-management':
                        $hal_user_manage = '<li class="disini">Manajemen Pengguna</li>';
                    break;
                }
                echo '<ul>';
                    //menampilkan menu yang telah diubah di atas
                    echo $hal_depan.$hal_login.$hal_info_rek.$hal_rek_mut.$hal_transfer.$hal_user_manage;
                echo '</ul>';
                ?>
            </div>
        </div>
        <div class="kanan">
            <div class="artikel">
                <?php
                switch(@$_GET['tab']) {
                    default:
                    ?>
                    <h2>Bantuan</h2>
                    <p>Selamat datang di bantuan. Silahkan pilih menu sebelah kiri berdasarkan kategori yang ingin anda cari.</p>
                    <?php
                    break;
                    case 'login':
                    ?>
                    <h2>Masuk</h2>
                    <p>Cara masuk</p>
                    <ul>
                        <li>Masukkan Nama Pengguna/Username anda di kolom username berupa huruf atau angka (tanpa spasi)</li>
                        <li>Masukkan Kata Sandi/Password di kolom Password minimal 4 karakter tanpa kombinasi, terserah anda lah masa bodo lah ajg</li>
                        <li>Masukkan kode keamanan dengan benar</li>
                        <li>Klik Login untuk masuk ke akun Internet Banking anda</li>
                    </ul>
                    <?php
                    break;
                    case 'rek-info':
                    ?>
                    <h2>Informasi Rekening</h2>
                    <p>Menu ini akan menampilkan semua rekening anda dan juga saldo yang anda punyai.</p>
                    <ul>
                        <li>Login dengan Nama Pengguna/Username dan Sandi anda</li>
                        <li>Pastikan tab Beranda di menu navigasi bagian atas aktif</li>
                        <li>Klik Informasi Rekening pada menu bagian kiri</li>
                        <li>Tunggu beberapa saat dan akan tampil rekening beserta jumlah saldo anda</li>
                    </ul>
                    <?php
                    break;
                    case 'rek-mutation':
                    ?>
                    <h2>Mutasi Rekening</h2>
                    <p>Menu ini dapat memungkinkan anda untuk melihat daftar transaksi yang anda lakukan pada rekening anda.</p>
                    <ul>
                        <li>Login dengan Nama Pengguna/Username dan Sandi anda</li>
                        <li>Pastikan tab Beranda di menu navigasi bagian atas aktif</li>
                        <li>Klik Mutasi Rekening pada menu bagian kiri</li>
                        <li>Pilih rekening anda, kemudian klik tombol Kirim</li>
                        <li>Anda akan melihat dartar transaksi berupa waktu, jenis, Nominal, dan Keterangan jika ada</li>
                    </ul>
                    <?php
                    break;
                    case 'transfer':
                    ?>
                    <h2>Transfer</h2>
                    <p>Menu ini dapat memungkinkan anda untuk melakukan transfer ke Nomor rekening lainnya.</p>
                    <ul>
                        <li>Login dengan Nama Pengguna/Username dan Sandi anda</li>
                        <li>Pastikan tab Beranda di menu navigasi bagian atas aktif</li>
                        <li>Klik Transfer pada menu bagian kiri</li>
                        <li>Pilih rekening anda</li>
                        <li>Masukkan nomor rekening tujuan</li>
                        <li>Masukkan nominal dalam angka</li>
                        <li>Klik tombol Transfer</li>
                        <li>Jika informasi yang anda masukkan benar, maka akan keluar identitas penerima dan juga jumlah nominal yang anda kirim</li>
                        <li>Pastikan informasi tersebut benar, dan klik Konfirmasi</li>
                    </ul>
                    <?php
                    break;
                    case 'user-management':
                    ?>
                    <h2>Manajemen Pengguna</h2>
                    <p>Menu ini dapat memungkinkan anda untuk melihat dan mengedit Profil anda.</p>
                    <p>Customer:</p>
                    <ul>
                        <li>Login dengan Nama Pengguna/Username dan Sandi anda</li>
                        <li>Pastikan tab Beranda di menu navigasi bagian atas aktif</li>
                        <li>Klik Manajemen Pengguna pada menu bagian kiri</li>
                        <li>Akan terlihat detail profil anda</li>
                        <li>Klik Edit Akun dan Profil jika anda ingin memperbarui informasi Profil Anda</li>
                        <li>Anda akan melihat kolom yang sudah terisi dengan data anda yang lama</li>
                        <li>Gantikan tulisan tersebut dengan informasi anda yang baru</li>
                        <li>Khusus untuk Kata Sandi akan diberikan kolom kosong (biarkan kosong jika anda tidak ingin mengubahnya)</li>
                        <li>Klik tombol Simpan jika sudah selesai</li>
                        <li>Jika informasi yang anda masukan memenuhi kriteria kami, maka anda akan diarahkan ke profil anda kembali dan data akan diperbarui</li>
                    </ul>
                    <p>Admin:</p>
                    <ul>
                        <li>Login dengan Nama Pengguna/Username dan Sandi anda</li>
                        <li>Pastikan tab Beranda di menu navigasi bagian atas aktif</li>
                        <li>Klik Manajemen Pengguna pada menu bagian kiri</li>
                        <li>Anda akan melihat pemilihan pengguna dan 2 tombol di bagian bawah</li>
                        <li>Jika anda ingin memperbarui informasi pengguna (termasuk sesama admin maupun diri anda sendiri), pilih nama pengguna yang sudah ada di Drop Down tersebut kemudian klik tombol Pilih</li>
                        <li>Anda akan melihat detail pengguna, informasi rekening akan ada jika akun tersebut adalah Customer</li>
                        <li>Klik Edit Profil Pengguna jika ingin memperbarui informasi pengguna tersebut</li>
                        <li>Anda akan melihat kolom yang sudah terisi dengan data Pengguna yang lama</li>
                        <li>Gantikan tulisan tersebut dengan informasi Pengguna yang baru</li>
                        <li>Khusus untuk Kata Sandi akan diberikan kolom kosong (biarkan kosong jika tidak ingin diubah)</li>
                        <li>Klik tombol Simpan jika sudah selesai</li>
                        <li>Jika informasi yang dimasukan memenuhi kriteria kami, maka anda akan diarahkan ke profil Pengguna kembali dan data akan diperbarui</li>
                        <li>Anda juga dapat melakukan tambah rekening jika akun tersebut adalah Customer</li>
                        <li>Selain itu, anda juga dapat menghapus akun tersebut</li>
                        <li>Untuk menambah Customer baru, klik tombol Tambah Pengguna Customer di bagian bawah, begitu juga dengan Admin, klik tombol Tambah Pengguna Admin di sebelah kanannya</li>
                        <li>Anda akan melihat isian data yang harus dipenuhi, pastikan terisi dengan benar</li>
                        <li>Jika anda menambahkan Customer, maka akan ada kolom isian tambahan berupa Setoran Awal, isikan data tersebut dengan benar</li>
                        <li>Klik tombol Simpan jika dirasa sudah cukup</li>
                        <li>Jika informasi yang dimasukkan sesuai kriteria kami, maka anda akan diarahkan ke halaman Manajemen Pengguna seperti pada saat anda belum memilih Pengguna di awal, dan data akan disimpan</li>
                        <li>Pastikan data Pengguna tersebut ada dengan mengecek data pengguna di menu Drop Down dan klik tombol Pilih untuk lebih detailnya</li>
                        <li>Jika informasi data Pengguna baru tersebut ada, maka proses penambahan pengguna sudah berhasil</li>
                    </ul>
                    <?php
                    break;
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