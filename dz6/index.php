<?php
$host = 'localhost';
$user = 'root'; 
$password = 'root'; 
$dbname = 'database_std';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user'], $_POST['work_type'])) {
    $user = $conn->real_escape_string($_POST['user']);
    $work_type = (int)$_POST['work_type'];
    $action_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO std_works (user, work_type, action_date) VALUES ('$user', '$work_type', '$action_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Новая запись добавлена успешно!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$sql_worktypes = "SELECT * FROM std_workslist";
$result_worktypes = $conn->query($sql_worktypes);

$sql_works = "SELECT std_works.id, std_works.user, std_works.work_type, std_works.action_date, std_workslist.worktype 
              FROM std_works
              JOIN std_workslist ON std_works.work_type = std_workslist.id";
$result_works = $conn->query($sql_works);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Работа с данными</title>
</head>
<body>

<h2>Форма ввода данных</h2>

<form method="POST" action="">
    <label for="user">Имя пользователя:</label><br>
    <input type="text" id="user" name="user" required><br><br>

    <label for="work_type">Выберите тип работы:</label><br>
    <select name="work_type" id="work_type" required>
        <?php while ($row = $result_worktypes->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['worktype'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <input type="submit" value="Добавить запись">
</form>

<h2>Записи в таблице</h2>

<table border="1">
    <thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Тип работы</th>
            <th>Дата</th>
            <th>Редактировать</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result_works->fetch_assoc()): ?>
            <tr id="row_<?= $row['id'] ?>">
                <td>
                    <input type="text" id="user_<?= $row['id'] ?>" value="<?= htmlspecialchars($row['user']) ?>">
                </td>
                <td>
                    <select id="work_type_<?= $row['id'] ?>">
                        <?php
                        $result_worktypes->data_seek(0);
                        while ($worktype = $result_worktypes->fetch_assoc()):
                        ?>
                            <option value="<?= $worktype['id'] ?>" <?= $worktype['id'] == $row['work_type'] ? 'selected' : '' ?>>
                                <?= $worktype['worktype'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td><?= $row['action_date'] ?></td>
                <td>
                    <button onclick="saveEdit(<?= $row['id'] ?>)">Сохранить</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
    function saveEdit(id) {
        const user = document.getElementById('user_' + id).value;
        const work_type = document.getElementById('work_type_' + id).value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Запись обновлена');
            }
        };
        xhr.send('id=' + id + '&user=' + user + '&work_type=' + work_type);
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
