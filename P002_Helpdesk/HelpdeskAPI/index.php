<?php
require 'fatfree-core-master/base.php';
require 'Entities/stanza.php';
require 'Entities/dispositivo.php';
require 'Entities/utente.php';
require 'Entities/segnalazione.php';
require 'Entities/notifica.php';
require 'Entities/alert.php';

$server = Base::instance();
session_start();

$db = new DB\SQL('mysql:host=localhost;dbname=helpdesk', 'root', '');

//ROUTE PER VIEW
$server->route('GET /amministratore', function() {
    $view = new View();
    echo $view->render("amministratore.php");
});
$server->route('GET /auth', function() {
    $view = new View();
    echo $view->render("auth.php");
});
$server->route('GET /dispositiviStanza', function() use ($server, $db) {
    $view = new View();
    echo $view->render("dispositiviStanza.php");
});
$server->route('GET /', function() {
    $view = new View();
    echo $view->render("home.php");
});
$server->route('GET /logout', function() {
    $view = new View();
    echo $view->render("logout.php");
});
$server->route('GET /myaccount', function() {
    $view = new View();
    echo $view->render("myaccount.php");
});
$server->route('GET /notifiche', function() {
    $view = new View();
    echo $view->render("notifiche.php");
});
$server->route('GET /segnalazione', function() {
    $view = new View();
    echo $view->render("segnalazione.php");
});
$server->route("GET /stanze", function (){
    $view = new View();
    echo $view->render("stanze.php");
});
$server->route('GET /historySeg', function() {
    $view = new View();
    echo $view->render("historySeg.php");
});


//ALERT
$server->route("GET /alert", function() use ($db, $server) {
    $alert = getAlertById($db, $server->get("GET")["id_utente"]);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($alert);
});
//getAlertDispositivo
$server->route("GET /alertDispositivo", function() use ($db, $server) {
    $alert = getAlertByIdDispositivo($db, $server->get("GET")["id_utente"], $server->get("GET")["id_dispositivo"]);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($alert);
});
$server->route("POST /addAlert", function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $data = $server->get('POST');
    addAlert($db, $data);
    echo json_encode(["success" => true]);
});
$server->route("DELETE /deleteAlert", function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_stanza = $data['id_stanza'];
    deleteAlert($db, $id_stanza);
    echo json_encode(["success" => "Alert eliminato"]);
});
$server->route("DELETE /deleteAlertDispositivo", function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_dispositivo = $data['id_dispositivo'];
    deleteAlertDispositivo($db, $id_dispositivo);
    echo json_encode(["success" => "Alert eliminato"]);
});

//DISPOSITIVO
$server->route("GET /dispositivi", function () use($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getDispositiviByIdStanza($db, $server->get("GET.id_stanza"));
    echo json_encode($result);
});

//$server->route("GET /dispositiviStanza", function (){
//    $view = new View();
//    echo $view->render("dispositiviStanza.php");
//});

$server->route('GET /dispositivo', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getDispositivoById($db, $server->get("GET.id"));
    echo json_encode($result);
});

$server->route('POST /dispositivo', function() use ($server, $db) {
    $data = json_decode($server->body, true);
    $result = addDispositivo($db, $data);
    echo json_encode($result);
});
$server->route('DELETE /dispositivo', function() use ($server, $db) {
    $data = json_decode($server->body, true);
    $result = deleteDispositivo($db, $data['id']);
    echo json_encode($result);
});

//assegna le notifiche ad un utente di ruolo tecnico e dello stesso piano
$server->route("GET /notificheTecnico", function() use ($db, $server) {
    $notifiche = getNotificheByTecnico($db, $server->get("GET")["id_utente"]);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($notifiche);
});

//SEGNALAZIONE
$server->route("GET /segnalazioni", function() use ($db, $server) {
    $segnalazioni = getSegnalazioni($db);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($segnalazioni);
});

$server->route("POST /segnalazioneStanza", function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $data = $server->get('POST');
    addSegnalazione($db, $data);
    header('Location: stanze');
});
$server->route("POST /segnalazioneFlutter", function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $data = $server->get('POST');
    addSegnalazionef($db, $data);
});

