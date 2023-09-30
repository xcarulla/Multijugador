<?php

$user_name = $_POST['user_name'];
$user_mail = $_POST['user_mail'];
$user_pass = $_POST['user_password'];

$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);
$validacio = false;

$salt = bin2hex(random_bytes(16));
$hash = hash_pbkdf2("gost-crypto", $user_pass, $salt, 1000);

$sql = 'INSERT INTO users (user_name, user_password, salt, user_mail) VALUES (:user_name, :user_password, :salt, :user_mail)';
$query = $db->prepare($sql);
$query->bindValue(':user_name', $user_name);
$query->bindValue(':user_password', $hash);
$query->bindValue(':salt', $salt);
$query->bindValue(':user_mail', $user_mail);

if($query->execute()) {
    $validacio = true;
}

if($validacio) {
    echo "ok";
} else echo "error";

?>