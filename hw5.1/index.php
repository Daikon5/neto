<?php
require_once  __DIR__ . '/vendor/autoload.php';


$query = NULL;
$longitude = 0;
$latitude = 0;

if (isset($_GET['address'])) {
    $query = (string)$_GET['address'];
    $api = new \Yandex\Geo\Api();

    $api->setQuery($query);

    $api
        ->setLimit(10)
        ->setLang(\Yandex\Geo\Api::LANG_RU)
        ->load();

    $response = $api->getResponse();

    $collection = $response->getList();
    foreach ($collection as $key=>$item) {
        if ($key == 0) {
            $latitude = $item->getLatitude();
            $longitude = $item->getLongitude();
        }
        echo $item->getAddress().PHP_EOL;
        echo "Широта: ".$item->getLatitude().PHP_EOL;
        echo "Долгота: ".$item->getLongitude()."</br>";
    }
}
?>

<form method="GET">
    <input type="text" name="address" placeholder="Введите адрес" value="<?php if ($query != NULL) {echo $query;} ?>">
    <input type="submit" value="Искать">
</form>

<!DOCTYPE html>
<html>
<head>
    <title>ДЗ 5.1</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="balloon_and_hint.js" type="text/javascript"></script>
    <style>
        html, body, #map {
            width: 100%; height: 100%; padding: 0; margin: 0;
        }
    </style>
</head>
<body>
<?php echo '<script language="javascript">var long = '.$longitude.'; var lat = '.$latitude.';</script>'; ?>
<div id="map"></div>
</body>
</html>