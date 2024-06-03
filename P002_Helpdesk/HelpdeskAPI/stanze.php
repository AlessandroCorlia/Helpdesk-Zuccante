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
    <title>Elenco Stanze - Helpdesk ITIS Zuccante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
    <style>

        .filter-menu {
            display: flex;
            justify-content: center;
            margin-top: 20px;

        }
        #progressIndicator{
            margin-left: auto;
            margin-right: auto;

        }
        #searchInput{
            width: 100%;

        }
        #searchInput:focus{
            border-color: blueviolet;
        }
        .field{
            margin-right: 10px;
            margin-top: auto;
        }
        body{
            background-color: #dad5ed;
        }
        #accountIcon{
            position: absolute;
            right: 0;
            top: 0;
        }
        #accountIcon a {
            display: block;
            height: 100%;
        }
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
        #filters{
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            border: 10px white solid;
            border-radius: 20px;
            box-shadow: black 0 0 10px;
            background-color: white;
        }
        .notification-icon {
            position: absolute;
            top: -10px;
            left: -55px;
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

        .notification-icon.alerted:hover i {
            color: black;
        }

        #symbol{
            font-size: 35px;
        }
        p {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 18px;
        }
        #stanze-container{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }


    </style>
</head>
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
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE && $_SESSION['google_role'] === 'amministratore') : ?>
        <a href="amministratore">
            <i>admin_panel_settings</i>
            <span>Amministratore</span>
        </a>
    <?php endif; ?>
    <!--se l'utente è loggato viene mostrato il link per il logout-->
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
        <a href="logout">
            <i>logout</i>
            <span>Logout</span>
        </a>
    <?php endif; ?>
</div>
</div>
<h1>Elenco delle Stanze</h1>
<div id="filters">
    <div class="field label suffix border round">
        <input type="text" oninput="searchStanza()" class="search-input" id="searchInput">
        <label>Ricerca Stanze</label>
        <i>search</i>
    </div>
    <!-- Menu dei filtri -->
    <div class="filter-menu">
        <div class="field label suffix border round">
            <select id="pianoFilter" onchange="filterByPiano(this.value)">
                <option value="">Filtro per Piano</option>
                <option value="terra">Terra</option>
                <option value="primo">Primo</option>
                <option value="secondo">Secondo</option>
            </select>
            <label>Piano</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona piano dell'aula</span>
        </div>
        <div class="field label suffix border round">
            <select id="tipoFilter" onchange="filterByType(this.value)">
                <option value="">Filtro per Tipo di Aula</option>
                <option value="aula">Aule</option>
                <option value="laboratorio">Laboratori</option>
                <option value="ufficio">Uffici</option>
                <option value="palestra">Palestra</option>
                <option value="spogliatoio">Spogliatoi</option>
                <option value="bagno">Bagni</option>
            </select>
            <label>Tipologia</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona tipologia dell'aula</span>
        </div>
    </div>
    </div>
    <progress id="progressIndicator" class="circle" style="display: none;"></progress>

<div class="container">
    <div id="stanze-container"></div>
</div>

<!-- Template per la postcard delle stanze -->
<template id="stanza-card-template">
    <article class="round border">
        <div class="row">
            <span class="material-symbols-outlined" id="symbol"></span>
            <div class="max">
                <h5 class="stanza-nome">Nome Stanza</h5>
                <p class="stanza-info">Informazioni sulla stanza</p>
                    <a class="notification-icon">
                        <span class="material-symbols-outlined">
                            <?php if ($_SESSION['google_role'] === 'tecnico') : ?>
                            <i id="notify" class="fill">notifications</i>
                        </span>
                            <?php endif; ?>
                    </a>
            </div>
        </div>
        <nav>
            <button class="stanza-button" data-id="id_stanza">Segnala</button>
            <button class="dispositivi-button" data-id="id_stanza">Dispositivi</button>
        </nav>
    </article>
</template>


