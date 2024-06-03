<?php

function getAlerts($db) {
    $result = $db->exec('SELECT * FROM alert');
    return $result;
}

function getAlertById($db, $id_utente) {
    $result = $db->exec('SELECT * FROM alert WHERE id_utente = ?', $id_utente);
    return $result;
}
function getAlertByIdDispositivo($db, $id_utente, $id_dispositivo) {
    $result = $db->exec('SELECT * FROM alert WHERE id_utente = ? AND id_dispositivo = ? ', array($id_utente, $id_dispositivo));
    return $result;
}

function addAlert($db, $data) {
    $utente = $_SESSION["google_id"];
    if($_SESSION["google_role"] != "tecnico" || $_SESSION["google_role"] != "personaleATA"){
        echo "Non hai i permessi per creare un'alert";
        return;
    }
    if(!isset($data["id_dispositivo"]) || strcmp($data["id_dispositivo"],"null") == 0){
        $db->exec('INSERT INTO alert (id_utente, id_stanza, id_dispositivo) VALUES (?, ?, ?)',
            [$utente, $data['id_stanza'], null]);
        echo "dati inviati con successo";
    } else{
        $db->exec('INSERT INTO alert (id_utente, id_stanza, id_dispositivo) VALUES (?, ?, ?)',
        [$utente, $data['id_stanza'], $data['id_dispositivo']]);
        echo "dati inviati con successo";
    }
}

function deleteAlert($db, $id_stanza) {
    $result = $db->exec('DELETE FROM alert WHERE id_stanza = ?', $id_stanza);
    return $result;
}
function deleteAlertDispositivo($db, $id_dispositivo) {
    $result = $db->exec('DELETE FROM alert WHERE id_dispositivo = ?', $id_dispositivo);
    return $result;
}

function updateAlert($db, $data) {
    $result = $db->exec('UPDATE alert SET id_utente = ?, id_stanza = ?, id_dispositivo = ? WHERE id = ?',
        $data['id_utente'], $data['id_stanza'], $data['id_dispositivo'], $data['id']);
    return $result;
}

?>
