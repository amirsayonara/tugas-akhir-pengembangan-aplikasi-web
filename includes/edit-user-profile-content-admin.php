                <!--
                    Konten pengeditan profil di level admin
                    Author: 160411100153 MOCH. AMIR
                    Untuk value awal adalah milik dari data pengguna yang lama
                    Keterangan masing-masing data sudah disiapkan tempat untuk $pesan_error dan $_POST, dan diberikan tanda '@' agar tidak ada error jika variabel tersebut belum tersedia
                    -->
                <form method="POST">
                    <div class="isian-luar">
                        <div class="isian">
                            <div class="baris">
                                <div class="l-col"><label for="nama-pengguna">Nama Pengguna</label></div><div class="r-col"><input value="<?=$_POST['nama-pengguna'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama_pengguna']?>" type="text" name="nama-pengguna" id="nama-pengguna"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nama-pengguna']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="sandi">Sandi</label></div><div class="r-col"><input value="<?=$_POST['sandi'] ?? ''?>" type="password" name="sandi" id="sandi"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['sandi']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="konfirmasi-sandi">Konfirmasi Sandi</label></div><div class="r-col"><input value="<?=$_POST['konfirmasi-sandi'] ?? ''?>" type="password" name="konfirmasi-sandi" id="konfirmasi-sandi"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['konfirmasi-sandi']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nama">Nama</label></div><div class="r-col"><input value="<?=$_POST['nama'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama']?>" type="text" name="nama" id="nama"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nama']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="alamat">Alamat</label></div><div class="r-col"><textarea name="alamat" id="alamat"><?=$_POST['alamat'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['alamat']?></textarea></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['alamat']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nomor-hp">Nomor HP</label></div><div class="r-col"><input value="<?=$_POST['nomor-hp'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nomor_hp']?>" type="text" name="nomor-hp" id="nomor-hp"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nomor-hp']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="email">E-mail</label></div><div class="r-col"><input value="<?=$_POST['email'] ?? pengguna_rinci($_GET['nama-pengguna'])['pengguna']['email']?>" type="text" name="email" id="email"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['email']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-mini">*) Sandi biarkan kosong jika tidak ingin diubah</span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><input type="submit" value="Simpan"> <input onclick="location.href='user-management?nama-pengguna=<?=$_GET['nama-pengguna']?>'" type="reset" value="Batal"></div>
                            </div>
                        </div>
                    </div>
                </form>