<?php

$_password = $_POST['password'];
$_email = $_POST['email'];

$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);

$sql = "UPDATE users 
            SET user_password=:pass
            WHERE user_mail = :email";
$query = $db->prepare($sql);
$query->bindValue(':pass', $_password);
$query->bindValue(':email', $_email);

if($query->execute()) {
    echo "ok";
} else echo "error";
