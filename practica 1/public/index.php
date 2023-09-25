<?php

require '..\vendor\autoload.php';
use Mailgun\Mailgun;

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
    '{RESET_PASS_URL}'     => '/?page=resetpass'
);
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
    } else if ($parameters['page'] == 'resetpass')
        $template = 'reset-pass';
} else if (isset($parameters['register'])) {
    if($parameters['g-recaptcha-response']){
        $db = new PDO($db_connection);
        $sql = 'INSERT INTO users (user_name, user_password, user_mail) VALUES (:user_name, :user_password, :user_mail)';
        $query = $db->prepare($sql);
        $query->bindValue(':user_name', $parameters['user_name']);
        $query->bindValue(':user_password', $parameters['user_password']);
        $query->bindValue(':user_mail', $parameters['user_mail']);
        if ($query->execute()) {
            $configuration['{FEEDBACK}'] = 'Creat el compte <b>' . htmlentities($parameters['user_name']) . '</b>';
            $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Tancar sessió';
        } else {
            // Això no s'executarà mai (???)
            $configuration['{FEEDBACK}'] = "<mark>ERROR: No s'ha pogut crear el compte <b>"
                . htmlentities($parameters['user_name']) . '</b></mark>';
        }
    } else {
        $configuration['{FEEDBACK}'] = "<mark>ERROR: Algun dels camps clau està buit. </mark>";
    }
} else if (isset($parameters['login'])) {
    $db = new PDO($db_connection);
    $sql = 'SELECT * FROM users WHERE user_name = :user_name and user_password = :user_password';
    $query = $db->prepare($sql);
    $query->bindValue(':user_name', $parameters['user_name']);
    $query->bindValue(':user_password', $parameters['user_password']);
    $query->execute();
    $result_row = $query->fetchObject();
    if ($result_row) {
        $configuration['{FEEDBACK}'] = '"Sessió" iniciada com <b>' . htmlentities($parameters['user_name']) . '</b>';
        $configuration['{LOGIN_LOGOUT_TEXT}'] = 'Tancar "sessió"';
        $configuration['{LOGIN_LOGOUT_URL}'] = '/?page=logout';
    } else {
        $configuration['{FEEDBACK}'] = '<mark>ERROR: Usuari desconegut o contrasenya incorrecta</mark>';
    }
} else if (isset($parameters['forgotpass'])){
    $db = new PDO($db_connection);
    $email = $parameters['user_mail'];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $dataExpiracio = date("Y-m-d H:m:s", time() + 60*30);

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
        // First, instantiate the SDK with your API credentials
        $mg = Mailgun::create('78098a1a27bc16a4e6f83ad771c38524-db137ccd-674fe33e'); // For US servers
        //$mg = Mailgun::create('78098a1a27bc16a4e6f83ad771c38524-db137ccd-674fe33e', 'https://api.eu.mailgun.net'); // For EU servers

        // Now, compose and send your message.
        // $mg->messages()->send($domain, $params);
        $text = 'Click el link per restaurar la contrassenya: http://localhost:8000/index.php/?page=resetpass&token=';
        $text .= $token;
        $mg->messages()->send('sandbox84365c67bf8342188278e0fdadfeda3f.mailgun.org', [
        'from'    => 'multijugador1F@gmail.com',
        'to'      => $email,
        'subject' => 'Recuperació de contrassenya',
        'text'    => $text
        ]);
    }
}
// process template and show output
$html = file_get_contents($template . '.php', true);
$html = str_replace(array_keys($configuration), array_values($configuration), $html);
echo $html;
