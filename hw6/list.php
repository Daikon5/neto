<?php
if (file_exists("testlist.json")) {
    $file = file_get_contents("testlist.json");
    $list = json_decode($file,true);
}
else {
    echo "Увы, тестов пока нет.";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>Список тестов</title>
</head>
<body>
<ul>
    <?php foreach ($list as $key => $value):?>
    <li><a href="<?php echo 'test.php?testid='.$key?>"><?php echo $value;?></a></li>
    <?php endforeach;?>
</ul>
<p></p><a href="admin.php">Загрузка тестов</a></p>
</body>
</html>