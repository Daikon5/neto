<?php
session_start();
$sqlCommand = "SELECT t.id, t.description, t.date_added, t.is_done, us.login as assigned_user_name, u.login as user_name 
                   FROM task t 
                   JOIN user u ON u.id = t.user_id 
                   JOIN user us ON us.id = t.assigned_user_id
                   WHERE u.login = ?";
$id = NULL;
$sqlAdd = NULL;
$sqlActionDone = NULL;
$sqlActionUpdate = NULL;
$sqlUpdate = NULL;
$sqlActionDel = NULL;
$sqlSend = NULL;
$descToEdit = NULL;
$newDesc = NULL;
$editing = 0;

if (!isset($_SESSION['login'])) {
    echo "<a href='/register.php'>Войдите или зарегистрируйтесь</a>";
    die;
}
else {
    $login = $_SESSION['login'];
    $userId = $_SESSION['user_id'];
}

if (!empty($_POST)) {
    if (isset($_POST['task_add'])) {
        $task = $_POST['task_add'];
        $taskDate = date('Y-m-d')." ".date('H:i:s');
        $sqlAdd = "INSERT INTO task (id, description, is_done, date_added, assigned_user_id, user_id) VALUES (?,?,?,?,?,?)";
    }
    if (isset($_POST['task_update'])) {
        $newDesc = (string)$_POST['task_update'];
        $sqlUpdate = "UPDATE task SET description=? WHERE id=?";
        $id = $_SESSION['updating_id'];
    }
    if (isset($_POST['sort_by'])) {
        $sortParameter = $_POST['sort_by'];
        $sqlCommand .= " ORDER BY $sortParameter";
    }
    if (isset($_POST['send_task'])) {
        $taskSendingData = explode(",",$_POST['send_task']);
        $task_id = $taskSendingData[0];
        $userToSendTask = $taskSendingData[1];
        $sqlSend = "UPDATE task SET assigned_user_id=? WHERE id=?";
    }
}
if (!empty($_GET)) {
    if (($_GET['action']=='edit') && isset($_GET['id'])) {
        $editing = 1;
        $id = (int)$_GET['id'];
        $_SESSION['updating_id'] = $id;
        $sqlActionUpdate = "SELECT * FROM task WHERE id = $id";
    }
    if (($_GET['action']=='done') && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $sqlActionDone = "UPDATE task SET is_done=1 WHERE id=?";
    }
    if (($_GET['action']=='delete') && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $sqlActionDel = "DELETE FROM task WHERE id =?";
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
<h1>Здравствуйте, <?php echo $_SESSION['login']; ?>! Вот ваши задачи:</h1>

<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=neto;charset=utf8", 'mysql', 'mysql');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if ($sqlAdd != NULL) {
        $db->prepare($sqlAdd)->execute([NULL,$task,0,$taskDate,$userId,$userId]);
    }
    if ($sqlActionDone != NULL) {
        $db->prepare($sqlActionDone)->execute([$id]);
    }
    if ($sqlActionDel != NULL) {
        $db->prepare($sqlActionDel)->execute([$id]);
    }
    if ($sqlUpdate != NULL) {
        $db->prepare($sqlUpdate)->execute([$newDesc,$id]);
        $editing = 0;
    }
    if ($sqlSend != NULL) {
        $db->prepare($sqlSend)->execute([$userToSendTask,$task_id]);
    }
}
catch (PDOException $e) {
    echo "Ошибки execute: ";
    echo $e->getMessage();
}
?>

<form method="POST" style="margin-bottom: 20px">
    <label>Сортировать по:</label>
    <select name="sort_by">
        <option selected disabled>выберите параметр</option>
        <option value="t.date_added">Дате добавления</option>
        <option value="t.is_done">Статусу</option>
        <option value="t.description">Описанию</option>
    </select>
    <input type="submit" value="Отсортировать">
</form>

