                <!--
                    Konten login
                    Author: 160411100142 MOHAMMAD FAISHOL
                    Tempat untuk pesan kesalahan sudah disiapkan dan value $_POST akan tampil jika tersedia
                    Pengambilan captcha diambil dari kode php yang headernya diganti img (gambar)
                -->
                <h2>Login</h2>
                <div class="form-login">
                    <form method="POST">
                        <span class="pesan-error"><?=@$pesan_error['sistem']?></span>
                        <input type="text" name="username" id="username" value="<?=@$_POST['username']?>" placeholder="Username">
                        <span class="pesan-error"><?=@$pesan_error['username']?></span>
                        <input type="password" name="password" id="password" value="<?=@$_POST['password']?>" placeholder="Password">  
                        <span class="pesan-error"><?=@$pesan_error['password']?></span><br>
                        <img class="captcha" src="captcha" alt="captcha">
                        <input type="text" name="captcha" id="captcha" value="<?=@$_POST['captcha']?>" placeholder="Captcha">
                        <span class="pesan-error"><?=@$pesan_error['captcha']?></span><br>
                        <input type="submit" value="Login"> <input type="reset" value="Reset">
                    </form>
                </div>