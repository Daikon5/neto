<?php
$site = file_get_contents("http://openweathermap.org/data/2.5/weather?q=Omsk,ru&appid=b1b15e88fa797225412429c1c50c122a1");
$result = json_decode($site, true);
echo "<pre>";
echo "City: " . $result["name"]. "\n";
echo "Weather: " . $result["weather"]["0"]["main"] . "\n";
echo "Temperature: " . $result["main"]["temp"];