<?php
try {
    $sqlCommandNames = "SELECT id, login FROM user WHERE NOT login = ?";
    $db = new PDO("mysql:host=localhost;dbname=neto;charset=utf8", 'mysql', 'mysql');
    $query = $db->prepare($sqlCommand);
    $query->execute([$login]);

    $queryNames = $db->prepare($sqlCommandNames);
    $queryNames->execute([$login]);
    $tablerowsNames = $queryNames->fetchAll();

    if ($sqlActionUpdate != NULL) {
        $sth = $db->prepare($sqlActionUpdate);
        $sth->execute([$id]);
        $descToEdit = $sth->fetchColumn(3);
    }
}
catch (PDOException $e) {
    echo "Ошибки query: ";
    echo $e->getMessage();
}

echo "<table border='1'>";
echo "<tr><th>Описание задачи</th><th>Дата создания</th><th>Статус</th><th>Действия</th><th>Ответственный</th><th>Автор</th><th>Закрепить задачу за пользователем</th></tr>";
while ($tablerows = $query->fetch()) {
    if ($tablerows[3] == 1) {
        $status = '<span style="color: green">Выполнено</span>';
    }
    else {
        $status = '<span style="color: darkorange">В процессе</span>';
    }
    echo "<tr><td>$tablerows[1]</td>
              <td>$tablerows[2]</td>
              <td>$status</td>";
    if ($tablerows[4] == $tablerows[5]) {
        echo "<td><a href='/index.php?id=$tablerows[0]&action=edit'>Изменить</a>
                  <a href='/index.php?id=$tablerows[0]&action=done'>Выполнить</a>
                  <a href='/index.php?id=$tablerows[0]&action=delete'>Удалить</a>
              </td>";
    }
    else {
        echo "<td><a href='/index.php?id=$tablerows[0]&action=edit'>Изменить</a>
                  <a href='/index.php?id=$tablerows[0]&action=delete'>Удалить</a>
              </td>";
    }
    echo "    <td>$tablerows[4]</td>
              <td>$tablerows[5]</td>
              <td><form method=\"POST\">
                     <select name=\"send_task\">";
    foreach ($tablerowsNames as $names) {
        $task_id = $tablerows['0'];
        $id = $names['id'];
        $name = $names['login'];
        echo "<option value=\"$task_id,$id\">$name</option>";
        //echo "<input type=\"hidden\" name=\"task_id\" value=\"$tablerows[0]\">";
    }
    echo "           </select>
                     <input type=\"submit\" value=\"Переложить ответственность\">
                  </form>
              </td>
          </tr>";
}
echo "</table>";

echo "<p>Также посмотрите чего другие пользователи хотят от вас:</p>";

try {
    $sqlCommand = "SELECT t.id, t.description, t.date_added, t.is_done, us.login as assigned_user_name, u.login as user_name 
                   FROM task t 
                   JOIN user u ON u.id = t.user_id 
                   JOIN user us ON us.id = t.assigned_user_id 
                   WHERE us.login = ? AND NOT u.login = ?";
    $db = new PDO("mysql:host=localhost;dbname=neto;charset=utf8", 'mysql', 'mysql');
    $query = $db->prepare($sqlCommand);
    $query->execute([$login,$login]);
}
catch (PDOException $e) {
    echo "Ошибки query: ";
    echo $e->getMessage();
}

echo "<table border='1'>";
echo "<tr><th>Описание задачи</th><th>Дата создания</th><th>Статус</th><th>Действия</th><th>Ответственный</th><th>Автор</th></tr>";
while ($tablerows = $query->fetch()) {
    if ($tablerows[3] == 1) {
        $status = '<span style="color: green">Выполнено</span>';
    }
    else {
        $status = '<span style="color: darkorange">В процессе</span>';
    }
    echo "<tr><td>$tablerows[1]</td>
              <td>$tablerows[2]</td>
              <td>$status</td>
              <td>
                  <a href='/index.php?id=$tablerows[0]&action=edit'>Изменить</a>
                  <a href='/index.php?id=$tablerows[0]&action=done'>Выполнить</a>
                  <a href='/index.php?id=$tablerows[0]&action=delete'>Удалить</a>
              </td>
              <td>$tablerows[4]</td>
              <td>$tablerows[5]</td>";
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
<a href="logout.php">Выход</a>
</body>
</html>