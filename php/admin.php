<?php

$db = new mysqli('192.168.199.13', 'learn','learn','learn_manko_is364') or die('error');



session_start();
if (!isset($_SESSION['user_id'])) {
    die('Неавторизованный пользователь');
}


$user_id = $_SESSION['user_id'];
$query = "SELECT role FROM users WHERE id = $user_id";
$result = $db->query($query);
$user = $result->fetch_assoc();



if ($user['role'] !== 'admin') {
    die('Недостаточно прав');
}



$result = $db->query("SELECT username, email FROM users");


if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Имя</th><th>Email</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr><td>' . htmlspecialchars($row['username']) . '</td><td>' . htmlspecialchars($row['email']) . '</td></tr>';
    }

    echo '</table>';
} else {
    echo 'Нет пользователей';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
</head>


<body>
    <h2>Админка</h2>
    
</body>
</html>