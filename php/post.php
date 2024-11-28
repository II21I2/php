<?php
session_start();

$db = new mysqli('192.168.199.13', 'learn', 'learn', 'learn_manko_is364') or die('Ошибка ' . $db->connect_error);



if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['Heading'];
        $content = $_POST['Content'];



        if (empty($title) || empty($content)) {
            die('Заполните все поля');
        }



        if ($db->query("INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')")) {
            echo 'Пост создан';
        } else {
            echo 'Ошибка ' . $db->error;
        }
    }


    $posts_result = $db->query("SELECT p.title, p.content, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.id DESC");



} else {
    echo 'Авторизируйтесь';
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
    <header>
        <form method="post">
            <input type="text" name="Heading" placeholder="Заголовок" required>
            <input type="text" name="Content" placeholder="Содержание" required>
            <button type="submit">Создать</button>
        </form>
    </header>




    <div class="posts">       
    <?php 
    if (isset($posts_result) && $posts_result->num_rows > 0) {
        echo "<h2>Все посты:</h2>";
        while ($post = $posts_result->fetch_assoc()) {
            echo "</div><hr>";
            echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
            echo "<p>Автор: " . htmlspecialchars($post['username']) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "Постов не обнаружено";
    }?>



    </div>
</body>
</html>