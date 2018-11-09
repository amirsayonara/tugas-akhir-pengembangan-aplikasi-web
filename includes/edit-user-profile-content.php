                <!--
                    Konten pengeditan profil di level customer
                    Author: 160411100152 NATIQ HASBI ALIM
                    -->
                <form method="POST">
                    <table>
                        <tr>
                            <td><label for="nama-pengguna">Nama Pengguna</label></td><td><input value="<?=$_POST['nama-pengguna'] ?? pengguna()['nama_pengguna']?>" type="text" name="nama-pengguna" id="nama-pengguna"></td>
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
                            <td><label for="nama">Nama</label></td><td><input value="<?=$_POST['nama'] ?? pengguna()['nama']?>" type="text" name="nama" id="nama"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nama']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="alamat">Alamat</label></td><td><textarea name="alamat" id="alamat"><?=$_POST['alamat'] ?? pengguna()['alamat']?></textarea></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['alamat']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="nomor-hp">Nomor HP</label></td><td><input value="<?=$_POST['nomor-hp'] ?? pengguna()['nomor_hp']?>" type="text" name="nomor-hp" id="nomor-hp"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nomor-hp']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="email">E-mail</label></td><td><input value="<?=$_POST['email'] ?? pengguna()['email']?>" type="text" name="email" id="email"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['email']?></span></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-mini">*) Sandi biarkan kosong jika tidak ingin diubah</span></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Simpan"> <input onclick="location.href='user-management'" type="reset" value="Batal"></td>
                        </tr>
                    </table>
                </form>