<?php

function getUtenti($db) {
    $result = $db->exec('SELECT * FROM utente ORDER BY ruolo DESC');
    return $result;
}

function getUtenteByEmail($db, $email) {
    $result = $db->exec('SELECT * FROM utente WHERE email = ?', $email);
    return $result;
}
function getUtenteByCognome($db, $cognome) {
    $result = $db->exec('SELECT * FROM utente WHERE cognome LIKE ?', "%$cognome%");
    return $result;
}
function getUtenteById($db, $id) {
    $result = $db->exec('SELECT * FROM utente WHERE id = ?', $id);
    return $result;
}

function addUtente($db, $data) {
    $result = $db->exec('INSERT INTO utente (nome, cognome, email, ruolo, piano, sospensione, ban, fine_sospensione) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        $data['nome'], $data['cognome'], $data['email'], $data['ruolo'], $data['piano'], $data['sospensione'], $data['ban'], $data['fine_sospensione']);
    return $result;
}

function deleteUtente($db, $id) {
    $result = $db->exec('DELETE FROM utente WHERE id = ?', $id);
    return $result;
}

//function updateUtente($db, $data) {
//    $result = $db->exec('UPDATE utente SET nome = ?, cognome = ?, email = ?, ruolo = ?, piano = ?, sospensione = ?, ban = ?, fine_sospensione = ? WHERE id = ?',
//        $data['nome'], $data['cognome'], $data['email'], $data['ruolo'], $data['piano'], $data['sospensione'], $data['ban'], $data['fine_sospensione'], $data['id']);
//    return $result;
//}
function updateUtente($db, $data) {
    $result = $db->exec('UPDATE utente SET ruolo = ?, sospensione = ?, ban = ?, fine_sospensione = ? WHERE id = ?',
        $data['ruolo'], $data['sospensione'], $data['ban'], $data['fine_sospensione'], $data['id']);
    return $result;
}

?>
