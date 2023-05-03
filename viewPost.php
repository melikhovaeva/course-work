<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/main.css">
  <title>Document</title>
</head>
<body>
  <header>
        <nav>
            <a href="./register.php">Регистрация</a>
            <a href="./index.php">Авторизация</a>
            <a class="active" href="./addPost.php">Посты</a>
        </nav>
    </header>
  <main>
    <section class="navigation-post">
      <ul class="navigation-post__list">
        <li class="navigation-post__item"><a href="./addPost.php">Добавление</a></li>
        <li class="navigation-post__item"><a class="active" href="./viewPost.php">Просмотр постов</a></li>
      </ul>
    </section>

    <section class="news-line">
      <ul class="news-line__list">
        <?php
        require_once './vendor/connect.php';
        $sql = "SELECT * FROM sms";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            // Вывод сообщений и соответствующих хэштегов
            while($row = $result->fetch_assoc()) {
                $message_id = $row["id"];
                $message_description = $row["description"];
                $hashtag_ids_str = $row["#_id"];
                
                // Извлечение хэштегов из таблицы hashtag по списку id
                $hashtag_ids = explode(',', $hashtag_ids_str);
                $hashtags = array();
                foreach ($hashtag_ids as $hashtag_id) {
                    $sql = "SELECT * FROM hashtag WHERE id='$hashtag_id'";
                    $result_hashtag = $connect->query($sql);
                    if ($result_hashtag->num_rows > 0) {
                        $row_hashtag = $result_hashtag->fetch_assoc();
                        $hashtags[] = $row_hashtag["name"];
                    }
                }
                
                // Вывод текста сообщения и списка хэштегов
                if (!empty($hashtags)) {
                    echo "<li class='news-line__item'>"."<p class='news-line__message'>".$message_description."</p>";
                    echo "<p class='news-line__hastags'>Хэштеги: " . implode(', ', $hashtags) . "</p>";
                    echo "</li>";
                }
            }
        } else {
            echo "Нет сообщений.";
        }
        ?>
      </ul>
    </section>
  </main>
  <footer>
  </footer>
</body>
</html>