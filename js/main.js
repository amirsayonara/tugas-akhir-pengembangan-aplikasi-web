/**
 * main.js
 */

//deteksi halaman awal, untuk mengatur posisi navbar oleh 160411100153 MOCH. AMIR
document.onreadystatechange = function () {
    if (document.readyState === 'complete') { //event jika halaman telah selesai dimuat
        if (location.pathname=='/' | location.pathname=='/index' | location.pathname=='/index.php') { //mendeteksi halaman awal
            document.getElementsByTagName('header')[0].style.position='absolute'; //jika ada di halaman awal, navbar diatur absolute agar tidak fixed
        }
    }
}