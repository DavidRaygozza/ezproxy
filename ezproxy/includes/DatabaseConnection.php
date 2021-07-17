<?php
   $pdo = new PDO('mysql:host=10.100.200.148;dbname=ezproxy;charset=utf8', 'ezproxyuser', 'Fall2010!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
