<?php
$city = "Omsk";
$appid = "b1b15e88fa797225412429c1c50c122a1";
$filename = "json.txt";

if (file_exists($filename)) {
    if ((time() - touch($filename)) > 3600) {
        $handle = fopen($filename,"w");
        $site = file_get_contents("http://openweathermap.org/data/2.5/weather?q=".$city.",ru&appid=".$appid);
        fwrite($handle,$site);
        fclose($handle);
    }
    else {
        $site = file_get_contents($filename);
    }
}
else {
    $handle = fopen($file,"w");
    $site = file_get_contents("http://openweathermap.org/data/2.5/weather?q=".$city.",ru&appid=".$appid);
    fwrite($handle,$site);
    fclose($handle);
}

$result = json_decode($site, true);
echo "<pre>";
echo "City: " . $result["name"]. "\n";
echo "Weather: " . $result["weather"]["0"]["main"] . "\n";
echo "Temperature: " . $result["main"]["temp"];
