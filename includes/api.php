<?php
/**
 * API
 * Tempat segala fungsi dan hal-hal lainnya seperti pemanggilan query dan koneksi database
 * Author: Kelompok
 */
session_start(); //mengaktifkan sesi
$conn = new PDO('mysql:host=localhost;dbname=banking', 'root', ''); //membuat koneksi dipasang di variabel global
$pesan_error = array(); //membuat variabel global untuk pesan error validasi

//fungsi masukan wajib oleh 160411100145 ABDUR ROHMAN
//parameter name di html dan pengambilan global variabel $pesan_error
function validasi_masukan_wajib(&$pesan_error, $name) {
    //mengecek jika data post di variabel tersebut tidak ada isinya, maka pesan error di valriabel tersebut akan diset harus diisi
    //agar dapat tampil di html yang sudah disiapkan
    if (@$_POST[$name]=='') $pesan_error[$name] = 'Harus diisi';
}

//valiasi login oleh 160411100153 MOCH. AMIR
function login_validation() {
    //pengambilan value dari data $_POST
    $username = @$_POST['username'];
    $password = @$_POST['password'];
    $captcha = @$_POST['captcha'];
    global $pesan_error; //memanggil global variabel $pesan_error
    //memanggil fungsi validasi wajib dengan name username di html
    validasi_masukan_wajib($pesan_error, 'username');
    //sama dengan di atas, tetapi ini untuk password
    validasi_masukan_wajib($pesan_error, 'password');
    //memcocokkan captcha di data $_POST (masukan user) dengan di $_SESSION (dari gambar captcha)
    //jika tidak cocok, maka menambah pesan error untuk captcha
    if ($_SESSION['captcha']!=$captcha) $pesan_error['captcha'] = 'Kode captcha salah';
    validasi_masukan_wajib($pesan_error, 'captcha'); //memanggil masukan wajib untuk captcha
    if (!empty($pesan_error)) return; //jika masih ada pesan error maka sampai disini, tidak dilanjutkan ke bawah (jika di dalam fungsi memanggil return, maka baris selanjutnya tidak akan dieksekusi)
    try { //try untuk error handling
        global $conn; //memanggil variabel global $conn yaitu koneksi ke databse di atas
        //mencari data username berdasarkan inputan user di database
        $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='$username' AND aktif='1'");
        $q->execute();
        //mengecek username tersebut ada/tidak (jika ada, akan ada data setidaknya 1)
        if ($q->rowCount() > 0) { //jika ada, maka dilanjutkan dengan password
            $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='$username' AND sandi=SHA2('$password', 0) AND aktif='1'");
            $q->execute();
            //jika tetap ada setidaknya 1, maka sudah dianggap valid, dan memang benar-benar user yang bersangkutan yang login
            if ($q->rowCount() > 0) {
                //menyimpan data login berupa nama username ke dalam sesi, agar terdeteksi sudah login
                $_SESSION['nama-pengguna'] = $q->fetchAll()[0]['nama_pengguna'];
                header('Location: ./'); //mendirect ke halaman awal
            } else $pesan_error['password'] = 'Password salah'; //jika setelah diselect dengan password ternyata kosong, sudah dipastikan passwordnya salah
        } else $pesan_error['username'] = 'Username tidak terdaftar'; //kalau diselect username saja tidak ada data, maka sudah dipastikan username itu tidak ada
    } catch (Exception $e) {
        //error handling jika tidak dapat melakukan proses di atas, sudah dipastika databasenya yang bermasalah
        $pesan_error['sistem']='Database bermasalah';
    }
}

//fungsi pengguna oleh 160411100142 MOHAMMAH FAISHOL
//untuk menampilkan detail pengguna yang login saat ini
function pengguna() {
    global $conn; //memanggil variabel global koneksi
    //select di database berdasarkan nama pengguna yang tercatat di sesi dan dijoinkan dengan tabel jenis pengguna untuk keterangan yang login admin atukah customer
    $q = $conn->prepare("SELECT * FROM pengguna p JOIN jenis_pengguna j ON p.jenis_pengguna=j.id WHERE p.nama_pengguna='{$_SESSION['nama-pengguna']}'");
    $q->execute();
    return @$q->fetchAll()[0]; //direrurn berupa array, ditambah @ akan mereturn false jika data tidak ada
}

//fungsi list rekening oleh 160411100152 NATIQ HASBI ALIM
//menampilkan semua rekening dari pengguna masukan
function list_rekening($nama_pengguna) {
    global $conn; //memanggil koneksi di global
    //melakukan select di rekening berdasarkan nama pengguna yang dimasukkan
    $q = $conn->prepare("SELECT * FROM rekening WHERE nama_pengguna='$nama_pengguna' AND aktif='1'");
    $q->execute();
    return @$q->fetchAll(); //direturn datanya, dan akan false jika tidak ada
}

