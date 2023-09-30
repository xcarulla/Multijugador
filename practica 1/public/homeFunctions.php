<?php
$lookat = $_POST['lookat'];

if($lookat == "logout") {

    if (isset($_COOKIE['user_name'])) {
        setcookie('user_name', '', time() - 3600, '/');
        session_destroy();
        echo 'success';
    } else echo 'error';

} else if($lookat == "deleteAccount") {

    $username = $_POST['user_name'];
    $db_connection = 'sqlite:..\private\users.db';
    $db = new PDO($db_connection);
    $sql = "DELETE FROM users
                WHERE user_name=:user_name";
    $query = $db->prepare($sql);
    $query->bindValue(':user_name', $username);
    if($query->execute()) {
        if (isset($_COOKIE['user_name'])) {
            setcookie('user_name', '', time() - 3600, '/');
            session_destroy();
            echo 'success';
        } else echo 'error';
    } else echo "error";

}




?>