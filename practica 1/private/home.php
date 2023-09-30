<!DOCTYPE html>
<html lang="ca" color-mode="user">

<head>
    <!-- dades tècniques de la pàgina -->
    <meta charset="utf-8">
    <title>{SITE_NAME}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- per a dispositius mòbils -->
    <meta name="author" content="Antonio Bueno (UdG)">
    <!-- estètica de la pàgina -->
    <link rel="icon" href="/favicon.png">
    <link rel="stylesheet" href="mvp.css">
    <link rel="stylesheet" href="el_meu.css">
    <!-- per afegir interactivitat a la pàgina -->
    <script defer src="home.js"></script>
</head>

<body>
    <!-- contingut visible de la pàgina -->
    <main>
        <header>
            <h1>{SITE_NAME}</h1>
            <div>{FEEDBACK}</div>
            <input id="username" type="hidden" value="{USER_NAME}"/>
        </header>
        <section>
            <div>
                <!-- HTML !-->
                <button id="logoutButton" class="button-62" role="button">Tancar sessió</button>

            </div>
        </section>
        <br>
        <section>
            <div>
                <button id="deleteAccount" class="button-62" role="button">Esborrar compte</button>
            </div>
        </section>
    </main>
</body>

</html>