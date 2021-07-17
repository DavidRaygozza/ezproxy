<?php
    $json = file_get_contents('JSON.json');
    $json = json_decode($json);
    $user = $json->user;
    $pass = $json->pass;
    
    $pdo = new PDO('mysql:host=10.100.200.148;dbname=ezproxy;charset=utf8', $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
