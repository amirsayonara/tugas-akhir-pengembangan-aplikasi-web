<?php

$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 5);

$im = imagecreate(222, 30);

$bg = imagecolorallocate($im, 0, 255, 255);
$textcolor = imagecolorallocate($im, 0, 0, 255);

session_start();
$_SESSION['captcha'] = $ranStr;

imagestring($im, 5, 80, 7, $ranStr, $textcolor);

header("Content-type: image/jpeg");
imagejpeg($im);