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
    <script defer src="el_meu.js"></script>
	
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
            <form method="{METHOD}" action="{REGISTER_URL}">
                <header>
                    <h2>Crea un nou compte</h2>
                </header>
                <label for="register_username">Nom d'usuari</label>
                <input id="register_username" type="text" name="user_name" value="{REGISTER_USERNAME}" required/>
                <label for="register_mail">Correu electrònic</label>
                <input id="register_mail" type="text" name="user_mail" required/>
                <label for="register_password">Contrasenya</label>
                <input id="register_password" type="password" pattern=".{8,}"name="user_password" required/>
                <p>Mida mínima 8 caràcters.</p>
				</br>
				<div class="g-recaptcha" data-sitekey="6LdZGDooAAAAAIbL84LHgRol1OgaXvQk7XMEyxkK"></div>
				</br>
                <input type="submit" name="register" value="Crear compte" />
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