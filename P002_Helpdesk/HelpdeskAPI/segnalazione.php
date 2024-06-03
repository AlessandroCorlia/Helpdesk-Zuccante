<?php
session_start();
if (!isset($_SESSION['google_loggedin']) || $_SESSION['google_loggedin'] !== TRUE) {
    header('Location: auth');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title"></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
</head>
<style>
    .drawer {
        width: 250px;
        height: 100vh;
        background-color: #ffffff;
        position: fixed;
        top: 0;
        right: -250px;
        transition: right 0.3s ease;
        z-index: 1000;
    }
    .drawer.open {
        right: 0;
    }
    .drawer header {
        background-color: blueviolet;
        padding: 10px;
    }
    .drawer nav img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }
    .drawer nav h6 {
        margin-left: 10px;
    }
    .drawer a {
        display: block;
        padding: 10px;
        color: #333333;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    .drawer a:hover {
        background-color: #f5f5f5;
    }

    h6{
        font-size: 18px;
    }
    h2{
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .container{
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        margin-top: 100px;
        height: auto;
        border: 10px white solid;
        border-radius: 10px;
        background-color: white;
        box-shadow: black 0px 0px 10px;

    }
</style>
<body>
<header class="navbar">
    <nav>
        <button class="circle transparent" id="menuBtn">
            <i>menu</i>
        </button>
        <img src="img/Logo_zuccante.png" alt="Logo" id="logoZ">
        <span class="navbar-brand">Helpdesk ITIS Zuccante</span>
    </nav>
</header>
<div class="overlay">
<div class="drawer" id="drawer">
    <header>
        <nav>
            <i>account_circle</i>
            <h6><?php echo isset($_SESSION['google_name']) ? $_SESSION['google_name'] . ' ' . $_SESSION['google_surname'] : 'Benvenuto'; ?></h6>

        </nav>
    </header>
    <a href="../HelpdeskAPI">
        <i>Home</i>
        <span>Home</span>
    </a>
    <!-- se l'utente è loggato viene mostrato il link per il proprio account, altrimenti viene mostrato il pulsante accedi con google -->
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
        <a href="myaccount">
            <i>account_circle</i>
            <span>Il Mio Account</span>
        </a>
    <?php else: ?>
        <a href="auth">
            <i>
                <img id="google" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png">
            </i>
            <span>Accedi con Google</span>
        </a>
    <?php endif; ?>
    <?php if ($_SESSION['google_role'] === 'amministratore') : ?>
        <a href="amministratore">
            <i>admin_panel_settings</i>
            <span>Amministratore</span>
        </a>
    <?php endif; ?>
        <a href="stanze">
            <i>school</i>
            <span>Stanze</span>
        </a>
    <!--se l'utente è loggato viene mostrato il link per il logout-->
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
        <a href="logout">
            <i>logout</i>
            <span>Logout</span>
        </a>
    <?php endif; ?>
</div>
</div>
<div class="container">
    <h2>Aggiungi Segnalazione</h2>
    <p id="nomeAula"></p>
    <p id="nomeDispositivo"></p>
    <form id="segnalazioneForm" method="POST" action="segnalazioneStanza">
        <div class="field label suffix border round">
            <select id="tipoProblema" name="tipo">
                <option value="" disabled selected>Seleziona</option>
                <option value="pulizia">Pulizia</option>
                <option value="guasto_tecnico">Guasto Tecnico</option>
                <option value="guasto_aula">Guasto Aula</option>
            </select>
            <label>Tipo problema</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona il tipo di problema</span>
        </div>
        <div class="field textarea label border">
            <textarea id="descrizione" name="descrizione" rows="4" required></textarea>
            <label>Descrizione</label>
        </div>
        <input type="hidden" id="idStanza" name="id_stanza" value="<?php echo htmlspecialchars($_GET['id_stanza']); ?>">
        <input type="hidden" id="idDispositivo" name="id_dispositivo" value="<?php
        if(isset($_GET['id_dispositivo'])){
            echo htmlspecialchars($_GET['id_dispositivo']);
        } else {
                echo 'null';
            }
        ?>">


        <button type="submit" class="btn primary">Invia Segnalazione</button>
    </form>
</div>

<script>
    // MENU LATERALE
    const menuBtn = document.getElementById('menuBtn');
    const drawer = document.getElementById('drawer');
    menuBtn.addEventListener('click', () => {
        drawer.classList.toggle('open');
        drawer.classList.add("active");
        let overlay =(drawer.parentNode);
        overlay.classList.add("active");

    });
    //clicco a caso fuori dal drawer
    document.body.addEventListener('click', (event) => {
        if (!drawer.contains(event.target) && !menuBtn.contains(event.target)) {
            drawer.classList.remove('open');
            drawer.classList.remove('active');
            drawer.parentNode.classList.remove('active');
        }
    });
    function getStanzaIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id_stanza');
    }
    const idStanza = getStanzaIdFromUrl();
    fetch(`../HelpdeskAPI/stanzaId?id=${idStanza}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(stanza => {
                document.getElementById('nomeAula').textContent = `Aula: ${stanza.nome}`;
                document.getElementById('title').textContent = `Segnala ${stanza.nome} - Helpdesk ITIS Zuccante`;
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati della stanza:', error));
    const idDispositivo = new URLSearchParams(window.location.search).get('id_dispositivo');
    if (idDispositivo) {
        fetch(`../HelpdeskAPI/dispositivo?id=${idDispositivo}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(dispositivo => {
                    document.getElementById('nomeDispositivo').textContent = `Dispositivo: ${dispositivo.nome}`;
                    document.getElementById('title').textContent = `Segnala ${dispositivo.nome} - Helpdesk ITIS Zuccante`;
                });
            })
            .catch(error => console.error('Errore durante il recupero dei dati del dispositivo:', error));
    }
</script>
</body>
</html>

