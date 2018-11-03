                <form method="POST">
                    <table>
                        <tr>
                            <td><label for="nama-pengguna">Nama Pengguna</label></td><td><input value="<?=pengguna()['nama_pengguna']?>" type="text" name="nama-pengguna" id="nama-pengguna"></td>
                        </tr>
                        <tr>
                            <td><label for="sandi">Sandi</label></td><td><input type="password" name="sandi" id="sandi"></td>
                        </tr>
                        <tr>
                            <td><label for="konfirmasi-sandi">Konfirmasi Sandi</label></td><td><input type="password" name="konfirmasi-sandi" id="konfirmasi-sandi"></td>
                        </tr>
                        <tr>
                            <td><label for="nama">Nama</label></td><td><input value="<?=pengguna()['nama']?>" type="text" name="nama" id="nama"></td>
                        </tr>
                        <tr>
                            <td><label for="alamat">Alamat</label></td><td><textarea type="text" name="alamat" id="alamat"><?=pengguna()['alamat']?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="nomor-hp">Nomor HP</label></td><td><input value="<?=pengguna()['nomor_hp']?>" type="text" name="nomor-hp" id="nomor-hp"></td>
                        </tr>
                        <tr>
                            <td><label for="email">E-mail</label></td><td><input value="<?=pengguna()['email']?>" type="text" name="email" id="email"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-mini">*) Sandi biarkan kosong jika tidak ingin diubah</span></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Simpan"> <input onclick="location.href='user-management'" type="reset" value="Batal"></td>
                        </tr>
                    </table>
                </form>