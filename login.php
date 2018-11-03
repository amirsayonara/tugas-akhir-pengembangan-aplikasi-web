<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>C07 Internet Banking - Masuk</title>
</head>
<body>
    <header>
        <div class="konten">
            <h1>C07 Net Banking</h1>
            <nav>
                <ul>
                    <li><a href="help">Bantuan</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="konten-utama">
        <div class="kiri">
            <div class="artikel">
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
                            <td><input type="submit" value="Login"> <input type="reset" value="Reset"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="kanan">
            <img src="images/gambar1.jpg" alt="Coba" width="100%">
            <div class="artikel">
                <h2>Informasi</h2>
                <p>Testing</p>
            </div>
        </div>
    </div>
    <footer>
        <div class="konten">
            <div class="artikel">
                <p>C07 Internet Banking - Pengembangan Aplikasi Web (C) - 2018</p>
            </div>
        </div>
    </footer>
</body>
</html>