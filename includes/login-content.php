                <!--
                    Konten login
                    Author: 160411100142 MOHAMMAD FAISHOL
                    Tempat untuk pesan kesalahan sudah disiapkan dan value $_POST akan tampil jika tersedia
                    Pengambilan captcha diambil dari kode php yang headernya diganti img (gambar)
                -->
                <h2>Login</h2>
                <form method="POST">
                    <table>
                        <tr>
                            <td><span class="pesan-error"><?=@$pesan_error['sistem']?></span></td>
                        </tr><tr>
                            <td><input type="text" name="username" id="username" value="<?=@$_POST['username']?>" placeholder="Username"></td>
                        </tr><tr>
                            <td><span class="pesan-error"><?=@$pesan_error['username']?></span></td>
                        </tr><tr>
                            <td><input type="password" name="password" id="password" value="<?=@$_POST['password']?>" placeholder="Password"></td>
                        </tr><tr>
                            <td><span class="pesan-error"><?=@$pesan_error['password']?></span></td>
                        </tr><tr>
                            <td><img src="captcha" alt="captcha"></td>
                        </tr><tr>
                            <td><input type="text" name="captcha" id="captcha" value="<?=@$_POST['captcha']?>" placeholder="Captcha"></td>
                        </tr><tr>
                            <td><span class="pesan-error"><?=@$pesan_error['captcha']?></span></td>
                        </tr><tr>
                            <td><input type="submit" value="Login"> <input type="reset" value="Reset"></td>
                        </tr>
                    </table>
                </form>