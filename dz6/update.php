<?php
$host = 'localhost';
$user = 'root';
$password = 'root';
$dbname = 'database_std';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['user'], $_POST['work_type'])) {
    $id = (int)$_POST['id'];
    $user = $conn->real_escape_string($_POST['user']);
    $work_type = (int)$_POST['work_type'];

    $sql = "UPDATE std_works SET user = '$user', work_type = $work_type WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Запись обновлена!";
    } else {
        echo "Ошибка обновления записи: " . $conn->error;
    }
}

$conn->close();
?>
