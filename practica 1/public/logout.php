<?php
if (isset($_COOKIE['user_name'])) {
    setcookie('user_name', '', time() - 3600, '/');
    session_destroy(true);
    echo 'success';
} else {
    echo 'error';
}
?>