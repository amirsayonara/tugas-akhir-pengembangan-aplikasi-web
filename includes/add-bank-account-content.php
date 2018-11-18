                            <!--
                                Konten penambahan rekening baru
                                Author: 160411100142 MOHAMMAD FAISHOL
                                -->
                            <form method="POST">
                                <div class="isian-luar">
                                    <div class="isian">
                                        <div class="baris">
                                            <div class="l-col"><label for="set-awal">Setoran Awal</label></div><div class="r-col"><input type="text" value="<?=@$_POST['set-awal']?>" name="set-awal" id="set-awal"></div>
                                        </div>
                                        <div class="baris">
                                            <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['set-awal']?></span></div>
                                        </div>
                                        <div class="baris">
                                            <div class="l-col"></div><div class="r-col"><input type="submit" value="Tambah"> <input type="reset" value="Batal" onclick="location.href='user-management?nama-pengguna=<?=$_GET['nama-pengguna']?>'"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>