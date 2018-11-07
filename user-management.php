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
                <?php if (pengguna()['jenis_pengguna']==0) {?>
                    <?php switch (@$_GET['action']) {
                        case 'delete-user':
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']) header('Location: user-management');
                            $banyak_admin = 0;
                            foreach (list_pengguna() as $x) {
                                if ($x['jenis_pengguna']=='0') $banyak_admin++;
                            }
                            if (@$_POST['konfirmasi']) {
                                if ($banyak_admin < 2 & pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0') {
                                    echo 'Tidak dapat menghapus. Harus terdapat minimal 1 (satu) admin';
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else if (pengguna()['nama_pengguna']==$_GET['nama-pengguna']) {
                                    echo 'Tidak dapat menghapus akun anda sendiri.';
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else {
                                    hapus_pengguna($_GET['nama-pengguna']);
                                    echo "Akun dengan nama pengguna {$_GET['nama-pengguna']} berhasil dihapus.";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                }
                            } else {
                                echo "Akun dengan nama pengguna {$_GET['nama-pengguna']} akan dihapus. Pengguna tidak akan dapat login kembali menggunakan akun tersebut.";
                                if (pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']!=0)
                                    echo ' Semua rekening dan saldo yang dimiliki oleh akun customer tersebut akan non-aktif dan tidak dapat dikembalikan.';
                                echo '<form method="POST"><input type="hidden" value="true" name="konfirmasi"><input type="submit" value="Konfirmasi">';
                                echo '<input type="reset" onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'" value="Batal"></form>';
                            }
                        break;
                        case 'add-user-admin':
                            echo '<h3>Tambah Admin</h3>';
                            if (!empty($_POST)) {
                                add_user_validation(0);
                                if (empty($pesan_error)) {
                                    echo "Berhasil menambahkan Admin dengan nama pengguna {$_POST['nama-pengguna']}.";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                } else include 'includes/add-user-admin-content.php';
                            } else include 'includes/add-user-admin-content.php';
                        break;
                        case 'add-user-customer':
                            echo '<h3>Tambah Customer</h3>';
                            if (!empty($_POST)) {
                                add_user_validation(1);
                                if (empty($pesan_error)) {
                                    echo "Berhasil menambahkan Customer dengan nama {$_POST['nama']}, nomor rekening $tmp, dan setoran awal ".rp($_POST['set-awal']).".";
                                    echo '<br><button onclick="location.href=\'user-management\'">Kembali</button>';
                                } else include 'includes/add-user-customer-content.php';
                            } else include 'includes/add-user-customer-content.php';
                        break;
                        case 'edit-profile':
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']) header('Location: user-management');
                            echo '<h3>Edit Profil</h3>';
                            if (!empty($_POST)) {
                                save_user_management_validation_admin();
                                if (empty($pesan_error)) {
                                    header('Location: user-management?nama-pengguna='.$_POST['nama-pengguna']);
                                } else include 'includes/edit-user-profile-content-admin.php';
                            } else include 'includes/edit-user-profile-content-admin.php';
                        break;
                        case 'delete-bank-account':
                            $ada = false;
                            foreach (pengguna_rinci($_GET['nama-pengguna'])['rekening'] as $x)
                                if ($x['nomor_rekening']==$_GET['account-number']) {
                                    $ada = true;
                                    break;}
                            if (!$ada|pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0'|count(pengguna_rinci($_GET['nama-pengguna'])['rekening'])<2) header('Location: user-management');
                            echo '<h3>Hapus Rekening Customer</h3>';
                            if (@$_POST['konfirmasi']) {
                                hapus_rekening($_GET['account-number']);
                                echo "Nomor rekening {$_GET['account-number']} atas nama ".info_rekening($_GET['account-number'])['nama']." berhasil dihapus.";
                                echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                            } else {
                                echo "Nomor rekening {$_GET['account-number']} atas nama ".info_rekening($_GET['account-number'])['nama']." akan dihapus. Saldo saat ini dengan nominal ".rp(info_rekening($_GET['account-number'])['saldo'])." juga nomor rekening tidak dapat dikembalikan.";
                                echo '<form method="POST"><input type="hidden" value="true" name="konfirmasi"><input type="submit" value="Konfirmasi">';
                                echo '<input type="reset" onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'" value="Batal"></form>';
                            }
                        break;
                        case 'add-bank-account':
                            echo '<h3>Tambah Rekening Customer</h3>';
                            if (!pengguna_rinci($_GET['nama-pengguna'])['pengguna']|pengguna_rinci($_GET['nama-pengguna'])['pengguna']['jenis_pengguna']=='0') header('Location: user-management');
                            if (!empty($_POST)) {
                                add_bank_account_validation();
                                if (empty($pesan_error)) {
                                    echo "Rekening berhasil ditambah dengan nomor $tmp dan setoran awal ".rp($_POST['set-awal']);
                                    echo '<br><button onclick="location.href=\'user-management?nama-pengguna='.$_GET['nama-pengguna'].'\'">Kembali</button>';
                                } else include 'includes/add-bank-account-content.php';
                            } else include 'includes/add-bank-account-content.php';
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
                            $pengguna_rinci = pengguna_rinci(@$_GET['nama-pengguna']);
                            if ($pengguna_rinci['pengguna']) {
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
                                echo "<button onclick=\"location.href='user-management?action=edit-profile&nama-pengguna={$_GET['nama-pengguna']}'\">Edit Profil Pengguna</button>";
                                if (count($pengguna_rinci['rekening']) > 0) {
                                    echo '<hr><h4>Rekening</h4><ul>';
                                    foreach ($pengguna_rinci['rekening'] as $x) {
                                        $hapus = '';
                                        if (count($pengguna_rinci['rekening']) > 1) $hapus = " - <a href=\"user-management?action=delete-bank-account&account-number={$x['nomor_rekening']}&nama-pengguna={$_GET['nama-pengguna']}\">Hapus</a>";
                                        echo "<li>{$x['nomor_rekening']} - [".rp(info_rekening($x['nomor_rekening'])['saldo'])."]$hapus</li>";
                                    }
                                    echo '</ul>';
                                    echo "<button onclick=\"location.href='user-management?action=add-bank-account&nama-pengguna={$_GET['nama-pengguna']}'\">Tambah Tekening</button>";
                                }
                                echo '<hr><h4>Tindakan</h4>';
                                echo "<button onclick=\"location.href='user-management?action=delete-user&nama-pengguna={$_GET['nama-pengguna']}'\">Hapus Pengguna</button><br>";
                            }
                            echo '<hr>';
                            echo "<button onclick=\"location.href='user-management?action=add-user-customer'\">Tambah Pengguna Customer</button>";
                            echo "<button onclick=\"location.href='user-management?action=add-user-admin'\">Tambah Pengguna Admin</button>";
                        break;
                    }
                    ?>
                <?php } else {
                    if (@$_GET['edit']) {?>
                    <h3>Edit Akun dan Profil</h3><?php
                        if (!empty($_POST)) {
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