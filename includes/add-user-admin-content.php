                <!--
                    Konten penambahan admin
                    Author: 160411100145 ABDUR ROHMAN
                    Keterangan untuk $pesan_error dan $_POST yang sudah disiapkan di bawah diberi tanda @ agar tidak error jika variabel tersebut belum tersedia.
                    Jika sudah tersedia, maka akan otomatis mengambil nilai dari variabel tersebut.
                    -->
                <form method="POST">
                    <div class="isian-luar">
                        <div class="isian">
                            <div class="baris">
                                <div class="l-col"><label for="nama-pengguna">Nama Pengguna</label></div><div class="r-col"><input value="<?=@$_POST['nama-pengguna']?>" type="text" name="nama-pengguna" id="nama-pengguna"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nama-pengguna']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="sandi">Sandi</label></div><div class="r-col"><input value="<?=@$_POST['sandi'] ?? ''?>" type="password" name="sandi" id="sandi"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['sandi']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="konfirmasi-sandi">Konfirmasi Sandi</label></div><div class="r-col"><input value="<?=@$_POST['konfirmasi-sandi'] ?? ''?>" type="password" name="konfirmasi-sandi" id="konfirmasi-sandi"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['konfirmasi-sandi']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nama">Nama</label></div><div class="r-col"><input value="<?=@$_POST['nama']?>" type="text" name="nama" id="nama"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nama']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="alamat">Alamat</label></div><div class="r-col"><textarea name="alamat" id="alamat"><?=@$_POST['alamat']?></textarea></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['alamat']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nomor-hp">Nomor HP</label></div><div class="r-col"><input value="<?=@$_POST['nomor-hp']?>" type="text" name="nomor-hp" id="nomor-hp"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nomor-hp']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="email">E-mail</label></div><div class="r-col"><input value="<?=@$_POST['email']?>" type="text" name="email" id="email"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['email']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><input type="submit" value="Simpan"> <input onclick="location.href='user-management'" type="reset" value="Batal"></div>
                            </div>
                        </div>
                    </div>
                </form>