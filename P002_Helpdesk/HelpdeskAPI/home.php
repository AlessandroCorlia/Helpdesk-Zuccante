<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk - ITIS Zuccante</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/Logo_zuccante.png">
    <link href="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.css" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.5.1/dist/cdn/beer.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.1.0/dist/cdn/material-dynamic-colors.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body{
            background-color: #dad5ed;
        }
        footer{
            background-color: mediumslateblue;
            border-top: black 1px solid;
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
            color: white;
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
        p {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 18px;
        }
        /*#privacy-banner {*/
        /*    position: fixed;*/
        /*    bottom: 0;*/
        /*    width: 100%;*/
        /*    background-color: #f0f0f0;*/
        /*    padding: 10px;*/
        /*    text-align: center;*/
        /*    z-index: 9999;*/
        /*}*/

        /*#privacy-banner a {*/
        /*    color: blue;*/
        /*    text-decoration: underline;*/
        /*    cursor: pointer;*/
        /*}*/

        /*#privacy-banner button {*/
        /*    margin-left: 10px;*/
        /*}*/

        i.extra{
            color: white;
            transition: ease-in-out 0.3s;
            border-radius: 10px;
        }
        i.extra:hover{
            background-color: white;
            color: blueviolet;
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
                    <a href="myaccount">
                        <i class="extra">person</i>
                        <div class="tooltip bottom">Il mio account</div>
                    </a>
                <?php if ($_SESSION['google_role'] === 'tecnico' || $_SESSION['google_role'] === 'personaleATA') : ?>
                    <a href="notifiche">
                        <i class="extra">notifications</i>
                        <div class="tooltip bottom">Notifiche segnalazioni</div>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </header>
</head>
<body>
<div class="overlay">
    <div class="drawer m l right fill" id="drawer">
        <header>
            <nav>
                <i>account_circle</i>
                <h6><?php echo isset($_SESSION['google_name']) ? $_SESSION['google_name'] . ' ' . $_SESSION['google_surname'] : 'Benvenuto'; ?></h6>
            </nav>
        </header>
        <!-- se l'utente è loggato viene mostrato il link per il proprio account, altrimenti viene mostrato il pulsante accedi con google -->
        <?php if (isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
            <a href="myaccount">
                <i>account_circle</i>
                <span>Il Mio Account</span>
            </a>
            <!--    se l'utente è di ruolo amminiistratore, viene mostrato il link per la pagina amministratore-->
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
<div class="container-hero">
    <div class="hero-image">
        <img src="img/itiszuccante_cover.jpeg" alt="Hero Image">
        <div class="hero-content">
            <?php if(isset($_SESSION['google_loggedin']) && $_SESSION['google_loggedin'] === TRUE) : ?>
                <h2>Benvenuto, <?php echo $_SESSION['google_name'] . ' ' . $_SESSION['google_surname']; ?></h2>
                <a class="small-round" href="stanze">
                    <span class="material-symbols-outlined">school</span>
                    <span>Stanze</span>
                </a>
            <?php else: ?>
                <h2>Benvenuto nell'helpdesk dello Zuccante</h2>
            <?php endif; ?>

            <!--se l'utente non è loggato viene mostrato il pulsante accedi con google, senno no-->
               <?php if (!isset($_SESSION['google_loggedin']) || $_SESSION['google_loggedin'] !== TRUE) : ?>
                    <a class="small-round" href="auth">
                        <i>
                            <img id="google" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png">
                        </i>
                        <span>Accedi con Google</span>
                    </a>
                <?php endif; ?>
        </div>
    </div>
</div>
<div class="container">
    <p>
        Benvenuto nell'helpdesk dell'ITIS Zuccante. Da qui potrai segnalare problemi riguardanti le aule e i dispositivi della scuola in pochi click.
    </p>
</div>
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
</script>
</body>
<!--<div id="privacy-banner">-->
<!--    <p>Per offrirti una migliore esperienza, questo sito utilizza cookie di prime e terze parti e tecnologie simili. Selezionando "Accetta tutto" acconsenti al loro utilizzo. Per maggiori informazioni o per selezionare le tue preferenze clicca su "Personalizza le scelte sui cookie" o leggi la nostra <a href="/informativa-privacy">Cookie Policy</a>.</p>-->
<!--    <button id="accept-cookies">Accetta</button>-->
<!--    <button id="reject-cookies">Rifiuta</button>-->
<!--    <button id="cookies-info">Personalizza le scelte sui cookie</button>-->
<!--</div>-->

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
</html>