//fungsi informasi rekening oleh 160411100153 MOCH. AMIR
function info_rekening($nomor_rekening) {
    global $conn; //memanggil global variabel koneksi
    //melakukan select di tabel rekening dan dijoin dengan nama pemilik rekening tersebut berdasarkan nama-pengguna yang dimiliki rekening
    //saldo diperoleh dari tabel transaksi dengan rumus (total pemasukan)-(total pengeluaran) sbb:
    //pemasukan = saldo awal (kode 0) dan ditrasferi orang (kode 1 dengan nomor tujuan si rekening tersebut)
    //pengeluaran = melakukan transfer ke orang lain (kode 1 dengan rekening asal si rekening tersebut)
    $q = $conn->prepare("SELECT *, IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='0'), 0) + IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_tujuan=r.nomor_rekening AND jenis_transaksi='1'), 0) - IFNULL((SELECT SUM(nominal) FROM transaksi WHERE rekening_asal=r.nomor_rekening AND jenis_transaksi='1'), 0)'saldo' FROM rekening r JOIN pengguna p ON r.nama_pengguna=p.nama_pengguna WHERE r.nomor_rekening='$nomor_rekening'");
    $q->execute();
    return @$q->fetchAll()[0]; //return array 1 dimensi dari hasil tersebut/false jika tidak ada
}

//fungsi mutasi oleh 160411100152 NATIQ HASBI ALIM
function mutasi($nomor_rekening) {
    global $conn; //memanggil koneksi di global
    //melakukan select pada transaksi yang nomor tujuan atau rekening asal adalah rekening bersangkutan
    //kemudian di joun dengan jenis transaksi sebagai keterangannya
    $q = $conn->prepare("SELECT * FROM transaksi t JOIN jenis_transaksi j ON j.id=t.jenis_transaksi WHERE t.rekening_asal='$nomor_rekening' or t.rekening_tujuan='$nomor_rekening' ORDER BY t.waktu");
    $q->execute();
    return @$q->fetchAll(); //direturn array nya, akan bernilai false jika tidak ada data
}

//validasi numerik oleh 160411100142 MOHAMMAD FAISHOL
function validasi_masukan_numerik(&$pesan_error, $name) {
    $pattern = "/^[0-9]+$/"; //pattern angka 0-9, selain dari itu false
    //dicek jika masukan kosong atau tidak valid menurut pattern maka dipastikan masukan salah
    if (@$_POST[$name]!='' & !preg_match($pattern, @$_POST[$name])) $pesan_error[$name] = 'Hanya boleh memasukkan angka';
}

//fungsi generate id berformat #####-#####-#####-##### berdasarkan tabel dan kolom di databse
//oleh 160411100153 MOCH. AMIR
//berfungsi untuk melakukan generate clean id dan rapi
function generate_id($tabel, $kolom) {
    $val = 'ABCDEF0123456789'; //value yang akan di random antara string tersebut
    global $conn; //memanggil koneksi di global
    $sudah_ada = true; //mengasumsikan id tersebut sudah ada di dalam tabel
    while ($sudah_ada) { //selama id tersebut ada (antisipasi jika id yang random tersebut memang sudah ada di tabel, tetapi kemungkinannya kecil sekali)
        $re = ''; //variabel string kosong untuk menampung
        for ($x=0; $x<23; $x++) { //melakukan perulangan sebanyak 23 kali 
            if (($x+1)%6==0) $re .= '-'; //jika kelipatan 6 maka dipastikan pada saat itu adalah pemisah
            else $re .= $val[random_int(0, strlen($val)-1)]; //jika tidak maka akan merandom pilihan val di atas (dengan cara merandom index tersebut dengan angka 0-panjang val di atas)
        }
        $q = $conn->prepare("SELECT * FROM $tabel where $kolom='$re'"); //melakukan select di tabel dengan kolom yang bersangkutan
        $q->execute();
        @$sudah_ada = $q->fetchAll(); //memperbarui asumsi sudah ada tersebut dengan hasil select tadi, jika bernilai false, maka dipastikan di tabel tersebut memang tidak ada data random itu
        //jika sudah ada, makan bernilai true yang mengakibatkan looping berulang lagi, dan mengacak lagi
    }
    return $re; //mereturn hasil
}

