<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require '../private/PHPMailer-6.8.1/src/Exception.php';
require '../private/PHPMailer-6.8.1/src/PHPMailer.php';
require '../private/PHPMailer-6.8.1/src/SMTP.php';

// defaults
$template = 'home';
$db_connection = 'sqlite:..\private\users.db';
$configuration = array(
    '{FEEDBACK}'          => '',
    '{LOGIN_LOGOUT_TEXT}' => 'Identificar-me',
    '{LOGIN_LOGOUT_URL}'  => '/?page=login',
    '{METHOD}'            => 'GET', // es veuen els paràmetres a l'URL i a la consola (???)
    '{REGISTER_URL}'      => '/?page=register',
    '{SITE_NAME}'         => 'La meva pàgina',
    '{PASS_MAIL}'         => 'No recordo la contrassenya',
    '{PASS_MAIL_URL}'     => '/?page=passmail',
    '{PASS_RESET}'        => 'pass reset',
    '{RESET_PASS_URL}'    => '/?page=resetpass',
    '{USER_MAIL}'         => ''
);

// Comprovar cookies:
session_start();
if (!isset($_SESSION['logged_in']) && isset($_COOKIE['user_name'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_name'] = $_COOKIE['user_name'];
}else {
    $template = "login";
    $configuration['{LOGIN_USERNAME}'] = '';
}
// parameter processing
$parameters = $_GET;

if (isset($parameters['page'])) {
    if ($parameters['page'] == 'register') {
        $template = 'register';
        $configuration['{REGISTER_USERNAME}'] = '';
        $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Ja tinc un compte';
    } else if ($parameters['page'] == 'login') {
        $template = 'login';
        $configuration['{LOGIN_USERNAME}'] = '';
    } else if ($parameters['page'] == 'passmail') {
        $template = 'forgot-pass';
        //$configuration['{LOGIN_USERNAME}'] = '';
    } else if ($parameters['page'] == 'resetpass') {
        $token = $parameters['token'];

        $token_hash = hash("sha256", $token);
        
        $db = new PDO($db_connection);
        $sql = "SELECT * FROM users
                WHERE reset_token_hash = :token_hash";
        $query = $db->prepare($sql);
        $query->bindValue(':token_hash', $token_hash);
        $query->execute();
        $user = $query->fetchObject();
        if (!$user or strtotime($user->reset_token_expires_at) <= time()) {
            $template = 'bad-token';
        } else {
            $template = 'reset-pass';
            $configuration['{USER_MAIL}'] = $user->user_mail;
        }
    }   
} else if (isset($parameters['register'])) {
    $configuration['{FEEDBACK}'] = 'Creat el compte <b>' . htmlentities($parameters['user_name']) . '</b>';
    $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Tancar sessió';
} else if (isset($parameters['login'])) {
    if(isset($parameters['recordam']) && $parameters['recordam'] == 1){
        setcookie('user_name', $parameters['user_name'], time() + 2592000);
    }
    $configuration['{FEEDBACK}'] = 'Benvingut/da <b>' . htmlentities($parameters['user_name']) . '</b>';
    $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Tancar "sessió"';
    $configuration['{LOGIN_LOGOUT_URL}'] = '/?page=logout';
    $configuration['{USER_NAME}'] = htmlentities($parameters['user_name']);
    $template = "home";
} else if (isset($parameters['forgotpass'])){
    $db = new PDO($db_connection);
    $email = $parameters['user_mail'];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    date_default_timezone_set('Europe/Madrid');
    $dataExpiracio = date("Y-m-d H:i:s", time() + 60*30);

    $sql = 
    'UPDATE users
    SET reset_token_hash = :token_hash,
        reset_token_expires_at = :dataExpiracio
    WHERE 
        user_mail = :email';
    $query = $db->prepare($sql);
    $query->bindValue(':token_hash', $token_hash);
    $query->bindValue(':dataExpiracio', $dataExpiracio);
    $query->bindValue(':email', $email);
    if($query->execute()){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'multijugador1F@gmail.com';
        $mail->Password = 'gcae gvys ocku hjkz' ;   //app password
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        $mail->setFrom('multijugador1F@gmail.com', 'Multijugador Grup 1F');
        $mail->addAddress($email, 'usuari');
        $mail->isHTML(true);
        $mail->Subject = 'Restaurar contrassenya';
        $mail->Body = "<h4> Restaurar contrassenya </h4>
            Clica <a href=\"http://localhost:8000/?page=resetpass&token=$token\">aquí</a> per canviar la contrassenya.";
        if (!$mail->send()) {
            echo '<script language="javascript">alert("Error: Mail no enviat. (' . $mail->ErrorInfo . '");</script>)';
        } else {
            echo '<script language="javascript">alert("Mail enviat correctament.");</script>';
        }
        $mail->smtpClose();
    }
} else if(isset($parameters['changepass'])){

    echo $configuration['{USER_MAIL}'];

} else if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1 && isset($_COOKIE['user_name'])){
    $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Tancar "sessió"';
    $configuration['{LOGIN_LOGOUT_URL}'] = '/?page=logout';
    $configuration['{FEEDBACK}'] = 'Benvingut/da <b>' . htmlentities($_SESSION['user_name']) . '</b>';
    $configuration['{USER_NAME}'] = htmlentities($_SESSION['user_name']);
    $template = "home";
}
// process template and show output
$html = file_get_contents($template . '.php', true);
$html = str_replace(array_keys($configuration), array_values($configuration), $html);
echo $html;