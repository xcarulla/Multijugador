<?php
// Mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../private/PHPMailer-6.8.1/src/Exception.php';
require '../private/PHPMailer-6.8.1/src/PHPMailer.php';
require '../private/PHPMailer-6.8.1/src/SMTP.php';

$user_name = $_POST['user_name'];
$user_mail = $_POST['user_mail'];
$user_pass = $_POST['user_password'];

// Registrar Usuari
$db_connection = 'sqlite:..\private\users.db';
$db = new PDO($db_connection);
$validacioMail = false;
$validacioUsuari = false;

$salt = bin2hex(random_bytes(16));
$hash = hash_pbkdf2("gost-crypto", $user_pass, $salt, 1000);

$sql = 'INSERT INTO users (user_name, user_password, salt, user_mail, verificat) VALUES (:user_name, :user_password, :salt, :user_mail, 0)';
$query = $db->prepare($sql);
$query->bindValue(':user_name', $user_name);
$query->bindValue(':user_password', $hash);
$query->bindValue(':salt', $salt);
$query->bindValue(':user_mail', $user_mail);

if($query->execute()) {
    $validacioUsuari = true;
}

// Enviar correu de verificació
$user_mail = $_POST['user_mail'];
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
$mail->addAddress($user_mail, 'usuari');
$mail->isHTML(true);
$mail->Subject = 'Validar correu electronic';
$mail->Body = "<h4> Validar correu electrònic </h4>
    Clica <a href=\"http://localhost:8000/?page=validateuser&mail=$user_mail\">aquí</a> per validar el compte.";
if ($mail->send()) {
    $validacioMail = true;
}

if($validacioUsuari && $validacioMail) {
    echo "ok";
} else echo "error";

?>