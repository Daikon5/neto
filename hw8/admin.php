<?php
require_once "functions.php";
if (!isAuthAdmin()) {
    echo "Вы не авторизованы.";
    http_response_code(403);
    die;
}
if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) {
    $filename = $_FILES["file"]["name"];
    $pathInfo = pathinfo("$filename");
    $file = file_get_contents($filename);
    $test = json_decode($file,true);
    if ($pathInfo["extension"] != "json" || count($test) < 2) {
        echo "<p style='color:darkred'>Неподходящий формат файла</p>";
    }
    elseif (($_FILES["file"]["error"] == UPLOAD_ERR_OK) && move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"])) {
        if (file_exists("testlist.json")) {
            $testList = file_get_contents("testlist.json");
            $testListDecoded = json_decode($testList,true);
            if (in_array($pathInfo['filename'],$testListDecoded)) {
                echo "<p style='color:darkred'>Этот тест уже загружен</p>";
                exit;
            }
        }
        $testListDecoded[] = $pathInfo["filename"];
        $testListEncoded = json_encode($testListDecoded);
        file_put_contents("testlist.json",$testListEncoded);
        header ("Location:list.php",true,307);
    }
    else {
        echo "<p style='color:darkred'>Файл не загружен</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>Загрузи тест!</title>
</head>
<body>
    <form method="post" action="admin.php" enctype = "multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Загрузить">
    </form>
    <a href="list.php">К списку тестов</a>
</body>
</html>





