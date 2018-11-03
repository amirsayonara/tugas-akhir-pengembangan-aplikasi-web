<?php

session_start();
$conn = new PDO('mysql:host=localhost;dbname=banking', 'root', '');
$pesan_error = array();

function login_validation() {
    try {
        global $conn;
        global $pesan_error;
        $username = @$_POST['username'];
        $password = @$_POST['password'];
        $q = $conn->prepare("SELECT * FROM akun_pengguna WHERE nama_pengguna=:username");
        $q->bindValue(':username', $username);
        $q->execute();
        if ($q->rowCount() > 0) {
            $q = $conn->prepare("SELECT * FROM akun_pengguna WHERE nama_pengguna=:username AND sandi=SHA2(:password, 0)");
            $q->bindValue(':username', $username);
            $q->bindValue(':password', $password);
            $q->execute();
            if ($q->rowCount() > 0) {
                $_SESSION['nama-pengguna'] = $q->fetchAll()[0]['nama_pengguna'];
                header('Location: ./');
            } else $pesan_error['password'] = 'Password salah';
        } else $pesan_error['username'] = 'Username tidak terdaftar';
    } catch (Exception $e) {
        $pesan_error['sistem']='Database bermasalah';
    }
}

function pengguna() {
    global $conn;
    $q = $conn->prepare("SELECT * FROM akun_pengguna a JOIN jenis_pengguna j ON a.jenis_pengguna=j.id JOIN pengguna p ON a.id_pengguna=p.id WHERE a.nama_pengguna='{$_SESSION['nama-pengguna']}'");
    $q->execute();
    return $q->fetchAll()[0];
}

?>