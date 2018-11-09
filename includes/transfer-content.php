                <!--
                    Konten transer
                    Author: 160411100145 ABDUR ROHMAN
                    -->
                <form method="POST">
                    <table>
                        <tr>
                            <td><label for="nomor-rekening">Pilih Rekening</label></td>
                            <td>
                                <select name="nomor-rekening" id="nomor-rekening">
                                    <option value="-1">---</option>
                                    <?php
                                    foreach (list_rekening($_SESSION['nama-pengguna']) as $x) {
                                        //menampilkan semua rekening yang dimiliki customer
                                        //mengecek jika rekening saat ini adalah itu, maka diset selected di drop down
                                        if ($x['nomor_rekening']==$_POST['nomor-rekening']) $selected = 'selected';
                                        else $selected = '';
                                        echo "<option $selected value=\"{$x['nomor_rekening']}\">{$x['nomor_rekening']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nomor-rekening']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="nomor-rekening-tujuan">Rekening Tujuan</label></td><td><input value="<?=@$_POST['nomor-rekening-tujuan']?>" type="text" name="nomor-rekening-tujuan" id="nomor-rekening-tujuan"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nomor-rekening-tujuan']?></span></td>
                        </tr>
                        <tr>
                            <td><label for="nominal">Nominal (Rp)</label></td><td><input value="<?=@$_POST['nominal']?>" type="text" name="nominal" id="nominal"></td>
                        </tr>
                        <tr>
                            <td></td><td><span class="pesan-error"><?=@$pesan_error['nominal']?></span></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Transfer"></td>
                        </tr>
                    </table>
                </form>