<script>
    let stanze = [];
    loadStanze();

    function createStanzaCard(stanza) {
        const template = document.querySelector('#stanza-card-template');
        const clone = template.content.cloneNode(true);
        const card = clone.querySelector('.border'); // card di ciascuna classe
        card.querySelector('.stanza-nome').innerText = stanza.nome;
        if(stanza.numero == null){
            card.querySelector('.stanza-info').innerText = `Piano: ${stanza.piano}, Tipo: ${stanza.tipo}`;
        } else{
            card.querySelector('.stanza-info').innerText = `Numero: ${stanza.numero}, Piano: ${stanza.piano}, Tipo: ${stanza.tipo}`;
        }
        //se il nome della stanza è WC allora non inserire il pulsante dispositivi
        if(stanza.nome === "WC"){
            card.querySelector('.dispositivi-button').style.display = "none";
        }
        // icona in base a tipo aula
        switch (stanza.tipo) {
            case 'aula':
                card.querySelector('#symbol').innerText = 'school';
                break;
            case 'laboratorio':
                card.querySelector('#symbol').innerText = 'science';
                break;
            case 'ufficio':
                card.querySelector('#symbol').innerText = 'work';
                break;
            case 'palestra':
                card.querySelector('#symbol').innerText = 'sports';
                break;
            case 'spogliatoio':
                card.querySelector('#symbol').innerText = 'styler';
                break;
            case 'bagno':
                card.querySelector('#symbol').innerText = 'wc';
                break;
            default:
                card.querySelector('#symbol').innerText = 'school';
                break;
        }
        //verso i dispositivi della stanza
        const dispositiviButton = card.querySelector('.dispositivi-button');
        dispositiviButton.dataset.id = stanza.id;
        dispositiviButton.addEventListener('click', () => {
            const stanzaId = dispositiviButton.dataset.id;
            window.location.href = `../HelpdeskAPI/dispositiviStanza?id_stanza=${stanzaId}`;
        });
        //verso la segnalazione della stanza
        const segnalazioneButton = card.querySelector('.stanza-button');
        dispositiviButton.dataset.id = stanza.id;
        segnalazioneButton.addEventListener('click', () => {
            const stanzaId = dispositiviButton.dataset.id;
            window.location.href = `../HelpdeskAPI/segnalazione?id_stanza=${stanzaId}`;
        });

        document.getElementById('stanze-container').appendChild(clone);


        const notificationIcon = card.querySelector('.notification-icon i');
        const notifyButton = card.querySelector('.notification-icon');

        if (<?php echo isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE ? 'true' : 'false'; ?>) {
            fetch(`../HelpdeskAPI/alert?id_utente=${<?php echo $_SESSION['google_id']; ?>}`)
                .then(response => response.json())
                .then(alerts => {
                    const stanzaId = stanza.id;
                    const alreadyAlerted = alerts.some(alert => alert.id_stanza === stanzaId);
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
            const stanzaId = stanza.id;
            if (alreadyAlerted) {
                removeAlert(stanzaId);
                notificationIcon.style.color = 'black';
                notificationIcon.classList.remove('alerted');
            } else {
                addAlert(stanzaId);
                notificationIcon.style.color = 'gold';
                notificationIcon.classList.add('alerted');
            }
        });

        return card;
    }

    function loadStanze(){
    fetch('../HelpdeskAPI/stanzeAll')
        .then(response => response.json())
        .then(data => {
            data.forEach(stanza => {
                stanze.push(
                    {
                        "div" : createStanzaCard(stanza),
                        "dati" : stanza
                    }
                );
            });
            console.log('Stanze caricate:', stanze);


        })
        .catch(error => console.error('Errore durante il recupero dei dati delle stanze:', error));
    }
    function searchStanza(){
        const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
        if (searchInput === '') {
            for (const datiStanza of stanze) {
                datiStanza["div"].style["display"] = "block";
            }
        } else {
            for (const datiStanza of stanze) {
                if(datiStanza["dati"]["nome"].toLowerCase().includes(searchInput)){
                    datiStanza["div"].style["display"] = "block";
                }
                else {
                    datiStanza["div"].style["display"] = "none";
                }
            }
        }
    }

    function filterByPiano(piano) {
        // Se il filtro è vuoto, mostra tutte le stanze
        if (piano === '') {
            for (const datiStanza of stanze) {
                datiStanza["div"].style["display"] = "block";
            }
        } else {
            for (const datiStanza of stanze) {
                if(datiStanza["dati"]["piano"] === piano){
                    datiStanza["div"].style["display"] = "block";
                }
                else {
                    datiStanza["div"].style["display"] = "none";
                }
                console.log(stanze);
            }
        }
    }

    function filterByType(type) {
        // Se il filtro è vuoto, mostra tutte le stanze
        if (type === '') {
            for (const datiStanza of stanze) {
                datiStanza["div"].style["display"] = "block";
            }
        } else {
            console.log(type);
            for (const datiStanza of stanze) {
                if(datiStanza["dati"]["tipo"] === type){
                    datiStanza["div"].style["display"] = "block";
                }
                else {
                    datiStanza["div"].style["display"] = "none";
                }
                // console.log(stanze);
            }
        }
    }
    function addAlert(stanzaId) {
        const formData = new FormData();

        formData.append('id_stanza', stanzaId);
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

    function removeAlert(stanzaId) {
        fetch(`../HelpdeskAPI/deleteAlert`, {
            method: 'DELETE',
            body: JSON.stringify({id_stanza: stanzaId})
        })
            .then(response => {
                window.alert('Alert rimosso con successo')
                if (!response.ok) {
                    throw new Error('Errore durante la rimozione dell\'alert');
                }
            })
            .catch(error => console.error('Errore:', error));
    }

    //APERTURA E CHIUSURA MENU LATERALE
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
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="no-margin">ITIS Zuccante</h5>
                <p>Indirizzo: Via Astorre Baglioni 22, Mestre (VE)</p>
                <p>Email: vetf04000t@istruzione.it</p>
                <p>Telefono: 041.5341.111</p>
            </div>
            <div class="col-md-6">
                <h5 class="no-margin">Links Utili</h5>
                <ul>
                    <li><a href="https://www.itiszuccante.edu.it/">Sito Ufficiale</a></li>
                    <li><a href="https://github.com/AlessandroCorlia">Github</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
