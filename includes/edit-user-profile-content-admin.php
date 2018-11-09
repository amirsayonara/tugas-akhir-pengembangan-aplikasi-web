                <!--
                    Konten pengeditan profil di level admin
                    Author: 160411100153 MOCH. AMIR
                    Untuk value awal adalah milik dari data pengguna yang lama
                    Keterangan masing-masing data sudah disiapkan tempat untuk $pesan_error dan $_POST, dan diberikan tanda '@' agar tidak ada error jika variabel tersebut belum tersedia
                    -->
                <form method="POST">
                    <table>
                        <tr>
                            <td><label for="nama-pengguna">Nama Pengguna</label></td><td><input value="<?=$_POST['nama-pengguna'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama_pengguna']?>" type="text" name="nama-pengguna" id="nama-pengguna"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nama-pengguna']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="sandi">Sandi</label></td><td><input value="<?=$_POST['sandi'] ?? ''?>" type="password" name="sandi" id="sandi"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['sandi']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="konfirmasi-sandi">Konfirmasi Sandi</label></td><td><input value="<?=$_POST['konfirmasi-sandi'] ?? ''?>" type="password" name="konfirmasi-sandi" id="konfirmasi-sandi"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['konfirmasi-sandi']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="nama">Nama</label></td><td><input value="<?=$_POST['nama'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama']?>" type="text" name="nama" id="nama"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nama']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="alamat">Alamat</label></td><td><textarea name="alamat" id="alamat"><?=$_POST['alamat'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['alamat']?></textarea></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['alamat']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="nomor-hp">Nomor HP</label></td><td><input value="<?=$_POST['nomor-hp'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nomor_hp']?>" type="text" name="nomor-hp" id="nomor-hp"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nomor-hp']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="email">E-mail</label></td><td><input value="<?=$_POST['email'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['email']?>" type="text" name="email" id="email"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['email']?></span></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-mini">*) Sandi biarkan kosong jika tidak ingin diubah</span></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Simpan"> <input onclick="location.href='user-management?nama-pengguna=<?=$_GET['nama-pengguna']?>'" type="reset" value="Batal"></td>
                        </tr>
                    </table>
                </form>