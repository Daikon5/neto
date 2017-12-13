<?php
header("Content-Type: image/png");
session_start();
$lines = $_SESSION["lines"];
echo $lines[0];
echo $lines[1];
$image = imagecreatetruecolor(900,600);
$backColor = imagecolorallocate($image,140,190,110);
$textColor = imagecolorallocate($image,140,60,50);
imagefill($image, 0, 0, $backColor);

$fontFile = __DIR__."font.ttf";
if (!file_exists($fontFile)) {
    echo "Файл со шрифтом не найден!";
    exit;
}

imagettftext($image,40,0,50,50,$textColor,$fontFile,$lines[0]);
imagettftext($image,35,0,100,50,$textColor,$fontFile,$lines[1]);

imagepng ($image);
imagedestroy($image);

