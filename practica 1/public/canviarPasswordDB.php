<?php

$_password = $_POST['password'];
$_email = $_POST['email'];

$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);

$salt = bin2hex(random_bytes(16));
$hash = hash_pbkdf2("gost-crypto", $_password, $salt, 1000);

$sql = "UPDATE users 
            SET user_password=:pass, salt=:salt
            WHERE user_mail = :email";
$query = $db->prepare($sql);
$query->bindValue(':pass', $hash);
$query->bindValue(':salt', $salt);
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
