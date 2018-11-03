<?php

session_start();
$conn = new PDO('mysql:host=localhost;dbname=banking', 'root', '');
$pesan_error = array();

function validasi_masukan_wajib(&$pesan_error, $name) {
    if (@$_POST[$name]=='') $pesan_error[$name] = 'Harus diisi';
}

function login_validation() {
    $username = @$_POST['username'];
    $password = @$_POST['password'];
    global $pesan_error;
    validasi_masukan_wajib($pesan_error, 'username');
    validasi_masukan_wajib($pesan_error, 'password');
    if (!empty($pesan_error)) return;
    try {
        global $conn;
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

function info_rekening($nomor_rekening) {
    global $conn;
    $q = $conn->prepare("SELECT *, IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='0'), 0) + IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_tujuan=r.nomor_rekening AND jenis_transaksi='1'), 0) - IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='1'), 0)'saldo' FROM rekening r JOIN pengguna p ON r.id_pengguna=p.id WHERE r.nomor_rekening='$nomor_rekening'");
    $q->execute();
    return @$q->fetchAll()[0];
}

function mutasi($nomor_rekening) {
    global $conn;
    $q = $conn->prepare("SELECT * FROM transaksi t JOIN jenis_transaksi j ON j.id=t.jenis_transaksi WHERE t.rekening_asal='$nomor_rekening' or t.rekening_tujuan='$nomor_rekening' ORDER BY t.waktu");
    $q->execute();
    return @$q->fetchAll();
}

function validasi_masukan_numerik(&$pesan_error, $name) {
    $pattern = "/^[0-9]+$/";
    if (@$_POST[$name]!='' & !preg_match($pattern, @$_POST[$name])) $pesan_error[$name] = 'Hanya boleh memasukkan angka';
}

function generate_id($tabel, $kolom) {
    $val = 'ABCDEF0123456789';
    global $conn;
    $sudah_ada = true;
    while ($sudah_ada) {
        $re = '';
        for ($x=0; $x<23; $x++) {
            if (($x+1)%6==0) $re .= '-';
            else $re .= $val[random_int(0, strlen($val)-1)];
        }
        $q = $conn->prepare("SELECT * FROM $tabel where $kolom='$re'");
        $q->execute();
        @$sudah_ada = $q->fetchAll();
    }
    return $re;
}

function transfer_validation() {
    global $pesan_error;
    $cek_saldo = info_rekening($_POST['nomor-rekening'])['saldo'];
    if ($cek_saldo==false) $pesan_error['nomor-rekening'] = 'Anda belum memilih rekening';
    global $conn;
    $q = $conn->prepare("SELECT * FROM rekening WHERE nomor_rekening='{$_POST['nomor-rekening-tujuan']}'");
    $q->execute();
    @$tmp = $q->fetchAll();
    if ($tmp) {
        if ($tmp[0]['id_pengguna']==pengguna()['id_pengguna']) $pesan_error['nomor-rekening-tujuan'] = 'Tidak dapat transfer ke rekening anda sendiri';
    } else $pesan_error['nomor-rekening-tujuan'] = 'Nomor rekening tidak valid';
    validasi_masukan_numerik($pesan_error, 'nominal');
    validasi_masukan_wajib($pesan_error, 'nominal');
    if (!isset($pesan_error['nominal']) & !isset($pesan_error['nomor-rekening'])) {
        if ($cek_saldo-$_POST['nominal'] < 0) $pesan_error['nominal'] = 'Saldo tidak cukup';
    }
    validasi_masukan_wajib($pesan_error, 'nomor-rekening-tujuan');
    if (!empty($pesan_error)) return;
    if (!isset($_POST['konfirmasi-transfer'])) return;
    $id = generate_id('transaksi', 'id');
    $q = $conn->prepare("INSERT INTO transaksi VALUES ('$id', CURRENT_TIMESTAMP, '1', '{$_POST['nomor-rekening']}', '{$_POST['nomor-rekening-tujuan']}', '{$_POST['nominal']}')");
    $q->execute();
}

?>