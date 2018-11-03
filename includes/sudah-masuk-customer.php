<?php

include 'sudah-masuk.php';
if (pengguna()['jenis_pengguna']!=1) header('Location: ./');