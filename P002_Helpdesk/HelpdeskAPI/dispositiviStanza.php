<?php
session_start();
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
    article {
        width: auto;
        height: auto;
    }
    .notification-icon {
        position: absolute;
        top: -10px;
        right: 30px;
    }
    .notification-icon i {
        font-size: 30px;
        border-radius: 50%;
        padding: 10px;
        color: black;
        transition: ease-in-out 0.2s;
    }

    .notification-icon:hover i {
        box-shadow: gold 0 0 0 2px;
        border-radius: 50%;
        background-color: gold;
        color: black;
    }
    .dispositivo-nome{
        width: fit-content;
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
</div>
</div>

<div class="container">
    <h1 id="titlePage"></h1>
    <div id="dispositivi-container" class="row">
        <template id="dispositivo-card-template">
            <article class="round border">
                <div class="row">
                    <span class="material-symbols-outlined" id="symbol">desktop_windows</span>
                    <div class="max">
                        <h5 class="dispositivo-nome">Nome Dispositivo</h5>
                        <a class="notification-icon">
                        <span class="material-symbols-outlined">
                            <?php if ($_SESSION['google_role'] === 'tecnico') : ?>
                            <i class="fill">notifications</i>
                        </span>
                        <?php endif; ?>
                        </a>
                    </div>
                </div>
            </article>
        </template>
    </div>
</div>

<script>

    function getStanzaIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id_stanza');
    }

    function loadDevicesForStanza(stanzaId) {
        fetch(`/P002_Helpdesk/HelpdeskAPI/dispositivi?id_stanza=${stanzaId}`)
            .then(response => response.json())
            .then(data => {
                const dispositiviContainer = document.getElementById('dispositivi-container');
                data.forEach(dispositivo => {
                    const template = document.querySelector('#dispositivo-card-template');
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.border');
                    card.querySelector('.dispositivo-nome').innerText = dispositivo.nome;
                    dispositiviContainer.appendChild(card);
                    card.innerHTML += `
                    <nav>
                        <button class="dispositivo-button" data-id="${dispositivo.id}">Segnala</button>
                        <button class="history-button" data-id="${dispositivo.id}">Cronologia</button>
                    </nav>
                    `
                    // verso segnala
                    const segnalazioneButton = card.querySelector('.dispositivo-button');
                    segnalazioneButton.addEventListener('click', () => {
                        const dispositivoId = segnalazioneButton.dataset.id;
                        const stanzaId = getStanzaIdFromUrl();
                        window.location.href = `../HelpdeskAPI/segnalazione?id_stanza=${stanzaId}&id_dispositivo=${dispositivoId}`;
                    });
                    // verso storia
                    const historyButton = card.querySelector('.history-button');
                    historyButton.addEventListener('click', () => {
                        const dispositivoId = historyButton.dataset.id;
                        window.location.href = `../HelpdeskAPI/historySeg?id_dispositivo=${dispositivoId}`;
                    });
                    const notificationIcon = card.querySelector('.notification-icon i');
                    const notifyButton = card.querySelector('.notification-icon');
                    if (<?php echo isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE ? 'true' : 'false'; ?>) {
                        fetch(`../HelpdeskAPI/alertDispositivo?id_utente=${<?php echo $_SESSION['google_id']; ?>}&id_dispositivo=${dispositivo.id}`)
                            .then(response => response.json())
                            .then(alerts => {
                                const dispositivoId = dispositivo.id;
                                const alreadyAlerted = alerts.some(alert => alert.id_dispositivo === dispositivoId);
                                if (alreadyAlerted) {
                                    notificationIcon.style.color = 'gold';
                                    notificationIcon.classList.add('alerted');
                                }
                            })
                            .catch(error => console.error('Errore durante il recupero degli alert:', error));
                    } else {
                        notifyButton.style.display = 'none';
                    }

                    notifyButton.addEventListener('click', () => {
                        const alreadyAlerted = notificationIcon.classList.contains('alerted');
                        const stanzaId = getStanzaIdFromUrl();
                        const dispositivoId = dispositivo.id;
                        if (alreadyAlerted) {
                            removeAlert(dispositivoId);
                            notificationIcon.style.color = 'black';
                            notificationIcon.classList.remove('alerted');
                        } else {
                            addAlert(stanzaId, dispositivoId);
                            notificationIcon.style.color = 'gold';
                            notificationIcon.classList.add('alerted');
                        }
                    });
                });
            })
            .catch(error => console.error('Errore durante il recupero dei dati dei dispositivi:', error));
    }


    function init() {
        const stanzaId = getStanzaIdFromUrl();
        if (stanzaId) {
            loadDevicesForStanza(stanzaId);
        } else {
            console.error('ID della stanza non trovato nell\'URL!');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        init();
    });

    //MENU LATERALE
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

    const idStanza = getStanzaIdFromUrl();
    fetch(`../HelpdeskAPI/stanzaId?id=${idStanza}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(stanza => {
                document.getElementById('titlePage').textContent = `Elenco dispositivi ${stanza.nome}`;
                document.getElementById('title').textContent = `${stanza.nome} dispositivi - Helpdesk ITIS Zuccante`;
            });
        })
        .catch(error => console.error('Errore durante il recupero dei dati della stanza:', error));
    function addAlert(stanzaId, dispositivoId) {
        const formData = new FormData();
        formData.append('id_stanza', stanzaId);
        formData.append('id_dispositivo', dispositivoId);
        fetch('../HelpdeskAPI/addAlert', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                window.alert('Alert aggiunto con successo')
                if (!response.ok) {
                    throw new Error('Errore durante l\'aggiunta dell\'alert');
                }
            })
            .catch(error => console.error('Errore:', error));
    }

    function removeAlert(dispositivoId) {
        fetch(`../HelpdeskAPI/deleteAlertDispositivo`, {
            method: 'DELETE',
            body: JSON.stringify({id_dispositivo: dispositivoId})
        })
            .then(response => {
                window.alert('Alert rimosso con successo')
                if (!response.ok) {
                    throw new Error('Errore durante la rimozione dell\'alert');
                }
            })
            .catch(error => console.error('Errore:', error));
    }

</script>
</body>
</html>
