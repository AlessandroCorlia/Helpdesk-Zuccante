<?php
session_start();
function getSegnalazioni($db) {
    $result = $db->exec('SELECT segnalazione.*, utente.cognome AS cognome , stanza.nome AS nome,  dispositivo.nome AS Dnome  
                        FROM segnalazione 
                        INNER JOIN utente ON segnalazione.id_utente = utente.id 
                        JOIN stanza ON segnalazione.id_stanza = stanza.id 
                        LEFT JOIN dispositivo ON segnalazione.id_dispositivo = dispositivo.id 
                        ORDER BY segnalazione.data DESC;');
    return $result;
}

function getSegnalazioneById($db, $id) {
    $result = $db->exec('SELECT * FROM segnalazione WHERE id = ?', $id);
    return $result;
}
function getSegnalazionePerPiano($db){
    $result = $db->exec('SELECT u.id AS id_tecnico, u.nome AS nome_tecnico,u.cognome AS cognome_tecnico, u.email AS email_tecnico,u.piano AS piano_tecnico, s.descrizione
                        FROM segnalazione AS s
                        LEFT JOIN utente AS u ON u.ruolo = "tecnico"
                        LEFT JOIN  stanza AS st ON s.id_stanza = st.id
                        LEFT JOIN dispositivo AS d ON s.id_dispositivo = d.id
                        WHERE  (s.tipo = "guasto_tecnico" AND u.piano = st.piano)
                            OR (s.tipo = "guasto_aula" AND u.piano = st.piano)
                            OR (s.tipo = "pulizia" AND u.piano = st.piano)
                            OR (s.tipo = "guasto_tecnico" AND u.piano = (SELECT piano FROM stanza WHERE id = d.id_stanza))
                        ORDER BY u.piano ASC;');
    return $result;
}
function getSegnalazioneByUtente($db, $id) {
//    $result = $db->exec('SELECT * FROM segnalazione WHERE id_utente = ?', $id);
    $result = $db->exec('SELECT segnalazione.*,   stanza.nome AS nome,  dispositivo.nome AS Dnome  
                        FROM segnalazione 
                        INNER JOIN utente ON segnalazione.id_utente = utente.id 
                        JOIN stanza ON segnalazione.id_stanza = stanza.id 
                        LEFT JOIN dispositivo ON segnalazione.id_dispositivo = dispositivo.id
                        WHERE id_utente = ? 
                        ORDER BY data DESC', $id);
    return $result;
}

function getSegnalazioneByUtenteF($db, $id) {
    $result = $db->exec('SELECT * FROM segnalazione WHERE id_utente = ?', $id);
    return $result;
}
function getSegnalazioniByIdDispositivo($db, $id) {
    $result = $db->exec('SELECT segnalazione.*, stanza.nome AS nome, dispositivo.nome AS Dnome, utente.cognome AS cognome  
                        FROM segnalazione 
                        JOIN stanza ON segnalazione.id_stanza = stanza.id 
                        LEFT JOIN dispositivo ON segnalazione.id_dispositivo = dispositivo.id
                        JOIN utente ON segnalazione.id_utente = utente.id
                        WHERE id_dispositivo = ? 
                        ORDER BY data DESC', $id);
    return $result;
}
function  addSegnalazione($db, $data) {
    $utente = $_SESSION["google_id"];
    var_dump($data);
    if(!isset($data["id_dispositivo"]) || strcmp($data["id_dispositivo"],"null") == 0){
      $db->exec('INSERT INTO segnalazione (id_utente, id_stanza, id_dispositivo, tipo, descrizione) VALUES (?, ?, ?, ?, ?)',
           [$utente, $data['id_stanza'], null, $data['tipo'], $data['descrizione']]);
        echo "dati inviati con successo";
    }else{
        $db->exec('INSERT INTO segnalazione (id_utente, id_stanza, id_dispositivo, tipo, descrizione) VALUES (?, ?, ?, ?, ?)',
            [$utente, $data['id_stanza'], $data['id_dispositivo'], $data['tipo'], $data['descrizione']]);
        echo "dati inviati con successo";
    }
    $lastId = $db->lastInsertId();
    addNotifica($db, ["id_stanza" => $data['id_stanza'], "id_dispositivo" => $data['id_dispositivo'], "id_segnalazione" => $lastId]);
}
function  addSegnalazionef($db, $data) {
    $utente = $data["id_utente"];
    if(!isset($data["id_dispositivo"]) || strcmp($data["id_dispositivo"],"null") == 0){
        $db->exec('INSERT INTO segnalazione (id_utente, id_stanza, id_dispositivo, tipo, descrizione) VALUES (?, ?, ?, ?, ?)',
            [$utente, $data['id_stanza'], null, $data['tipo'], $data['descrizione']]);
        echo "dati inviati con successo";
    }else{
        $db->exec('INSERT INTO segnalazione (id_utente, id_stanza, id_dispositivo, tipo, descrizione) VALUES (?, ?, ?, ?, ?)',
            [$utente, $data['id_stanza'], $data['id_dispositivo'], $data['tipo'], $data['descrizione']]);
        echo "dati inviati con successo";
    }
}

function deleteSegnalazione($db, $id) {
    $result = $db->exec('DELETE FROM segnalazione WHERE id = ?', $id);
    return $result;
}

function updateSegnalazioneStato($db, $data, $stato) {
    $result = $db->exec('UPDATE segnalazione SET stato = ? WHERE id = ?',
        $stato, $data['id']);
    return $result;
}
?>
