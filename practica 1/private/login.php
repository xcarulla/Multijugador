<!DOCTYPE html>
<html lang="ca" color-mode="user">

<head>
    <!-- dades tècniques de la pàgina -->
    <meta charset="utf-8">
    <title>{SITE_NAME} :: Inici de sessió</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- per a dispositius mòbils -->
    <meta name="author" content="Antonio Bueno (UdG)">
    <!-- estètica de la pàgina -->
    <link rel="icon" href="/favicon.png">
    <link rel="stylesheet" href="mvp.css">
    <link rel="stylesheet" href="el_meu.css">
    <!-- per afegir interactivitat a la pàgina -->
    <script defer src="login.js"></script>

    <!-- reCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <!-- contingut visible de la pàgina -->
    <main>
        <header>
            <h1>{SITE_NAME}</h1>
            <div>{FEEDBACK}</div>
        </header>
        <section>
            <form id="form" method="{METHOD}" action="{LOGIN_LOGOUT_URL}">
                <header>
                    <h2>Inici de sessió</h2>
                </header>
                <label for="login_username">Nom d'usuari</label>
                <input id="login_username" type="text" name="user_name" value="{LOGIN_USERNAME}" />
                <label for="login_password">Contrasenya</label>
                <input id="login_password" type="password" name="user_password" />
                <div id="errorDades" class="error"></div>
                </br>
				<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LdZGDooAAAAAIbL84LHgRol1OgaXvQk7XMEyxkK"></div>
                <div id="errorReCaptcha" class="error"></div>
				</br>
                <input id="recordam" type="checkbox" name="recordam" value="1">
                <label for="recordam"> Recorda'm </label><br>
                <input type="submit" name="login" value="Iniciar sessió" />
                <a href="{PASS_MAIL_URL}">{PASS_MAIL}</a>
            </form>
        </section>
        <section>
            <div>
                <a href="{REGISTER_URL}">Registra un nou compte</a>
            </div>
        </section>
    </main>
</body>

</html>