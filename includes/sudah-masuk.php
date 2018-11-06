<?php

if (isset($_SESSION['nama-pengguna'])) {
    $q = $conn->prepare("SELECT * FROM pengguna WHERE nama_pengguna='{$_SESSION['nama-pengguna']}' AND aktif='1'");
    $q->execute();
    if (!@$q->fetchAll()) {
        unset($_SESSION['nama-pengguna']);
        header('Location: login');
    }
} else header('Location: login');