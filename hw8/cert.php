<?php
header("Content-Type: image/png");
session_start();
$lines = $_SESSION["lines"];
$image = imagecreatetruecolor(900,600);
$backColor = imagecolorallocate($image,140,190,110);
$textColor = imagecolorallocate($image,140,60,50);
imagefill($image, 0, 0, $backColor);

$fontFile = "font.ttf";
if (!file_exists($fontFile)) {
    echo "Файл со шрифтом не найден!";
    exit;
}

imagettftext($image,25,0,50,50,$textColor,$fontFile,$lines[0]);
imagettftext($image,20,0,50,200,$textColor,$fontFile,$lines[1]);

imagepng ($image);
imagedestroy($image);