//validasi transfer oleh 160411100152 NATIQ HASBI ALIM
function transfer_validation() {
    global $pesan_error; //memanggil global variabel penampungan pesan error
    $cek_saldo = info_rekening($_POST['nomor-rekening'])['saldo']; //mengecek saldo dengan memanggil fungsi info rekening dan diambil index saldo
    //jika ternyata berniai false, dipastikan rekening tidak valid, atau dianggap belum memilih
    if ($cek_saldo==false) $pesan_error['nomor-rekening'] = 'Anda belum memilih rekening';
    global $conn;//memanggil koneksi di global
    //melakukan select di tabel rekening berdasarkan rekening tujuan
    $q = $conn->prepare("SELECT * FROM rekening WHERE nomor_rekening='{$_POST['nomor-rekening-tujuan']}' AND aktif='1'");
    $q->execute();
    @$tmp = $q->fetchAll();
    if ($tmp) { //mengecek jika tmp bernilai true/ada datanya
        //validasi jika melakukan transfer ke nomor rekeningnya sendiri
        if ($tmp[0]['nama_pengguna']==pengguna()['nama_pengguna']) $pesan_error['nomor-rekening-tujuan'] = 'Tidak dapat transfer ke rekening anda sendiri';
    //jika tmp bernilai false, berarti memang tidak ada data rekning tersebut/tidak valid
    } else $pesan_error['nomor-rekening-tujuan'] = 'Nomor rekening tidak valid';
    //pengecekan jika nominalnya dibawah 1 alias 0
    if ($_POST['nominal'] < 1) $pesan_error['nominal'] = 'Nominal harus lebih dari 0';
    validasi_masukan_numerik($pesan_error, 'nominal'); //validasi numerik untuk nominal
    validasi_masukan_wajib($pesan_error, 'nominal'); //nominal dengan validasi wajib dimasukkan
    //pengecekan jika sudah tidak ada pesan error untuk rekening dan nominal
    if (!isset($pesan_error['nominal']) & !isset($pesan_error['nomor-rekening'])) {
        //dicek lagi untuk saldi setelah dikurangi nominal transfer jika dibawah angka 0
        if ($cek_saldo-$_POST['nominal'] < 0) $pesan_error['nominal'] = 'Saldo tidak cukup';
    }
    validasi_masukan_wajib($pesan_error, 'nomor-rekening-tujuan'); //masukan wajib untuk rekening tujuan
    if (!empty($pesan_error)) return; //jika ada pesan error, return sampai disini, ke bawahnya tidak diproses
    if (!isset($_POST['konfirmasi-transfer'])) return; //sama
    $id = generate_id('transaksi', 'id'); //menanggil fungsi generate id pada tabel transaksi kolom id
    //menyimpan data transaksi ke tabel dengan waktu sekarang
    $q = $conn->prepare("INSERT INTO transaksi VALUES ('$id', CURRENT_TIMESTAMP, '1', '{$_POST['nomor-rekening']}', '{$_POST['nomor-rekening-tujuan']}', '{$_POST['nominal']}')");
    $q->execute();
}

//validasi alfanumerik oleh 160411100145 ABDUR ROHMAN
function validasi_masukan_alfanumerik(&$pesan_error, $name) {
    $pattern = "/^[a-zA-Z0-9]+$/"; //pattern untuk alfanumerik yaitu huruf besar A-Z, huruf kecil a-z dan angka 0-9
    //jika false maka otomatis tidak sesuai pattern
    if (@$_POST[$name]!='' & !preg_match($pattern, @$_POST[$name])) $pesan_error[$name] = 'Hanya boleh memasukkan angka atau huruf';
}

//validasi masukan minimal oleh 160411100142 MOHAMMAD FAISHOL
function validasi_masukan_minimal(&$pesan_error, $name, $panjang) {
    //mengecek jika panjang masukan masih kurang dari ketentuan minimal
    if (strlen(@$_POST[$name])<$panjang) $pesan_error[$name] = 'Panjang minimal harus '.$panjang.' karakter';
}

//validasi masukan harus sama oleh 160411100145 ABDUR ROHMAN
function validasi_masukan_sama(&$pesan_error, $name1, $name2, $nama) {
    //mengecek jika masukan tidak sama dengan name ke dua di form HTML
    //biasanya seperti password dan konfirmasinya
    if (@$_POST[$name1]!=@$_POST[$name2]) $pesan_error[$name1] = 'Masukan harus sama dengan '.$nama;
}

//validasi masukan huruf/alfabet oleh 160411100142 MOHAMMAD FAISHOL
function validasi_masukan_alfabet(&$pesan_error, $name) {
    $pattern = "/^[a-z A-Z'-]+$/"; //alfabet dari huruf kecil maupun besar, ditambah spasi untuk pemisah nama
    if (@$_POST[$name]!='' & !preg_match($pattern, @$_POST[$name])) $pesan_error[$name] = 'Hanya boleh memasukkan alfabet';
}

