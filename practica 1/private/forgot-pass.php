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
                    <h2>Restaurar contrassenya</h2>
                </header>

                <label for="register_mail">Correu electrònic</label>
                <input id="register_mail" type="email" name="user_mail" required/>

                <input type="submit" name="forgotpass" value="Enviar" />
            </form>

        </section>
        <section>
            <div>
                <a href="{REGISTER_URL}">Registrar-me</a>
            </div>
        </section>
    </main>
</body>

</html>