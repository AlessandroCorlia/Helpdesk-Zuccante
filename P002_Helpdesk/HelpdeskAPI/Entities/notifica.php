<?php

function getNotifiche($db) {
    $result = $db->exec('SELECT * FROM notifica');
    return $result;
}

function getNotificaById($db, $id) {
    $result = $db->exec('SELECT * FROM notifica WHERE id = ?', $id);
    return $result;
}

function getNotificheByTecnico($db, $id){
    $result = $db->exec('SELECT u.email AS autore, st.nome, st.numero AS stanza, s.data, s.tipo, s.stato, s.descrizione, s.id AS id_segnalazione, CASE WHEN d.nome IS NOT NULL THEN d.nome ELSE "non presente" END AS dispositivo
                        FROM utente_notifica AS an 
                        JOIN notifica AS n 
                        ON an.id_notifica = n.id
                        JOIN segnalazione AS s 
                        ON n.id_segnalazione = s.id 
                        JOIN utente AS u
                        ON s.id_utente = u.id
                        JOIN stanza AS st
                        ON n.id_stanza = st.id
                        LEFT JOIN dispositivo AS d 
                        ON n.id_dispositivo = d.id
                        WHERE an.id_utente = ?
                        GROUP BY data DESC', $id);
    return $result;
}

//function addNotifica($db, $data) {
//    $result = $db->exec('INSERT INTO notifica (id_stanza, id_dispositivo, id_segnalazione) VALUES (?, ?, ?)',
//        $data['id_stanza'], $data['id_dispositivo'], $data['id_segnalazione']);
//    return $result;
//}
function addNotifica($db, $data){
    $pianoAula = $db->exec('SELECT piano FROM stanza WHERE id = ?', $data['id_stanza']);
    $piano = $pianoAula[0]['piano'];
    $utentiPiano = $db->exec('SELECT id FROM utente WHERE ruolo = "tecnico" AND piano = ?', $piano);

    if(!isset($data["id_dispositivo"]) || $data["id_dispositivo"] == "null"){
        $db->exec('INSERT INTO notifica (id_stanza, id_dispositivo, id_segnalazione) VALUES (?, ?, ?)',
            [$data['id_stanza'], null, $data['id_segnalazione']]);
    } else {
        $db->exec('INSERT INTO notifica (id_stanza, id_dispositivo, id_segnalazione) VALUES (?, ?, ?)',
            [$data['id_stanza'], $data['id_dispositivo'], $data['id_segnalazione']]);
    }

    $lastNotificationId = $db->lastInsertId();

    foreach ($utentiPiano as $utente){
        $db->exec('INSERT INTO utente_notifica (id_utente, id_notifica) VALUES (?, ?)',
            [$utente['id'], $lastNotificationId]);
    }

    $utentiAlert = $db->exec('SELECT id_utente FROM alert WHERE id_stanza = ?', $data['id_stanza']);
    foreach ($utentiAlert as $utente){
        $db->exec('INSERT INTO utente_notifica (id_utente, id_notifica) VALUES (?, ?)',
            [$utente['id_utente'], $lastNotificationId]);
    }

    echo "Dati inviati con successo";
}

function deleteNotifica($db, $id) {
    $result = $db->exec('DELETE FROM notifica WHERE id = ?', $id);
    return $result;
}

function updateNotifica($db, $data) {
    $result = $db->exec('UPDATE notifica SET id_stanza = ?, id_dispositivo = ?, id_segnalazione = ? WHERE id = ?',
        $data['id_stanza'], $data['id_dispositivo'], $data['id_segnalazione'], $data['id']);
    return $result;
}

?>