//validasi masukan dengan panjang dan minimal tertentu oleh 160411100145 ABDUR ROHMAN
function validasi_masukan_panjang(&$pesan_error, $name, $min, $max) {
    //mengecek jika kurang dari minimal
    if (strlen(@$_POST[$name])<$min) $pesan_error[$name] = 'Panjang kurang dari '.$min.' digit';
    //mengecek jika melebihi panjang maksimal
    else if (strlen(@$_POST[$name])>$max) $pesan_error[$name] = 'Panjang melebihi '.$max.' digit';
}

//validasi email oleh 160411100142 MOHAMMAD FAISHOL
function validasi_masukan_email(&$pesan_error, $name) {
    //email format a@b.c
    //pattern pertama sebelum @ adalah bebas antara huruf besar, jika sudah @ maka setidakya ada '.' dan huruf 1, berulang
    //contoh aa8@bb.cc.dd.ee -> benar
    //jika ada titik sebelum @ maka setidaknya ada 1 huruf lagi setelahnya contoh a.b.c.d@aaa.bb
    $pattern = "/^([A-z0-9]+|([A-z0-9]+([._])[A-z0-9]+)+)@([A-z0-9]+[._][A-z0-9]{1,})+$/";
    if (@$_POST[$name]!='' & !preg_match($pattern, @$_POST[$name])) $pesan_error[$name] = 'E-mail tidak valid';
}

//fungsi validasi penyimpanan edit profi customer oleh 160411100152 NATIQ HASBI ALIM
function save_user_management_validation() {
    global $pesan_error; //memanggil global variabel 2 ini
    global $conn;
    //mengecek jika datanya tidak sama dengan datanya yang lama alias diubah
    if ($_POST['nama-pengguna']!=pengguna()['nama_pengguna']) {
        //melakukan select pada pengguna dengan where kondisi data baru
        $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='{$_POST['nama-pengguna']}' AND aktif='1'");
        $q->execute();
        //jika method fetchAll ini menghasilkan setidaknya 1 (tidak bernilai false) maka dianggap sudah ada yang menggunakan data itu
        if (@$q->fetchAll()) $pesan_error['nama-pengguna'] = 'Nama pengguna sudah digunakan';
    }
    validasi_masukan_alfanumerik($pesan_error, 'nama-pengguna'); //menvalidasi nama pengguna untuk alfanumerik
    validasi_masukan_wajib($pesan_error, 'nama-pengguna'); //masukan wajib juga
    if ($_POST['sandi']!='') { //jika kolom sandi diisi, dianggap melakukan perubahan pada kata sandi, dan akan divalidasi
        validasi_masukan_minimal($pesan_error, 'sandi', 4); //setidaknya terdapat 4 huruf
        validasi_masukan_sama($pesan_error, 'konfirmasi-sandi', 'sandi', 'Sandi'); //divalidasi juga dengan kolom konfirmasi, harus sama
    }
    validasi_masukan_alfabet($pesan_error, 'nama'); //validasi alfabet untuk nama
    validasi_masukan_wajib($pesan_error, 'nama'); //wajib juga
    if ($_POST['nomor-hp']!=pengguna()['nomor_hp']) { //jika ada perbedaan dengan nomor hp yang lama, maka dianggap diubah dan divalidasi
        //melakukan select pada database dengan data hp
        $q = $conn->prepare("SELECT * FROM pengguna WHERE nomor_hp='{$_POST['nomor-hp']}'");
        $q->execute();
        //jika true (ada datanya) dianggap sudah ada yang menggunakan data tsb
        if (@$q->fetchAll()) $pesan_error['nomor-hp'] = 'Nomor HP sudah digunakan';
    }
    validasi_masukan_panjang($pesan_error, 'nomor-hp', 10, 15); //validasi panjang untuk hp min 10 dan max 15 karakter
    validasi_masukan_numerik($pesan_error, 'nomor-hp'); //harus angka
    validasi_masukan_wajib($pesan_error, 'nomor-hp'); //dan masukan wajib
    if ($_POST['email']!=pengguna()['email']) { //email juga demikian, jika beda dianggap melakukan perubahan dan divalidasi
        $q = $conn->prepare("SELECT * FROM pengguna WHERE email='{$_POST['email']}'"); //select berdasarkan email
        $q->execute();
        if (@$q->fetchAll()) $pesan_error['email'] = 'E-mail sudah digunakan'; //jika data ada maka dianggap sudah ada yang menggunakan
    }
    validasi_masukan_email($pesan_error, 'email'); //validasi format email untuk kolom email
    validasi_masukan_wajib($pesan_error, 'email'); //validasi wajib juga
    if (!empty($pesan_error)) return; //jika ada pesan kesalahan, maka sampai disini (return, kebawahnya tidak akan diproses)
    $nama_pengguna = pengguna()['nama_pengguna']; //mengambil data nama pengguna yang lama dari fungsi pengguna()
    if ($_POST['sandi']!='') { //jika kolom sandi diisi, maka otomatis sandi akan diubah
        //mengupdate database berdasarkan nama pengguna saat ini
        $q = $conn->prepare("UPDATE pengguna SET sandi=SHA2('{$_POST['sandi']}', 0) WHERE nama_pengguna='$nama_pengguna' AND aktif='1'");
        $q->execute();
    }
    //mengupdate data lainnya, meskipun data sama tetap akan melakukan ini
    $q = $conn->prepare("UPDATE pengguna SET nama_pengguna='{$_POST['nama-pengguna']}', nama='{$_POST['nama']}', alamat='{$_POST['alamat']}', nomor_hp='{$_POST['nomor-hp']}', email='{$_POST['email']}' WHERE nama_pengguna='$nama_pengguna' AND aktif='1'");
    $q->execute();
    //mengubah data pada session, karena data nama-pengguna dianggap sudah berbeda, sehingga user tetap tercatat sudah login
    $_SESSION['nama-pengguna'] = $_POST['nama-pengguna'];
}

