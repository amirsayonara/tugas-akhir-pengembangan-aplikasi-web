<?php

/**
 * Halaman logout/keluar
 * Author: 160411100145 ABDUR ROHMAN
 */

include 'includes/api.php'; //memanggil api.php (tempatnya segala fungsi dan penyalaan sesi)
unset($_SESSION['nama-pengguna']); //membuat index sesi nama-pengguna agar tidak terdeteksi sudah login
header('Location: ./'); //mendirect ke halaman awal