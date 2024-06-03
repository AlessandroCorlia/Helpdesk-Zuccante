<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amministratore - Helpdesk ITIS Zuccante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
</head>
<style>
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
    #searchInput {
        width: 100%;
        padding: 10px;
        margin-top: auto;
        margin-bottom: 10px;
    }
    #searchInput:focus {
        border-color: blueviolet;
    }
    .search-bar {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;

    }
    #tableButton a{
        color: black;
    }
    #tableButton a:hover{
        color: blueviolet;
    }
    .border tr:nth-child(even) {
        background-color: #e8e6ff;
    }
    .border tr:hover {
        background-color: #dcc0f8;
    }
    .border th {
        background-color: mediumslateblue;
        color: white;
    }
    table{
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        box-shadow: black 0 0 10px;
    }

    td{
        border: 1px black solid;

    }
    th{

        border: 1px black solid;
    }

</style>
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
                    <i>account_circle</i>
                </a>
            </button>
        <?php endif; ?>
    </nav>
</header>
</head>
<body>
<!-- Menù laterale -->
<div class="overlay">
<div class="drawer" id="drawer">
    <header>
        <nav>
            <i>account_circle</i>
            <h6><?php echo isset($_SESSION['google_name']) ? $_SESSION['google_name'] . ' ' . $_SESSION['google_surname'] : 'Benvenuto'; ?></h6>
        </nav>
    </header>
    <!-- Link per le varie sezioni -->
    <a href="../HelpdeskAPI/">
        <i>home</i>
        <span>Home</span>
    </a>
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
    <a href="stanze">
        <i>school</i>
        <span>Stanze</span>
    </a>
    <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
        <a href="logout">
            <i>logout</i>
            <span>Logout</span>
        </a>
    <?php endif; ?>
</div>
</div>
<div class="container">
    <h2>Pagina amministratore</h2>
    <div>
        <div class="tabs center-align" id="tableButton">
            <a class="active" onclick="showTab('utenti')">Lista Utenti</a>
            <a onclick="showTab('segnalazioni')">Segnalazioni</a>
            <a onclick="showTab('aule')">Aule</a>
        </div>
        <!-- Contenuto dei tab -->
        <div id="utentiTab" class="page padding left active">
            <h3>Lista Utenti</h3>
            <div class="search-bar">
                <div class="field label suffix border round">
                    <input type="text" id="searchInput" oninput="searchUtenti()">
                    <label>Cerca per cognome</label>
                    <i>search</i>
                </div>
            </div>
            <!-- Tabella per la lista degli utenti -->

            <table class="border">
                <!-- Intestazione della tabella -->
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Ruolo</th>
                    <th>Azioni</th>
                </tr>
                <!-- Corpo della tabella -->
                <tbody id="utentiTableBody"></tbody>
                <!-- Piede della tabella -->
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Ruolo</th>
                    <th>Azioni</th>
                </tr>
                </tfoot>
            </table>

        </div>
        <!-- Tab per le segnalazioni -->
        <div id="segnalazioniTab" class="page padding left">
            <h3>Segnalazioni</h3>
            <br>
            <!-- Tabella per le segnalazioni -->
            <table class="border">
                <!-- Intestazione della tabella -->
                <tr>
                    <th>Id</th>
                    <th>Autore</th>
                    <th>Stanza</th>
                    <th>Nome Dispositivo</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
                <!-- Corpo della tabella -->
                <tbody id="segnalazioniTableBody"></tbody>
                <!-- Piede della tabella -->
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Autore</th>
                    <th>Stanza</th>
                    <th>Nome Dispositivo</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div id="auleTab" class="page padding left">
            <h3>Aule</h3>
            <br>
            <table class="border">
                <!-- Intestazione della tabella -->
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Numero</th>
                    <th>Piano</th>
                    <th>Tipo</th>
                    <th>Azioni</th>
                </tr>
                <!-- Corpo della tabella -->
                <tbody id="auleTableBody"></tbody>
                <!-- Piede della tabella -->
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Numero</th>
                    <th>Piano</th>
                    <th>Tipo</th>
                    <th>Azioni</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!--dialog per modifica utente-->
