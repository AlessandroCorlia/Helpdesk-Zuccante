<?php
session_start();
if (!isset($_SESSION['google_loggedin']) || $_SESSION['google_loggedin'] !== TRUE) {
    header('Location: auth.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il Mio Account</title>
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
    #tableButton a{
        color: black;
    }
    #tableButton a:hover{
        color: blueviolet;
    }
    td{
        width: fit-content;
        border: 1px black solid;
    }
    tr{
        font-weight: bold;
    }
    th{
        width: fit-content;
        border: 1px black solid;
    }
    #dati{
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        border: 10px white solid;
        border-radius: 20px;
        box-shadow: black 0 0 10px;
        background-color: white;
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
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        box-shadow: black 0 0 10px;
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
                <a href="myaccount.php">
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
    <?php if ($_SESSION['google_role'] === 'amministratore') : ?>
        <a href="amministratore">
            <i>admin_panel_settings</i>
            <span>Amministrazione</span>
        </a>
    <?php endif; ?>
    <a href="logout">
        <i>logout</i>
        <span>Logout</span>
    </a>
</div>
</div>
<div class="container">
    <h1>Ciao <?php echo $_SESSION['google_name']. ' ' . $_SESSION['google_surname']; ?>!</h1>
    <div class="tabs center-align" id="tableButton">
        <a class="active" onclick="showTab('dati')">I miei dati</a>
        <a onclick="showTab('segnalazioni')">Le mie segnalazioni</a>
    </div>
    <br>
    <br>
    <div id="dati" class="tab-content">
        <!--        <img src="--><?php //echo $_SESSION['google_picture']; ?><!--" alt="Profile Picture">-->
        <p><strong>Nome:</strong> <?php echo $_SESSION['google_name']; ?></p>
        <p><strong>Cognome:</strong> <?php echo $_SESSION['google_surname']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['google_email']; ?></p>
        <p><strong>Ruolo: </strong> <?php echo $_SESSION['google_role']; ?></p>
    </div>
</div>
<div id="segnalazioni" class="tab-content" style="display: none;">
    <table class="border">
        <!-- Intestazione della tabella -->
        <tr>
            <th>Id</th>
            <th>Aula</th>
            <th>Dispositivo</th>
            <th>Data</th>
            <th>Tipo</th>
            <th>Stato</th>
        </tr>
        <!-- Corpo della tabella -->
        <tbody id="segnalazioniTableBody"></tbody>
        <!-- Piede della tabella -->
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Aula</th>
            <th>Dispositivo</th>
            <th>Data</th>
            <th>Tipo</th>
            <th>Stato</th>
        </tr>
        </tfoot>
    </table>
</div>
</body>
<script>
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
    function showTab(tabName) {
        // Nascondi tutti i contenuti delle schede
        var tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(function(content) {
            content.style.display = 'none';
        });

        // rimosso la classe "active" da tutti i link delle schede
        var tabLinks = document.querySelectorAll('.tabs a');
        tabLinks.forEach(function(link) {
            link.classList.remove('active');
        });

        document.getElementById(tabName).style.display = 'block';

        //aggiunta la classe "active" al link della scheda selezionata
        var selectedTabLink = document.querySelector('.tabs a[data-tab="' + tabName + '"]');
        selectedTabLink.classList.add('active');
    }
        fetch(` ../HelpdeskAPI/segnalazioniUtente?id_utente=${<?php echo $_SESSION['google_id']; ?>}`)
            .then(response => response.json())
            .then(data => {
                const segnalazioniTableBody = document.getElementById('segnalazioniTableBody');
                segnalazioniTableBody.innerHTML = '';
                data.forEach(segnalazione => {
                    const tr = document.createElement('tr');
                    let statoS = '';
                    switch (segnalazione.stato) {
                        case 'eseguita':
                            statoS= 'color: green';
                            break;
                        case 'in_attesa':
                            statoS = 'color: orange';
                            break;
                        case 'fallita':
                            statoS = 'color: red';
                            break;
                        default:
                            statoS = '';
                    }
                    tr.innerHTML = `
                        <td>${segnalazione.id}</td>
                        <td>${segnalazione.nome}</td>
                        <td>${segnalazione.Dnome ? segnalazione.Dnome : 'non presente'}</td>
                        <td>${segnalazione.data}</td>
                        <td>${segnalazione.tipo}</td>
                        <td style="${statoS}">${segnalazione.stato}</td>



                    `;
                    segnalazioniTableBody.appendChild(tr);
                });
            });


</script>
</html>

