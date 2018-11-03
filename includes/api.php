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
    return @$q->fetchAll()[0];
}

function list_rekening($nama_pengguna) {
    global $conn;
    $q = $conn->prepare("SELECT * FROM rekening WHERE id_pengguna=(SELECT id_pengguna FROM akun_pengguna WHERE nama_pengguna='$nama_pengguna')");
    $q->execute();
    return @$q->fetchAll();
}

function saldo($nomor_rekening) {
    global $conn;
    $q = $conn->prepare("SELECT IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='0'), 0) + IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_tujuan=r.nomor_rekening AND jenis_transaksi='1'), 0) - IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='1'), 0)'saldo' FROM rekening r WHERE r.nomor_rekening='$nomor_rekening'");
    $q->execute();
    return @$q->fetchAll()[0][0];
}

function mutasi($nomor_rekening) {
    global $conn;
    $q = $conn->prepare("SELECT * FROM transaksi t JOIN jenis_transaksi j ON j.id=t.jenis_transaksi WHERE t.rekening_asal='$nomor_rekening' or t.rekening_tujuan='$nomor_rekening'");
    $q->execute();
    return @$q->fetchAll();
}

?>