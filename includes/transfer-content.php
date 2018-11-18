                <!--
                    Konten transer
                    Author: 160411100145 ABDUR ROHMAN
                    -->
                <form method="POST">
                    <div class="isian-luar">
                        <div class="isian">
                            <div class="baris">
                                <div class="l-col"><label for="nomor-rekening">Pilih Rekening</label></div>
                                <div class="r-col">
                                    <select name="nomor-rekening" id="nomor-rekening">
                                        <option value="-1">---</option>
                                        <?php
                                        foreach (list_rekening($_SESSION['nama-pengguna']) as $x) {
                                            //menampilkan semua rekening yang dimiliki customer
                                            //mengecek jika rekening saat ini adalah itu, maka diset selected di drop down
                                            if ($x['nomor_rekening']==@$_POST['nomor-rekening']) $selected = 'selected';
                                            else $selected = '';
                                            echo "<option $selected value=\"{$x['nomor_rekening']}\">{$x['nomor_rekening']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nomor-rekening']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nomor-rekening-tujuan">Rekening Tujuan</label></div><div class=""><input value="<?=@$_POST['nomor-rekening-tujuan']?>" type="text" name="nomor-rekening-tujuan" id="nomor-rekening-tujuan"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nomor-rekening-tujuan']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"><label for="nominal">Nominal (Rp)</label></div><div class="r-col"><input value="<?=@$_POST['nominal']?>" type="text" name="nominal" id="nominal"></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><span class="pesan-error"><?=@$pesan_error['nominal']?></span></div>
                            </div>
                            <div class="baris">
                                <div class="l-col"></div><div class="r-col"><input type="submit" value="Transfer"></div>
                            </div>
                        </div>
                    </div>
                </form>