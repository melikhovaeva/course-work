<?php

    session_start();
    require_once 'connect.php';

    $text = $_POST["sms"];

    preg_match_all('/#\w+/', $text, $matches);
    $hashtags = $matches[0];
  

    // Удаление хэштегов из текста сообщения
    $text_without_hashtags = preg_replace('/#\w+/', '', $text);

    // Добавление хэштегов в таблицу hashtags и сохранение их id
    $hashtag_ids = array();
    foreach ($hashtags as $hashtag) {
        $hashtag_name = str_replace('#', '', $hashtag);
        $sql = "INSERT INTO hashtag (name) VALUES ('$hashtag_name')";
        
        if ($connect->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }
        
        // Получение id добавленного хэштега и добавление в список id
        $hashtag_ids[] = $connect->insert_id;
    }

    $hashtag_ids_str = implode(',', $hashtag_ids);
    mysqli_query($connect, "INSERT INTO sms (`#_id`, `description`) VALUES ('$hashtag_ids_str', '$text_without_hashtags')");
   

    $_SESSION['message'] = 'Пост успешно добавлен!';
    header('Location: ../addpost.php');
    


