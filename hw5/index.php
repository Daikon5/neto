<?php
$filename = "json.txt";
$json = file_get_contents($filename);
$data_res = json_decode($json,true);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title></title>
</head>
<body>
<?foreach ($data_res as $data):?>
<?foreach ($data as $key => $value):?>
    <dl>
        <dt><?=$key;?></dt>
        <dd><?=$value;?></dd>
    </dl>
<?endforeach;?>
<?endforeach;?>
</body>
</html>