//fungsi list pengguna oleh 160411100145 ABDUR ROHMAN
function list_pengguna() {
    global $conn; //manggil global variabel koneksi ke database
    //melakukan select data pengguna dan yang aktif
    $q = $conn->prepare('SELECT * FROM pengguna WHERE aktif="1"');
    $q->execute();
    //mereturn data tersebut berbentuk array
    return @$q->fetchAll();
}

//fungsi list pengguna oleh 160411100142 MOHAMMAD FAISHOL
function pengguna_rinci($nama_pengguna) {
    $re = array(); //set nilai awal array kosong
    global $conn; //memanggil koneksi
    //melakukan select berdasarkan nama pengguna dan dijoin dengan tabel jenis pengguna sebagai kerangan apakah admin/customer
    $q = $conn->prepare("SELECT * FROM pengguna JOIN jenis_pengguna ON jenis_pengguna.id=pengguna.jenis_pengguna WHERE nama_pengguna='$nama_pengguna' AND aktif='1'");
    $q->execute();
    //mengeset array kosong tadi dengan index 'pengguna', dan diisi data yang telah diselect tadi, tentunya index ke 0 karena tidak mungkin ada data yang sama
    $re['pengguna'] = @$q->fetchAll()[0];
    //select rekening juga berdasarkan nama pengguna dan yang aktif
    $q = $conn->prepare("SELECT * FROM rekening WHERE nama_pengguna='$nama_pengguna' AND aktif='1'");
    $q->execute();
    //menyimpan data rekening dalam array dengan index 'rekening' dan tidak index 0 saja, karena bisa jadi punya lebih dari 1 rekening
    $re['rekening'] = @$q->fetchAll();
    return $re; //mereturn data
}

//fungsi random angka dengan panjang tertentu oleh 160411100145 ABDUR ROHMAN
function random_angka($panjang) {
    $r = ''; //set string kosong
    //mengulang sebanyak $panjang dengan angka random dari 0-9
    for ($x=0; $x<$panjang; $x++) $r .= random_int(0, 9);
    return $r; //mereturn hasil string yang berisi angka random tadi
}

//fungsi menghasilkan nomor rekening acak oleh 160411100145 ABDUR ROHMAN
function generate_nomor_rekening() {
    global $conn; //memanggil global variabel koneksi
    $sudah_ada = true; //asumsi sudah ada di databse
    while ($sudah_ada) {
        //mengacak angka rekening dengan format 0002-01-######-##-# dengan bantuan fungsi random di atas
        $re = '0002-01-'.random_angka(6).'-'.random_angka(2).'-'.random_angka(1);
        //melakukan select pada tabel rekening dengan data random tadi
        $q = $conn->prepare("SELECT * FROM rekening WHERE nomor_rekening='$re'");
        $q->execute();
        //mengeset $sudah_ada dengan nilai hasil select, jika kebetulan memang sudah ada maka akan bernilai true, dan looping mengacak lagi
        @$sudah_ada = $q->fetchAll();
    }
    return $re;
}

