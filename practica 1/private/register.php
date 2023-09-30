<!DOCTYPE html>
<html lang="ca" color-mode="user">

<head>
    <!-- dades tècniques de la pàgina -->
    <meta charset="utf-8">
    <title>{SITE_NAME} :: Registre nou usuari</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- per a dispositius mòbils -->
    <meta name="author" content="Antonio Bueno (UdG)">
    <!-- estètica de la pàgina -->
    <link rel="icon" href="/favicon.png">
    <link rel="stylesheet" href="mvp.css">
    <link rel="stylesheet" href="el_meu.css">
    <!-- per afegir interactivitat a la pàgina -->
    <script defer src="compare_pass.js"></script>
    <script defer src="register.js"></script>
	
	<!-- reCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <!-- contingut visible de la pàgina -->
    <main>
        <header>
            <h1><a href="/">{SITE_NAME}</a></h1>
            <div>{FEEDBACK}</div>
        </header>
        <section>
            <form id="form" method="{METHOD}" action="{REGISTER_URL}">
                <header>
                    <h2>Crea un nou compte</h2>
                </header>
                <label for="register_username">Nom d'usuari</label>
                <input id="register_username" type="text" name="user_name" value="{REGISTER_USERNAME}" required/>
                <div id="errorUsername"></div>
                <label for="register_mail">Correu electrònic</label>
                <input id="register_mail" type="email" name="user_mail" required/>
                <div id="errorUsermail"></div>
                <label for="password">Contrassenya</label>
                <input id="password" type="password" pattern=".{8,}"name="user_password" required/>
                <label for="password_copy">Confirma la contrassenya</label>
                <input id="password_copy" type="password" pattern=".{8,}"name="user_password_copy" required/>
                <p>Mida mínima 8 caràcters.</p>
                <div id="error"></div>
				</br>
				<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LdZGDooAAAAAIbL84LHgRol1OgaXvQk7XMEyxkK"></div>
				<div id="errorReCaptcha"></div>
                </br>
                <input type="submit" name="register" value="Registrar-se" />
            </form>
        </section>
        <section>
            <div>
                <a href="{LOGIN_LOGOUT_URL}">{LOGIN_LOGOUT_TEXT}</a>
            </div>
        </section>
    </main>
</body>

</html>