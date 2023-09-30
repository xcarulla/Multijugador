<?php

$dada = $_POST['dada'];
$lookat = $_POST['lookat'];
$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);
$validacio = false;
if($lookat == "username"){
    $sql = "SELECT * FROM users
                WHERE user_name = :username";
    $query = $db->prepare($sql);
    $query->bindValue(':username', $dada);
    $query->execute();
    $resposta = $query->fetchObject();
    if(!$resposta) {
        $validacio = true;
    }
} else if($lookat == "usermail"){
    $sql = "SELECT user_mail FROM users
                WHERE user_mail= :usermail";
    $query = $db->prepare($sql);
    $query->bindValue(':usermail', $dada);
    $query->execute();
    $resposta = $query->fetchObject();
    if(!$resposta) {
        $validacio = true;
    }
}
if($validacio) {
    echo "ok";
} else echo "error";