//fungsi validasi penambahan rekening oleh 160411100153 MOCH. AMIR
$tmp = ''; //global variabel temporal, digunakan untuk menyimpan data nomor rekening yang dirandom supaya dapat dipanggil dan ditampilkan di html
function add_bank_account_validation() {
    global $pesan_error; //mamanggil tampungan untuk pesan error di global
    validasi_masukan_numerik($pesan_error, 'set-awal'); //validasi untuk setoran awal numerik
    validasi_masukan_wajib($pesan_error, 'set-awal'); //wajib juga
    if (empty($pesan_error)) { //jika tidak ada kesalahan
        $nomor_rekening = generate_nomor_rekening(); //generate nomor rekening dari fungsi rekening
        global $tmp; //memanggil global variabel temporal tadi
        $tmp = $nomor_rekening; //mengisi dengan hasil generate
        global $conn; //memanggil koneksi di global
        //mengambil data $_GET dengan index nama pengguna/masukan user, jika tidak ada, maka diambilkan dari data $_POST
        $nama_pengguna = $_GET['nama-pengguna'] ?? $_POST['nama-pengguna'];
        //menyimpan data dalam tabel rekening dengan nama pengguna yang telah diambil dari GET/POST tadi dengan status aktif
        $q = $conn->prepare("INSERT INTO rekening VALUES ('$nomor_rekening', '$nama_pengguna', '1')");
        $q->execute();
        //menggenerate id dengan fungsi generate id di tabel transaksi dan kolom id
        $id = generate_id('transaksi', 'id');
        //memasukkan transaksi dengan jenis 0 (setoran awal) dengan nominal sesuai yang dimasukkan di kolom (mengambil di data $_POST) dan juga dengan waktu saat ini
        //setoran awal tidak perlu mengeset nomor rekening tujuan (dibuat NULL)
        $q = $conn->prepare("INSERT INTO transaksi VALUES ('$id', CURRENT_TIMESTAMP, '0', '$nomor_rekening', NULL, '{$_POST['set-awal']}')");
        $q->execute();
    }
}

//fungsi penghapusan rekening oleh 160411100145 ABDUR ROHMAN
function hapus_rekening($nomor_rekening) {
    global $conn; //manggil koneksi di global
    //melakukan update pada nomor rekening input dengan mengeset kolom aktif menjadi 0, sehingga tidak akan dibaca aktif lagi
    //tidak dihapus, karena akan berpengaruh pada data trasaksi yang sudah ada
    $q = $conn->prepare("UPDATE rekening SET aktif='0' WHERE nomor_rekening='{$_GET['account-number']}'");
    $q->execute();
}

//fungsi validasi saat menyimpan pengeditan user dari admin oleh 160411100152 NATIQ HASBI ALIM
function save_user_management_validation_admin() {
    global $pesan_error; //memanggil tempat menyimpan pesan error di global
    global $conn; //memanggil koneksi juga di global
    //jika nama pengguna yang di $_POST tidak sama dengan pengguna rinci di database (kasarnya sudah diubah), maka akan dilakukan validasi
    if ($_POST['nama-pengguna']!=pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama_pengguna']) {
        //select berdasarkan nama pengguna yang baru diasukkan tadi
        $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='{$_POST['nama-pengguna']}' AND aktif='1'");
        $q->execute();
        //jika menghasilkan nilai, maka jelas nama pengguna sudah ada dan ada peringatan berikut
        if (@$q->fetchAll()) $pesan_error['nama-pengguna'] = 'Nama pengguna sudah digunakan';
    }
    validasi_masukan_alfanumerik($pesan_error, 'nama-pengguna'); //validasi alfanumerik juga
    validasi_masukan_wajib($pesan_error, 'nama-pengguna'); //masukan wajib juga
    if ($_POST['sandi']!='') { //jika kolom sandi diisi, dianggap melakukan perubahan dan akan divalidasi
        validasi_masukan_minimal($pesan_error, 'sandi', 4); //validasi minimail 4
        validasi_masukan_sama($pesan_error, 'konfirmasi-sandi', 'sandi', 'Sandi'); //harus sama dengan kolom konfirmasi
    }
    validasi_masukan_alfabet($pesan_error, 'nama'); //validasi alfabet untuk nama
    validasi_masukan_wajib($pesan_error, 'nama'); //validasi wajib juga
    if ($_POST['nomor-hp']!=pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nomor_hp']) { //jika nomor hp berbeda dengan data yang lama, akan divalidasi juga
        $q = $conn->prepare("SELECT * FROM pengguna WHERE nomor_hp='{$_POST['nomor-hp']}'"); //select berdasarkan nomor hp yang baru
        $q->execute();
        //jika ada nilai, maka dianggap sudah ada, dan ada peringatan
        if (@$q->fetchAll()) $pesan_error['nomor-hp'] = 'Nomor HP sudah digunakan';
    }
    validasi_masukan_panjang($pesan_error, 'nomor-hp', 10, 15); //validasi no hp min 10 max 15
    validasi_masukan_numerik($pesan_error, 'nomor-hp'); //validasi numerik juga
    validasi_masukan_wajib($pesan_error, 'nomor-hp'); //validasi wajib diisi juga
    if ($_POST['email']!=pengguna_rinci($_GET['nama-pengguna'])['pengguna']['email']) { //email jika berbeda dengan data yang lama, akan divalidasi
        $q = $conn->prepare("SELECT * FROM pengguna WHERE email='{$_POST['email']}'"); //select berdasarkan email baru
        $q->execute();
        //jika ada data, maka dianggap sudah ada
        if (@$q->fetchAll()) $pesan_error['email'] = 'E-mail sudah digunakan';
    }
    validasi_masukan_email($pesan_error, 'email'); //masukan format email pada kolom email
    validasi_masukan_wajib($pesan_error, 'email'); //masukan wajib juga
    if (!empty($pesan_error)) return; //jika ada error, maka ke bawah ini tidak dieksekusi, ditahan oleh return
    if ($_POST['sandi']!='') { //jika kolom sandi terisi, maka akan dianggap melakukan perubahan dan akan diupdate di database
        //melakukan update terhadap pengguna bersarkan nama pengguna di data $_GET (ini khusus admin)
        $q = $conn->prepare("UPDATE pengguna SET sandi=SHA2('{$_POST['sandi']}', 0) WHERE nama_pengguna='{$_GET['nama-pengguna']}' AND aktif='1'");
        $q->execute();
    }
    //jika ternyata yang diupdate adalah dirinya sendiri, maka akan dilakukan update juga pada session, agar tidak merusak data login pada sesi
    if (pengguna_rinci($_GET['nama-pengguna'])['pengguna']['nama_pengguna']==pengguna()['nama_pengguna']) $_SESSION['nama-pengguna'] = $_POST['nama-pengguna'];
    //melakukan update pada tabel pengguna berdasarkan nama pengguna yang ada dalam data $_GET
    $q = $conn->prepare("UPDATE pengguna SET nama_pengguna='{$_POST['nama-pengguna']}', nama='{$_POST['nama']}', alamat='{$_POST['alamat']}', nomor_hp='{$_POST['nomor-hp']}', email='{$_POST['email']}' WHERE nama_pengguna='{$_GET['nama-pengguna']}' AND aktif='1'");
    $q->execute();
}

