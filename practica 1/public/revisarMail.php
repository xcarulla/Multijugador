<?php

$mail = $_POST['mail'];

$db_connection = 'sqlite:..\private\users.db';

$db = new PDO($db_connection);
$sql = "SELECT user_name FROM users
                WHERE user_mail=:_mail";
$query = $db->prepare($sql);
$query->bindValue(':_mail', $mail);
$query->execute();
$resposta = $query->fetchObject()->user_name;
if($resposta && $resposta != ""){
    echo "ok";
} else echo "error";
