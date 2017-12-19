<?php
require_once "functions.php";

if (!isAuth()) {
    echo "Вы не авторизованы.";
    http_response_code(403);
    die;
}
else {
    echo '<p>Здравствуйте, '.$_SESSION['user']['username'].".</p>";
}

if (isset($_POST["testdel"]) && file_exists("testlist.json")) {    //удаление теста из списка
    $file = file_get_contents("testlist.json");
    $listDecoded = json_decode($file,true);
    foreach ($listDecoded as $key => $item) {
        if ($item == $_POST["testdel"]) {
            unset ($listDecoded[$key]);
            sort($listDecoded);
            echo "Тест ".$_POST["testdel"]." удален.";
        }
    }
    $listEncoded = json_encode($listDecoded);
    file_put_contents("testlist.json",$listEncoded);
}

if (file_exists("testlist.json")) {
    $file = file_get_contents("testlist.json");
    $list = json_decode($file,true);
    if (count($list) == 0) {
        echo "Увы, тестов пока нет.";
    }
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
<?php if (isAuthAdmin()): ?>
<p><a href="admin.php">Загрузка тестов</a></p>
<p>Удаление теста:</p>
<form method="post">
    <input type="text" name="testdel" placeholder="Имя удаляемого теста">
    <input type="submit">
</form>
<?php endif; ?>
<p><a href="logout.php">Выход</a></p>
</body>
</html>