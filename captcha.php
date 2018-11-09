<?php
/**
 * Generate random huruf dan angka dan dijadikan format gambar
 * Author: 160411100145 ABDUR ROHMAN
 */

$ranStr = md5(microtime()); //membuat bilangan hash md5 (kombinasi huruf dan angka berdasarkan bilangan random dari microtime)
$ranStr = substr($ranStr, 0, 5); //mengambil bilangan acak dari index 0-4

$im = imagecreate(222, 30); //membuat gambar dengan ukuran 222 x 30 piksel

$bg = imagecolorallocate($im, 0, 255, 255); //membuat background gambar
$textcolor = imagecolorallocate($im, 0, 0, 255); //menggabungkan teks dengan background

session_start();
$_SESSION['captcha'] = $ranStr; //menyimpan data teks random tersebut ke dalam sesi

imagestring($im, 5, 80, 7, $ranStr, $textcolor); //membuat gambar dari teks acak tadi

header("Content-type: image/jpeg"); //mengatur header menjadi gambar agar langsung dapat dipanggil dengan img di html
imagejpeg($im); //menampilkan gambar