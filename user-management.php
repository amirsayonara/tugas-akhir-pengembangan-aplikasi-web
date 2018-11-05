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
                                echo "<button onclick=\"location.href='user-management?action=edit-profile&id={$_GET['nama-pengguna']}'\">Edit Profil Pengguna</button>";
                                if (count($pengguna_rinci['rekening']) > 0) {
                                    echo '<hr><h4>Rekening</h4><ul>';
                                    foreach ($pengguna_rinci['rekening'] as $x) {
                                        $hapus = '';
                                        if (count($pengguna_rinci['rekening']) > 1) $hapus = " - <a href=\"user-management?action=delete-bank-account&account-number={$x['nomor_rekening']}\">Hapus</a>";
                                        echo "<li>{$x['nomor_rekening']} - [Rp ".info_rekening($x['nomor_rekening'])['saldo']."]$hapus</li>";
                                    }
                                    echo '</ul>';
                                    echo "<button onclick=\"location.href='user-management?action=add-bank-account&id={$_GET['nama-pengguna']}'\">Tambah Tekening</button>";
                                }
                                echo '<hr><h4>Tindakan</h4>';
                                echo "<button onclick=\"location.href='user-management?action=delete-user&id={$_GET['nama-pengguna']}'\">Hapus Pengguna</button><br>";
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
                                include 'includes/edit-user-profile-content-error.php';
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