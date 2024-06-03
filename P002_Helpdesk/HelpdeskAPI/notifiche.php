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
    #stanze-container {
        /*massimo 3 stanze per riga*/
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        /*gap: 10px;*/
        padding: 20px;

    }
    #stanze-container article{
        width: fit-content;
        display: block;
        margin-bottom: 10px ;

    }
    #icon{
        font-size: 40px;
        color: red;
        top: 10%;
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
        <a href="logout">
            <i>logout</i>
            <span>Logout</span>
        </a>
    <?php endif; ?>
</div>
</div>
<h2>Le mie notifiche</h2>
<div id="stanze-container"></div>

    <template id="notifica-card-template">
        <article class="round border">
            <div class="row">
                <span class="material-symbols-outlined" id="symbol">
                    <i id="icon" class="extra">report</i>
                </span>
                <div class="max">
                    <h5 class="stanza-numero"></h5>
                    <p class="dispositivo"></p>
                    <p class="autore-seg"></p>
                    <p class="data-seg"></p>
                    <p class="tipo"></p>
                    <p class="stato"></p>
                </div>
            </div>
            <nav>
                <button class="stanza-button">Modifica Stato</button>

            </nav>
        </article>
    </template>


<dialog class="modal" id="modal">
    <div class="modal-content">
        <h2>Modifica Stato</h2>
        <form id="modifica-stato">
            <div class="field label suffix small round border">
            <select name="stato" id="stato">
                <option value="eseguita">Eseguita</option>
                <option value="in_attesa">In Attesa</option>
                <option value="fallita">Fallita</option>
            </select>
                <label>Nuovo Stato</label>
                <i>arrow_drop_down</i>
                <span class="helper">Seleziona nuovo stato</span>
            </div>
            <button type="button" class="primary" onclick="salvaModificheStato()">Salva</button>
            <button type="button" class="primary" onclick="chiudiPopupStato()">Chiudi</button>
        </form>
    </div>
</dialog>
</html>
<script>
    const drawer = document.getElementById('drawer');
    const menuBtn = document.getElementById('menuBtn');
    menuBtn.addEventListener('click', () => {
        drawer.classList.toggle('open');
        drawer.classList.add("active");
        let overlay = (drawer.parentNode);
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
    const notifications = document.getElementById('stanze-container');
    const notificaCardTemplate = document.getElementById('notifica-card-template');
    const title = document.getElementById('title');
    title.innerText = 'Notifiche di ' + '<?php echo $_SESSION['google_surname'] ?> ' + '<?php echo $_SESSION['google_name'] ?>';
    fetch('../HelpdeskAPI/notificheTecnico?id_utente=<?php echo $_SESSION['google_id'] ?>')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            data.forEach(notifica => {
                if(notifica.stato !== 'eseguita'){
                const card = notificaCardTemplate.content.cloneNode(true);
                card.querySelector('.stanza-numero').innerText = "Stanza " + notifica.stanza + " - " + "("+notifica.nome +")";
                card.querySelector('.dispositivo').innerText = "Dispositivo: " + notifica.dispositivo;
                card.querySelector('.autore-seg').innerText = "Autore: " + notifica.autore;
                card.querySelector('.data-seg').innerText = "Data: " + notifica.data;
                card.querySelector('.tipo').innerText = "Tipo: " + notifica.tipo;
                card.querySelector('.stato').innerText = "Stato: " + notifica.stato;
                card.querySelector('.stanza-button').addEventListener('click', () => {
                    apriPopupModificaStato(notifica.id_segnalazione);
                });
                    switch (notifica.stato) {
                        case 'in_attesa':
                            card.querySelector('#icon').style.color = 'orange';
                            break;
                        case 'fallita':
                            card.querySelector('#icon').style.color = 'red';
                            break;
                    }
                notifications.appendChild(card);
                }

            });
        });

    function apriPopupModificaStato(id) {
        const modal = document.getElementById('modal');
        modal.showModal();
        modal.dataset.id = id;
    }
    function salvaModificheStato() {
        const modal = document.getElementById('modal');
        const id = modal.dataset.id;
        const stato = document.getElementById('stato').value;
        fetch('../HelpdeskAPI/segnalazioneStato/stato', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body:  JSON.stringify({id, stato})
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                chiudiPopupStato();
                location.reload();
            });
    }
    function chiudiPopupStato() {
        const modal = document.getElementById('modal');
        modal.close();
    }
</script>