<?php

/**
 * Pengecekan sudah ada yang login/tidak
 * Author: 160411100153 MOCH. AMIR
 */

if (isset($_SESSION['nama-pengguna'])) {//mengecek jika sudah ada sesi dengan nama pengguna (kasarnya sudah ada yang masuk)
    //memeriksa data yang sudah masuk tersebut di database
    $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='{$_SESSION['nama-pengguna']}' AND aktif='1'");
    $q->execute();
    if (!@$q->fetchAll()) { //jika ternyata data yang dicatat di sesi tersebut sudah tidak berlaku didatabse
        unset($_SESSION['nama-pengguna']); //membuang sesi tersebut (dikeluarkan paksa, karena sudah tidak valid)
        header('Location: login'); //dan mendirect ke halaman login, untuk melakukan authorized lagi
    }
} else header('Location: login'); //jika tidak ada catatan masuk di sesi, langsung didirect ke halaman login