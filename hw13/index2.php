<?php
session_start();
$editing = 0;
$sqlCommand = "SELECT * FROM tasks";
$id = NULL;
$sqlAdd = NULL;
$sqlActionDone = NULL;
$sqlActionUpdate = NULL;
$sqlActionDel = NULL;
$descToEdit = NULL;
$newDesc = NULL;
if (!empty($_POST)) {
    if (isset($_POST['task_add'])) {
        $task = $_POST['task_add'];
        $taskDate = date('Y-m-d')." ".date('H:i:s');
        $sqlAdd = "INSERT INTO tasks (id, description, is_done, date_added) VALUES (?,?,?,?)";
    }
    if (isset($_POST['task_update'])) {
        $newDesc = (string)$_POST['task_update'];
        $sqlUpdate = "UPDATE tasks SET description=? WHERE id=?";
        $id = $_SESSION['updating_id'];
    }
    if (isset($_POST['sort_by'])) {
        $sortParameter = $_POST['sort_by'];
        $sqlCommand = "SELECT * FROM tasks ORDER BY $sortParameter";
    }
}
if (!empty($_GET)) {
    if (($_GET['action']=='edit') && isset($_GET['id'])) {
        $editing = 1;
        $id = (int)$_GET['id'];
        $_SESSION['updating_id'] = $id;
        $sqlActionUpdate = "SELECT * FROM tasks WHERE id = $id";
    }
    if (($_GET['action']=='done') && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $sqlActionDone = "UPDATE tasks SET is_done=1 WHERE id=?";
    }
    if (($_GET['action']=='delete') && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $sqlActionDel = "DELETE FROM tasks WHERE id =?";
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
    if ($sqlActionDone != NULL) {
        $db->prepare($sqlActionDone)->execute([$id]);
    }
    if ($sqlActionDel != NULL) {
        $db->prepare($sqlActionDel)->execute([$id]);
    }
    if ($sqlActionUpdate != NULL) {
        echo $newDesc;
        echo $id;
        $db->prepare($sqlUpdate)->execute([$newDesc,$id]);
    }
}
catch (PDOException $e) {
    echo "Ошибки execute: ";
    echo $e->getMessage();
}

try {
    $db = new PDO("mysql:host=localhost;dbname=netology;charset=utf8", 'mysql', 'mysql');
    $query = $db->query($sqlCommand);
    if ($sqlActionUpdate != NULL) {
        $sth = $db->prepare($sqlActionUpdate);
        $sth->execute([$id]);
        $descToEdit = $sth->fetchColumn(1);
    }
}
catch (PDOException $e) {
    echo "Ошибки query: ";
    echo $e->getMessage();
}
?>

<form method="POST" style="margin-bottom: 20px">
    <label>Сортировать по:</label>
    <select name="sort_by">
        <option selected disabled>выберите параметр</option>
        <option value="date_added">Дате добавления</option>
        <option value="is_done">Статусу</option>
        <option value="description">Описанию</option>
    </select>
    <input type="submit" value="Отсортировать">
</form>

<?php
echo "<table border='1'>";
echo "<tr><th>Описание задачи</th><th>Статус</th><th>Дата создания</th><th>Действия</th></tr>";
while ($tablerows = $query->fetch()) {
    if ($tablerows[2] == 1) {
        $status = '<span style="color: green">Выполнено</span>';
    }
    else {
        $status = '<span style="color: darkorange">В процессе</span>';
    }
    echo "<tr><td>$tablerows[1]</td><td>$status</td><td>$tablerows[3]</td><td><a href='/index2.php?id=$tablerows[0]&action=edit'>Изменить</a>
                                                                                                    <a href='/index2.php?id=$tablerows[0]&action=done'>Выполнить</a>
                                                                                                    <a href='/index2.php?id=$tablerows[0]&action=delete'>Удалить</a></td></tr>";
}
echo "</table>";

if ($editing == 1 ) {
    echo "
    <form method=\"POST\" style=\"margin-top: 20px\">
    <label>Редактировать описание задачи:</label>
    <input type=\"text\" name=\"task_update\" value=$descToEdit>
    <input type=\"submit\" value=\"Отправить\">
    </form>
    ";
}
else {
    echo '
    <form method="POST" style="margin-top: 20px">
    <label>Добавить задачу:</label>
    <input type="text" name="task_add" placeholder="Описание задачи">
    <input type="submit" value="Добавить">
    </form>
    ';
}
?>

</body>
</html>