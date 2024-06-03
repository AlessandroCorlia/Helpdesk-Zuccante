<?php
function associateNotificaUtente($db, $id_utente, $id_notifica){
    $result = $db->exec('INSERT INTO utente_notifica (id_utente, id_notifica) VALUES (?, ?)', $id_utente, $id_notifica);
    return $result;
}
