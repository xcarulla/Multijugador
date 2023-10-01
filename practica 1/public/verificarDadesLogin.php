<?php

$passwordEntrada = $_POST['password'];
$user_name = $_POST['user_name'];
$lookat = $_POST['lookat'];
$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);
$validacio = false;
if($lookat == "dades"){
    $sqlSalt = "SELECT salt FROM users
                    WHERE user_name=:username";
    $querySalt = $db->prepare($sqlSalt);
    $querySalt->bindValue(':username', $user_name);
    $querySalt->execute();
    $respostaSalt = $querySalt->fetchObject()->salt;
    if($respostaSalt && $respostaSalt != ""){
        $hash = hash_pbkdf2("gost-crypto", $passwordEntrada, $respostaSalt, 1000);

        $sql = "SELECT user_name FROM users
        WHERE user_password= :user_password AND user_name= :username AND verificat=1";
        $query = $db->prepare($sql);
        $query->bindValue(':user_password', $hash);
        $query->bindValue(':username', $user_name);
        $query->execute();
        $resposta = $query->fetchObject();
        if($resposta) {
            $validacio = true;
        }
    }
    
}
if($validacio) {
    echo "ok";
} else echo "error";