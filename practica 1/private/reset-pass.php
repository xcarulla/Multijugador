<!DOCTYPE html>
<html lang="ca" color-mode="user">

<head>
    <!-- dades tècniques de la pàgina -->
    <meta charset="utf-8">
    <title>{SITE_NAME} :: Canviar contrassenya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- per a dispositius mòbils -->
    <meta name="author" content="Antonio Bueno (UdG)">
    <!-- estètica de la pàgina -->
    <link rel="icon" href="/favicon.png">
    <link rel="stylesheet" href="mvp.css">
    <link rel="stylesheet" href="el_meu.css">
    <!-- per afegir interactivitat a la pàgina -->
    <script defer src="compare_pass.js"></script>
</head>

<body>
    <!-- contingut visible de la pàgina -->
    <main>
        <header>
            <h1><a href="/">{SITE_NAME}</a></h1>
            <div>{FEEDBACK}</div>
        </header>
        <section>

            <form id="form" method="{METHOD}" action="{RESET_PASS_URL}">
                <header>
                    <h2>Canviar contrassenya</h2>
                    <!-- <h3>Compte {USER_MAIL}</h3-->
                </header>

                <!-- <label for="email">Email:</label> -->
                <!-- <input id="email" type="email" name="emails" value="{USER_MAIL}" readonly/> -->
                <label for="password">Nova contrassenya:</label>
                <input id="password" pattern=".{8,}" type="password" name="password" required/>
                <label for="password_copy">Confirma la contrassenya:</label>
                <input id="password_copy" pattern=".{8,}" type="password" name="password_copy" required/>
                <div id="error"></div>
                <input type="submit" name="changepass" value="Canviar"/>
            </form>
        </section>
    </main>
</body>

</html>