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

$sql2 = "UPDATE users
            SET reset_token_hash=NULL,
                reset_token_expires_at=NULL
            WHERE user_mail= :email";
$query2 = $db->prepare($sql2);
$query2->bindValue(':email', $_email);

if($query->execute() && $query2->execute()) {
    echo "ok";
} else echo "error";
