<?php
$sqlCommand = "SELECT * FROM tasks";
$sqlAdd = NULL;
$sqlDone = NULL;
$sqlDel = NULL;
if (!empty($_POST)) {
    if (isset($_POST['task_add'])) {
        $task = $_POST['task_add'];
        $taskDate = date('Y-m-d')." ".date('H:i:s');
        $sqlAdd = "INSERT INTO tasks (id, description, is_done, date_added) VALUES (?,?,?,?)";
    }
    elseif (isset($_POST['task_done'])) {
        $taskDone = (int)$_POST['task_done'];
        $sqlDone = "UPDATE tasks SET is_done=1 WHERE id=?";
    }
    elseif (isset($_POST['task_del'])) {
        $taskDel = (int)$_POST['task_del'];
        $sqlDel = "DELETE FROM tasks WHERE id =?";
    }
    else {
        echo "Whoops!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="" rel="stylesheet" type="text/css">
    <title>ToDo</title>
</head>
<body>
<h1>ToDo:</h1>

<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=netology;charset=utf8", 'mysql', 'mysql');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if ($sqlAdd != NULL) {
        $db->prepare($sqlAdd)->execute([NULL,$task,0,$taskDate]);
    }
    if ($sqlDone != NULL) {
        $db->prepare($sqlDone)->execute([$taskDone]);
    }
    if ($sqlDel != NULL) {
        $db->prepare($sqlDel)->execute([$taskDel]);
    }
}
catch (PDOException $e) {
    echo "Ошибки execute: ";
    echo $e->getMessage();
}

try {
    $db = new PDO("mysql:host=localhost;dbname=netology;charset=utf8", 'mysql', 'mysql');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $query = $db->query($sqlCommand);
}
catch (PDOException $e) {
    echo "Ошибки query: ";
    echo $e->getMessage();
}

echo "<table border='1'>";
echo "<tr><th>id</th><th>Задача</th><th>Выполнена?</th><th>Дата создания</th></tr>";
while ($tablerows = $query->fetch()) {
    echo "<tr><td>$tablerows[0]</td><td>$tablerows[1]</td><td>$tablerows[2]</td><td>$tablerows[3]</td></tr>";
}
echo "</table>";
?>

<form method="POST">
    <p>Добавить задачу:</p>
    <input type="text" name="task_add" placeholder="Описание задачи">
    <input type="submit" value="Добавить">
</form>

<form method="POST">
    <p>Отметить задачу как выполненную:</p>
    <input type="text" name="task_done" placeholder="id задачи">
    <input type="submit" value="Отметить">
</form>

<form method="POST">
    <p>Удалить задачу:</p>
    <input type="text" name="task_del" placeholder="id задачи">
    <input type="submit" value="Удалить">
</form>

</body>
</html>
