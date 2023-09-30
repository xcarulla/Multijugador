<?php

$password = $_POST['password'];
$user_name = $_POST['user_name'];
$lookat = $_POST['lookat'];
$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);
$validacio = false;
if($lookat == "dades"){
    $sql = "SELECT user_name FROM users
                WHERE user_password= :user_password AND user_name= :username";
    $query = $db->prepare($sql);
    $query->bindValue(':user_password', $password);
    $query->bindValue(':username', $user_name);
    $query->execute();
    $resposta = $query->fetchObject();
    if($resposta) {
        $validacio = true;
    }
}
if($validacio) {
    echo "ok";
} else echo "error";