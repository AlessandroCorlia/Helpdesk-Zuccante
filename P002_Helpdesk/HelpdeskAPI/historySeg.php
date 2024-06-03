<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="titleP"></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
</head>
<style>
    #symbol{
        margin-left: 50%;
        transform: translateX(-50%);
        font-size: 50px;
        color: red;
    }
    #popup{
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: auto;
        height: auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px 0 black;
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
        <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
            <button class="circle transparent" id="accountIcon">
                <a href="myaccount">
                </a>
            </button>
        <?php endif; ?>
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
        <i>home</i>
        <span>Home</span>
    </a>
    <a href="stanze">
        <i>school</i>
        <span>Stanze</span>
    </a>
    <!-- se l'utente è loggato viene mostrato il link per il proprio account, altrimenti viene mostrato il pulsante accedi con google -->
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
        <a href="myaccount">
            <i>account_circle</i>
            <span>Il Mio Account</span>
        </a>
        <?php if ($_SESSION['google_role'] === 'amministratore') : ?>
        <a href="amministratore">
            <i>admin_panel_settings</i>
            <span>Amministratore</span>
        </a>
        <?php endif; ?>
        <a href="logout">
            <i>logout</i>
            <span>Logout</span>
        </a>

    <?php else: ?>
        <a href="auth">
            <i>
                <img id="google" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png">
            </i>
            <span>Accedi con Google</span>
        </a>
    <?php endif; ?>
    <!--se l'utente è loggato viene mostrato il link per il logout-->
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>

    <?php endif; ?>
</div>
</div>
<h1 id="title"></h1>
<div class="container">
    <div id="segnalazioni-container" class="row">
        <template id="segnalazione-card-template">
            <article class="round border">
                <div class="row">
                    <div class="max">
                        <span class="material-symbols-outlined" id="symbol">report</span>
                        <h5 class="segnalazione-tipo"></h5>
                        <p class="segnalazione-data"></p>
                    </div>
                </div>
                <nav>
                    <button class="dispositivi-button">Dettagli</button>
                </nav>
            </article>
        </template>
    </div>
</div>
<div id="popup" class="modal">
    <div class="modal-content">
        <h2>Dettagli segnalazione</h2>
            <p class="popup-descrizione"></p>
            <p class="popup-stato"></p>
            <p class="popup-autore"></p>
    </div>
    <div class="modal-footer">
        <button id="closePopup">Chiudi</button>
    </div>
</div>
</body>

<script>
    function getDispositivoIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        console.log(urlParams.get('id_dispositivo'));
        return urlParams.get('id_dispositivo');
    }
    function loadSegnalazioniForDispositivo(dispositivoId) {
        fetch(`../HelpdeskAPI/segnalazioniDispositivo?id_dispositivo=${dispositivoId}`)
            .then(response => response.json())
            .then(data => {
                const segnalazioniContainer = document.getElementById('segnalazioni-container');
                data.forEach(segnalazioni => {
                    const template = document.querySelector('#segnalazione-card-template');
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.border');
                    card.querySelector('.segnalazione-tipo').innerText = segnalazioni.tipo;
                    card.querySelector('.segnalazione-data').innerText = segnalazioni.data;
                    segnalazioniContainer.appendChild(card);
                    card.querySelector('.dispositivi-button').addEventListener('click', () => {
                        document.getElementById('popup').style.display = 'block';
                        document.querySelector('.popup-descrizione').innerText = `Descrizione: ` + segnalazioni.descrizione;
                        document.querySelector('.popup-stato').innerText = `Stato: ${segnalazioni.stato}`;
                        document.querySelector('.popup-autore').innerText = `Autore: ${segnalazioni.cognome}`;
                    });
                    document.getElementById('closePopup').addEventListener('click', () => {
                        document.getElementById('popup').style.display = 'none';
                    });

                });

            })
    }


    // Funzione di inizializzazione
    function init() {
        const id_dispositivo = getDispositivoIdFromUrl();
        if (id_dispositivo) {
            loadSegnalazioniForDispositivo(id_dispositivo);
        } else {
            console.error('ID del dispositivo non trovato nell\'URL!');
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        init();
    });
    const dispositivoId = getDispositivoIdFromUrl();
    fetch(`../HelpdeskAPI/dispositivo?id=${dispositivoId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(dispositivo => {
                document.getElementById('title').textContent = `Storia delle segnalazioni di ${dispositivo.nome}`;
                document.getElementById('titleP').textContent = `Segnalazioni di ${dispositivo.nome} - Helpdesk ITIS Zuccante`;
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati del dispositivo:', error));
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
</script>
</body>
</html>