//getSegnelazionebyUtente
$server->route('GET /segnalazioniUtente', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getSegnalazioneByUtente($db, $server->get("GET")["id_utente"]);
    echo json_encode($result);
});
//getSegnalazioniByIdDispositivo
$server->route('GET /segnalazioniDispositivo', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getSegnalazioniByIdDispositivo($db, $server->get("GET.id_dispositivo"));
    echo json_encode($result);
});
//getSegnalazioneById
$server->route('GET /segnalazioneId', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getSegnalazioneById($db, $server->get("GET")["id"]);
    echo json_encode($result);
});
$server->route('GET /segnalazionePiano', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getSegnalazionePerPiano($db);
    echo json_encode($result);
});
//updateSegnalazioneStato
$server->route("PUT /segnalazioneStato/stato", function($server) use ($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_utente = $data['id'];
    $nuovo_stato = $data['stato'];

    $updateQuery = "UPDATE segnalazione SET stato = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_stato, $id_utente]);


    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found or no changes made']);
        return;
    }

    echo json_encode(['righe_aggiornate' => $updatedRows]);
});
$server->route('DELETE /deleteSegnalazione', function() use ($server, $db){
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    deleteSegnalazione($db, $id);
    echo json_encode(["success" => "Segnalazione eliminata"]);
});




//STANZA

$server->route("GET /stanzeAll", function() use ($db, $server) {
    $stanze = getStanze($db);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($stanze);
});
$server->route('GET /stanzaNome', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getStanzaByNome($db, $server->get("GET")["nome"]);
    echo json_encode($result);
});

//getStanzabyTipo
$server->route('GET /stanzeTipo ', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getStanzaByTipo($db, $server->get("GET")["tipo"]);
    echo json_encode($result);
});
$server->route('GET /stanzePiano', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getStanzaByPiano($db, $server->get("GET")["piano"]);
    echo json_encode($result);
});
//getStanzaById
$server->route('GET /stanzaId', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getStanzaById($db, $server->get("GET")["id"]);
    echo json_encode($result);
});
$server->route('POST /stanza', function() use ($server, $db) {
    $data = json_decode($server->body, true);
    $result = addStanza($db, $data);
    echo json_encode($result);
});
$server->route('DELETE /stanza', function() use ($server, $db) {
    $data = json_decode($server->body, true);
    $result = deleteStanza($db, $data['nome']);
    echo json_encode($result);
});
$server->route('PUT /stanzaUp/nome', function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nuovo_nome = $data['nuovo_nome'];

    $updateQuery = "UPDATE stanza SET nome = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_nome, $id]);

    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Room not found or no changes made']);
        return;
    }

    echo json_encode(['righe_aggiornate' => $updatedRows]);

});
//piano
$server->route('PUT /stanzaUp/piano', function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nuovo_piano = $data['piano'];

    $updateQuery = "UPDATE stanza SET piano = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_piano, $id]);

    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Room not found or no changes made']);
        return;
    }

    echo json_encode(['righe_aggiornate' => $updatedRows]);
});
//tipo
$server->route('PUT /stanzaUp/tipo', function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nuovo_tipo = $data['tipo'];

    $updateQuery = "UPDATE stanza SET tipo = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_tipo, $id]);

    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Room not found or no changes made']);
        return;
    }

    echo json_encode(['righe_aggiornate' => $updatedRows]);
});

//UTENTE
$server->route("GET /utenti", function() use ($db, $server) {
    $utenti = getUtenti($db);
    $server->set('CONTENT_TYPE', 'application/json');
    echo json_encode($utenti);
});
$server->route('GET /utente', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getUtenteByCognome($db, $server->get("GET")["cognome"]);
    echo json_encode($result);
});
$server->route('GET /utenteId', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getUtenteById($db, $server->get("GET")["id"]);
    echo json_encode($result);
});
//getutenteByEmail
$server->route('GET /utenteEmail', function() use ($server, $db) {
    $server->set('CONTENT_TYPE', 'application/json');
    $result = getUtenteByEmail($db, $server->get("GET")["email"]);
    echo json_encode($result);
});

$server->route('DELETE /deleteUtente', function() use ($server, $db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    deleteUtente($db, $id);
    echo json_encode(["success" => "Utente eliminato"]);
});

//$server->route('PUT /utenteUp', function() use ($server, $db) {
//    print("siamo qui");
//    $server->set('CONTENT_TYPE', 'application/json');
//    $putData = file_get_contents("php://input");
//    $decodedPutData = json_decode($putData, true);
//    updateUtente($db, $decodedPutData);
//    var_dump($decodedPutData);
//    header('Location: amministratore');
//});
$server->route("PUT /utenteUp/ruolo", function($server) use ($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_utente = $data['id'];
    $nuovo_ruolo = $data['ruolo'];

    $updateQuery = "UPDATE utente SET ruolo = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_ruolo, $id_utente]);


    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found or no changes made']);
        return;
    }

    echo json_encode(['righe_aggiornate' => $updatedRows]);
});

$server->route("PUT /utenteUp/ban", function($server) use ($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_utente = $data['id'];
    $nuovo_ban = $data['ban'];

    $updateQuery = "UPDATE utente SET ban = ? WHERE id = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->execute([$nuovo_ban, $id_utente]);

    $updatedRows = $stmt->rowCount();
    if ($updatedRows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found or no changes made']);
        return;
    }
});


$server->run();