//fungsi validasi saat penambahan pengguna oleh 160411100153 MOCH. AMIR
function add_user_validation($jenis_pengguna) {
    global $pesan_error; //memanggil global variabel tampungan error
    global $conn; //memanggil koneksi di global
    //select databse berdasarkan nama pengguna yang ada di data $_POST
    $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='{$_POST['nama-pengguna']}' AND aktif='1'");
    $q->execute();
    //jika menghasilkan nilai (setidaknya ada 1/true) maka data tersebut sudah ada, dan tidak diperbolehkan
    if (@$q->fetchAll()) $pesan_error['nama-pengguna'] = 'Nama pengguna sudah digunakan';
    validasi_masukan_alfanumerik($pesan_error, 'nama-pengguna'); //validasi aflanumerik untuk nama pengguna
    validasi_masukan_wajib($pesan_error, 'nama-pengguna'); //masukan wajib juga
    validasi_masukan_minimal($pesan_error, 'sandi', 4); //validasi minimal 4 untuk sandi
    validasi_masukan_wajib($pesan_error, 'sandi'); //validasi wajib juga
    validasi_masukan_sama($pesan_error, 'konfirmasi-sandi', 'sandi', 'Sandi'); //validasi harus sama dengan konfirmasi sandi
    validasi_masukan_alfabet($pesan_error, 'nama'); //validasi alfabet untuk nama tampilan
    validasi_masukan_wajib($pesan_error, 'nama'); //validasi wajib juga
    $q = $conn->prepare("SELECT * FROM pengguna WHERE nomor_hp='{$_POST['nomor-hp']}'"); //melakukan select berdasarkan data nomor hp yang dimasukkan
    $q->execute();
    //jika ternyata ada nilainya, maka data tersebut sudah ada dan tidak boleh
    if (@$q->fetchAll()) $pesan_error['nomor-hp'] = 'Nomor HP sudah digunakan';
    validasi_masukan_panjang($pesan_error, 'nomor-hp', 10, 15); //validasi minimal 10 dan maks 15 untuk no hp
    validasi_masukan_numerik($pesan_error, 'nomor-hp'); //numerik juga
    validasi_masukan_wajib($pesan_error, 'nomor-hp'); //dan masukan wajib
    $q = $conn->prepare("SELECT * FROM pengguna WHERE email='{$_POST['email']}'"); //melakuakn select pada email berdasarkan data yang dimasukkan
    $q->execute();
    //jika ada (true), maka tidak diperbolehkan
    if (@$q->fetchAll()) $pesan_error['email'] = 'E-mail sudah digunakan';
    validasi_masukan_email($pesan_error, 'email'); //validasi format email
    validasi_masukan_wajib($pesan_error, 'email'); //masukan wajib juga
    if ($jenis_pengguna!=0) { //jika jenis penggunanya tidak 0 (bukan admin) harus ada validasi setoran awal untuk nomor rekening
        validasi_masukan_numerik($pesan_error, 'set-awal'); //validasi numerik
        validasi_masukan_wajib($pesan_error, 'set-awal'); //masukan wajib juga
    }
    if (!empty($pesan_error)) return; //jika ada pesan error, maka ditahan sampai disini dengan return
    //memasukkan data yang baru tadi ke tabel pengguna
    $q = $conn->prepare("INSERT INTO pengguna VALUES ('{$_POST['nama-pengguna']}', SHA2('{$_POST['sandi']}', 0), '$jenis_pengguna', '{$_POST['email']}', '{$_POST['nama']}', '{$_POST['alamat']}', '{$_POST['nomor-hp']}', '1')");
    $q->execute();
    //jika yang ditambahkan bukan admin, maka akan memanggil validasi penambahan rekening juga dan proses penyimpanan dan validasinya ada di sana
    if ($jenis_pengguna!=0) add_bank_account_validation();
}