<dialog id="editUserPopup" class="modal">
    <h5>Modifica utente:</h5>
    <div class="popup-content">
        <h5 id="nomeUtente"></h5>
        <br>
        <input type="hidden" id="userId">
        <div class="field label suffix border" id="editUserRole">
            <select name="ruolo" id="ruoloUtente">
                <option value="" disabled selected>Seleziona Nuovo Ruolo</option>
                <option value="utente">Utente</option>
                <option value="tecnico">Tecnico</option>
                <option value="personaleATA">Personale ATA</option>
                <option value="amministratore">Amministratore</option>
            </select>
            <label>Ruolo</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona il ruolo</span>
        </div>
        <label class="checkbox">
            <input type="checkbox" id="banCheckbox" name="ban">
            <span>Ban</span>
        </label>

        <nav class="right-align no-space">
            <button id="modifyButton" type="button" class="primary" onclick="salvaModifiche()">Salva Modifiche</button>
            <button id="modifyButton" type="button" class="primary" onclick="chiudiPopup()">Annulla</button>
        </nav>
    </div>
</dialog>
<dialog id="editStanzaPopup" class="modal">
    <h5>Modifica Aula: </h5>
    <div class="popup-content">
<!--        campi dove posso modificare il nome e il tipo-->
        <input type="hidden" id="aulaId">
        <div class="field label suffix border">
            <input type="text" id="nomeAula" name="nomeAula">
            <label>Nome</label>
        </div>
        <div class="field label suffix border">
            <select id="pianoAula" name="pianoAula">
                <option value="" disabled selected>Seleziona Piano</option>
                <option value="terra">Terra</option>
                <option value="primo">Primo</option>
                <option value="secondo">Secondo</option>
            </select>
            <label>Piano</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona il piano</span>
        </div>
        <div class="field label suffix border">
            <select name="tipoAula" id="tipoAula">
                <option value="" disabled selected>Seleziona Tipo</option>
                <option value="aula">Aula</option>
                <option value="laboratorio">Laboratorio</option>
                <option value="ufficio">Ufficio</option>
            </select>
            <label>Tipo</label>
            <i>arrow_drop_down</i>
            <span class="helper">Seleziona il tipo</span>
        </div>
        <nav class="right-align no-space">
            <button id="modifyButton" type="button" class="primary" onclick="salvaModificheAula()">Salva Modifiche</button>
            <button id="modifyButton" type="button" class="primary" onclick="chiudiPopupAula()">Annulla</button>
        </nav>
    </div>
</dialog>
<!--dialog per conferma eliminazione-->
<dialog id="deleteConfirmationDialog" class="modal">
    <h5>Conferma Eliminazione</h5>
    <br>
    <div>Sei sicuro di voler eliminare questo utente?</div>
    <nav class="right-align no-space">
        <button class="primary" onclick="confermaEliminazione()">Conferma</button>
        <button class="primary" onclick="chiudiConfermaEliminazione()">Annulla</button>
        <input type="hidden" id="utenteDaEliminare" value="">
    </nav>
</dialog>
<dialog id="deleteConfirmDialog" class="modal">
    <h5>Conferma eliminazione</h5>
    <br>
    <div>Sei sicuro di voler eliminare questa segnalazione?</div>
    <nav class="right-align no-space">
        <button class="primary" onclick="confermaEliminazioneSeg()">Conferma</button>
        <button class="primary" onclick="chiudiConfermaEliminazioneSeg()">Annulla</button>
        <input type="hidden" id="segnalazioneDaEliminare" value="">
    </nav>
