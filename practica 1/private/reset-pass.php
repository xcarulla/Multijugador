<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);


$db_connection = 'sqlite:users.db';
$db = new PDO($db_connection);
$sql = "SELECT * FROM user
        WHERE reset_token_hash = :token_hash";
$query = $db->prepare($sql);
$query->bindValue(':token_hash', $token_hash);
$query->execute();
$user = $query->fetchObject();
if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

echo "tot ok";

