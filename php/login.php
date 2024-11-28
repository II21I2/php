<?php
session_start();


$db = new mysqli('192.168.199.13', 'learn','learn','learn_manko_is364') or die('error');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];



    $result = $db->query("SELECT * FROM users WHERE email = '$email'");



    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo 'Все прошло успешно' . $user['username'];

            session_start();
            $_SESSION['user_id'] = $user['id'];

            header("Location: post.php");
            exit();
        } else {
            echo 'Попробуйте другой пароль';
        }
    } else {
        echo 'Такого пользователя не существует';
    }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
</head>

<body>
    <h2>Авторизация</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>
    </form>
</body>
</html>