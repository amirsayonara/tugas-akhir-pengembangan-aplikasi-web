<?php
/**
 * Pengecekan login tipe customer
 * Author: 160411100145 ABDUR ROHMAN
 */
include 'sudah-masuk.php'; //memangil file sudah masuk untuk pengecekan sudah ada yang login/tidak
//memastikan bahwa yang login adalah bukan bertipe admin, jika demikian, maka akan didirect ke halaman awal dan tidak diijinkan mengakses konten
if (pengguna()['jenis_pengguna']!=1) header('Location: ./');