//fungsi untuk menghapus pengguna berdasarkan nama pengguna oleh 160411100152 NATIQ HASBI ALIM
function hapus_pengguna($nama_pengguna) {
    global $conn; //memanggil koneksi di global variabel
    $u = generate_id('pengguna', 'nama_pengguna'); //menggenerate id dengan fungsi generator
    $e = generate_id('pengguna', 'email'); //email juga
    $n = generate_id('pengguna', 'nomor_hp'); //nomor hp juga
    //diupdate dengan data tersebut, agar tidak terdeteksi sama jika ada penambahan data baru yang kebetulan memang sama dengan data yang sudah dihapus
    //tidak dihapus karena akan berpengaruh pada tabel yang berkaitan dengan data tersebut, cuma diupdate saja dan yang bersifat unik akan diganti data acak di atas
    //selain itu, mengeset kolom aktif menjadi 0
    $q = $conn->prepare("UPDATE pengguna SET aktif='0', nama_pengguna='$u', email='$e', nomor_hp='$n' WHERE nama_pengguna='{$_GET['nama-pengguna']}' AND aktif='1'");
    $q->execute();
    //menonaktifkan rekening juga berdasarkan nama pengguna yang dimasukkan (jika ada, jika tidak ada [jenis admin] tetap akan melakukan ini dan tidak berefek apa-apa)
    $q = $conn->prepare("UPDATE rekening SET aktif='0' WHERE nama_pengguna='$u' AND aktif='1'");
    $q->execute();
}

//fungsi rupiah menghasilkan format Rp 0.000.000,00 oleh 160411100153 MOCH. AMIR
function rp($nominal) {
    //mengupdate nominal menjadi string, takutnya yang dimasukkan bertipe data int (angka)
    //mengeset string kosong buat penampung nanti, dan counter $c = 0
    $nominal = strval($nominal); $r = ''; $c = 0;
    $nominal = explode('.', $nominal); //memisah jika terdapat titik, takutnya ada titik seperti 4000.00
    $nominal = $nominal[0]; //mengambil data index pertama sebelum titik, berarti mengambil 4000-nya
    $nominal = explode('-', $nominal); //jika ada tanda minus di depan, maka akan dipecah lagi berdasarkan tanda minus tsb
    if (sizeof($nominal)>1) { //jika ternyata array yang dihasilkan oleh pemecahan tanda minus berjumlah lebih dari 1, berarti angka tersebut memang minus
        $min = '-'; $nominal = $nominal[1]; //dilakukan pemisahan dengan index 0 nin dan nominalnya di array index 1
    } else {
        $min = ''; $nominal = $nominal[0]; //jika tidak, maka memang bukan angka minus dan $min diset string kosong agar tidak berpengaruh saat direturn
    }
    for ($x=strlen($nominal)-1; $x>=0; $x--) { //diulang sebanyak string tapi dari belakang
        $r = $nominal[$x].$r; $c++; //menambah string kosong $r dengan index nominal dari belakang sambil menambah counter ($c)
        //jika counter kelipatan 3, maka saatnya ditambahkan dengan titik
        //misalnya 10000000, maka tiap perulangan 3x dari belakang akan ditambah titik, sehingga menjadi 10.000.000
        if ($c%3==0 & $x>0) $r = ".".$r;
    }
    //mereturn hasil tadi, dengan tanda minusnya, tetapi jika tidak minus makan tidak akan mengganggu, karena variabel $min diisi string kosong di atas
    //return ditambahkan dengan ,00 dibelakang dan tanda Rp di depan sehingga berformat Rp ##.###,00
    return 'Rp '.$min.$r.',00';
}

?>