</dialog>
<dialog id="segnalazioneInfo" class="model">
    <h5>Dettagli Segnalazione</h5>
    <br>
    <div>Descrizione: <span id="descrizione"></span></div>
    <div>Stato: <span id="stato"></span></div>
    <nav class="right-align no-space">
        <button class="primary" onclick="chiudiPopup()">Chiudi</button>
    </nav>
</dialog>


</body>
<script>
    let utenti = [];
    // Funzione per ottenere la lista degli utenti
    function searchUtenti() {
        const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
        if (searchInput === '') {
            fetch('../HelpdeskAPI/utenti')
                .then(response => response.json())
                .then(data => {
                    const utentiTableBody = document.getElementById('utentiTableBody');
                    utentiTableBody.innerHTML = '';
                    data.forEach(utente => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                        <td>${utente.nome}</td>
                        <td>${utente.cognome}</td>
                        <td>${utente.email}</td>
                        <td>${utente.ruolo}</td>
                        <td>
                            <i class="material-icons" style="cursor: pointer;" onclick="apriPopupModifica('${utente.id}', '${utente.cognome}', '${utente.ruolo}', '${utente.ban}')" > edit</i>
                             <i class="material-icons" style="cursor: pointer;" onclick="deleteUtente(${utente.id})">delete</i>
                        </td>
                    `;
                        utentiTableBody.appendChild(tr);
                    });
                });
        } else {
            fetch(`../HelpdeskAPI/utente?cognome=${searchInput}`)
                .then(response => response.json())
                .then(data => {
                    const utentiTableBody = document.getElementById('utentiTableBody');
                    utentiTableBody.innerHTML = '';
                    data.forEach(utente => {
                        const tr = document.createElement('tr');
                        utentiTableBody.appendChild(tr);
                        tr.innerHTML = `
                        <td>${utente.nome}</td>
                        <td>${utente.cognome}</td>
                        <td>${utente.email}</td>
                        <td>${utente.ruolo}</td>
                        <td>
                            <i class="material-icons" style="cursor: pointer;" onclick="apriPopupModifica('${utente.id}', '${utente.cognome}', '${utente.ruolo}', '${utente.ban}')">edit</i>
                             <i class="material-icons" style="cursor: pointer;" onclick="deleteUtente(${utente.id})">delete</i>
                        </td>
                    `;
                    });
                });
        }
    }
    function getSegnalazioni(){
        fetch('../HelpdeskAPI/segnalazioni')
            .then(response => response.json())
            .then(data => {
                const segnalazioniTableBody = document.getElementById('segnalazioniTableBody');
                segnalazioniTableBody.innerHTML = '';
                data.forEach(segnalazione => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${segnalazione.id}</td>
                        <td>${segnalazione.cognome}</td>
                        <td>${segnalazione.nome}</td>
                        <td>${segnalazione.Dnome ? segnalazione.Dnome : 'non presente'}</td>
                        <td>${segnalazione.data}</td>
                        <td>
                            <i class="material-icons" style="cursor: pointer;" onclick="segnalazioneInfo(${segnalazione.id})">info</i>
                            <i class="material-icons" style="cursor: pointer;" onclick="deleteSegnalazione(${segnalazione.id})">delete</i>
                        </td>
                    `;
                    segnalazioniTableBody.appendChild(tr);
                });
            });
    }
    function getAule(){
        fetch('../HelpdeskAPI/stanzeAll')
            .then(response => response.json())
            .then(data => {
                const auleTableBody = document.getElementById('auleTableBody');
                auleTableBody.innerHTML = '';
                data.forEach(aula => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${aula.id}</td>
                        <td>${aula.nome}</td>
                        <td>${aula.numero}</td>
                        <td>${aula.piano}</td>
                        <td>${aula.tipo}</td>
                        <td>
                            <i class="material-icons" style="cursor: pointer;" onclick="apriPopupModificaAula('${aula.id}', '${aula.nome}', '${aula.piano}', '${aula.tipo}')">edit</i>
                            <i class="material-icons" style="cursor: pointer;" onclick="eliminaAula(${aula.id})">delete</i>
                        </td>
                    `;
                    auleTableBody.appendChild(tr);
                });
            });
    }


    // Funzione per mostrare il tab selezionato
    function showTab(tabName) {
        document.querySelectorAll('.page').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tabs a').forEach(tab => {
            tab.classList.remove('active');
        });

        document.getElementById(tabName + 'Tab').classList.add('active');
        document.querySelector('.tabs a[href="#' + tabName + '"]').classList.add('active');
    }

    // Quando la pagina si carica, mostra il tab "Lista Utenti" di default
    document.addEventListener("DOMContentLoaded", function() {
        getSegnalazioni()
        searchUtenti();
        getAule();
        showTab('utenti');


    });

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
    function apriPopupModifica(id, cognome, ruolo, ban) {
        document.getElementById('userId').value = id;
        document.getElementById('nomeUtente').innerText = cognome;
        document.getElementById('ruoloUtente').value = ruolo;
        console.log(ruolo)
        document.getElementById('banCheckbox').checked = ban;
        const editUserPopup = document.getElementById('editUserPopup');
        editUserPopup.setAttribute('open', true);
    }


    function salvaModifiche() {
        const userId = document.getElementById('userId').value;
        const ruoloUtente = document.getElementById('ruoloUtente').value;
        console.log(userId)
        const banCheckbox = document.getElementById('banCheckbox').checked;
        // const request = {
        //     id: userId,
        //     ruolo: ruoloUtente,
        //     ban: banCheckbox
        // }
        fetch(`../HelpdeskAPI/utenteUp/ruolo`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: userId,
                ruolo: ruoloUtente
            })
        })
            .then(response => {
                if (response.ok) {
                    chiudiPopup();
                    searchUtenti();
                    console.log(`Ruolo ${userId} aggiornato con successo`)
                } else {
                    console.error('Errore durante l\'aggiornamento dell\'utente');
                    console.log(response)
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
        fetch(`../HelpdeskAPI/utenteUp/ban`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: userId,
                ban: banCheckbox
            })
        })
            .then(response => {
                if (response.ok) {
                    chiudiPopup();
                    searchUtenti();
                    console.log(`Ban ${userId} aggiornato con successo`)
                } else {
                    console.error('Errore durante l\'aggiornamento dell\'utente');
                    console.log(response)
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
    }
    function apriPopupModificaAula (id, nome, piano, tipo){
        document.getElementById('aulaId').value = id;
        document.getElementById('nomeAula').value = nome;
        document.getElementById('pianoAula').value = piano;
        document.getElementById('tipoAula').value = tipo;
        const editStanzaPopup = document.getElementById('editStanzaPopup');
        editStanzaPopup.setAttribute('open', true);

    }
    function salvaModificheAula(){
        const aulaId = document.getElementById('aulaId').value;
        const nomeAula = document.getElementById('nomeAula').value;
        const pianoAula = document.getElementById('pianoAula').value;
        const tipoAula = document.getElementById('tipoAula').value;
        //fetch di stanzaUp/nome con metodo PUT
        fetch(`../HelpdeskAPI/stanzaUp/nome`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: aulaId,
                nome: nomeAula
            })
        })
            .then(response => {
                if (response.ok) {
                    chiudiPopupAula();
                    getAule();
                    console.log(`Nome ${aulaId} aggiornato con successo`)
                } else {
                    console.error('Errore durante l\'aggiornamento dell\'aula');
                    console.log(response)
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
        //fetch di stanzaUp/piano con metodo PUT
        fetch(`../HelpdeskAPI/stanzaUp/piano`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: aulaId,
                piano: pianoAula
            })
        })
            .then(response => {
                if (response.ok) {
                    chiudiPopupAula();
                    getAule();
                    console.log(`Piano ${aulaId} aggiornato con successo`)
                } else {
                    console.error('Errore durante l\'aggiornamento dell\'aula');
                    console.log(response)
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
        //fetch di stanzaUp/tipo con metodo PUT
        fetch(`../HelpdeskAPI/stanzaUp/tipo`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: aulaId,
                tipo: tipoAula
            })
        })
            .then(response => {
                if (response.ok) {
                    chiudiPopupAula();
                    getAule();
                    console.log(`Tipo ${aulaId} aggiornato con successo`)
                } else {
                    console.error('Errore durante l\'aggiornamento dell\'aula');
                    console.log(response)
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
    }
    function chiudiPopupAula(){
        const editStanzaPopup = document.getElementById('editStanzaPopup');
        editStanzaPopup.removeAttribute('open');
    }
    function deleteUtente(id) {
        document.getElementById('utenteDaEliminare').value = id;
        const deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.setAttribute('open', true);
    }
    function deleteSegnalazione(id){
        document.getElementById('segnalazioneDaEliminare').value = id;
        const deleteConfirmDialog = document.getElementById('deleteConfirmDialog');
        deleteConfirmDialog.setAttribute('open', true);
    }

    function confermaEliminazione() {
        const id = document.getElementById('utenteDaEliminare').value;
        fetch(`../HelpdeskAPI/deleteUtente`, {
            method: 'DELETE',
            body: JSON.stringify({
                id: id
            })
        })
            .then(response => {
                if (response.ok) {
                    // Se l'eliminazione ha avuto successo, chiudi il dialog di conferma
                    chiudiConfermaEliminazione();
                    searchUtenti();
                    window.alert('Utente eliminato con successo');
                } else {
                    console.error('Errore durante l\'eliminazione dell\'utente');
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
    }
    function confermaEliminazioneSeg(){
        const id = document.getElementById('segnalazioneDaEliminare').value;
        fetch(`../HelpdeskAPI/deleteSegnalazione`, {
            method: 'DELETE',
            body: JSON.stringify({
                id: id
            })
        })
            .then(response => {
                if (response.ok) {
                    // Se l'eliminazione ha avuto successo, chiudi il dialog di conferma
                    chiudiConfermaEliminazioneSeg();
                    getSegnalazioni();
                    window.alert('Segnalazione eliminata con successo');
                } else {
                    console.error('Errore durante l\'eliminazione della segnalazione');
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
            });
    }
    function segnalazioneInfo(id){
        fetch(`../HelpdeskAPI/segnalazioneId?id=${id}`)
            .then(response => response.json())
            .then(data => {
                const segnalazioneInfo = document.getElementById('segnalazioneInfo');
                segnalazioneInfo.setAttribute('open', true);
                //foreach
                data.forEach(segnalazione => {
                    document.getElementById('descrizione').innerText = segnalazione.descrizione;
                    document.getElementById('stato').innerText = segnalazione.stato;
                });
            });
    }

    function chiudiConfermaEliminazione() {
        const deleteConfirmationDialog = document.getElementById('deleteConfirmationDialog');
        deleteConfirmationDialog.removeAttribute('open');
    }
    function chiudiConfermaEliminazioneSeg(){
        const deleteConfirmDialog = document.getElementById('deleteConfirmDialog');
        deleteConfirmDialog.removeAttribute('open');
    }


    // Funzione per chiudere la schermata di dialogo
    function chiudiPopup() {
        const editUserPopup = document.getElementById('editUserPopup');
        const infoSeg = document.getElementById('segnalazioneInfo');
        editUserPopup.removeAttribute('open');
        infoSeg.removeAttribute('open');
    }


    function toggleDataSospensione() {
        const sospensioneCheckbox = document.getElementById('sospensioneCheckbox');
        const dataSospensioneField = document.getElementById('dataSospensioneField');

        if (sospensioneCheckbox.checked) {
            dataSospensioneField.style.display = 'block';
        } else {
            dataSospensioneField.style.display = 'none';
        }
    }


</script>
</html>
