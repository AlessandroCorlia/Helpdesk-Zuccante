<?php
function getDispositivi($db){
    $result = $db->exec('SELECT * FROM dispositivo');
    return $result;
}
function getDispositivoById($db, $id){
    $result = $db->exec('SELECT nome FROM dispositivo WHERE id = ?', $id);
    return $result;
}
//function getDispositivoByNome($db, $nome, $id_stanza){
//    $result = $db->exec('SELECT * FROM dispositivo WHERE nome LIKE ? AND id_stanza = ?', "%$nome%", $id_stanza);
//    return $result;
//}
function getDispositiviByIdStanza($db, $id){
    $result = $db->exec('SELECT * FROM dispositivo WHERE id_stanza = ?', $id);
    return $result;
}
function getNameStanzaByDisp($db, $id){
    $result = $db->exec('SELECT stanza.nome AS nome_stanza
                            FROM dispositivo
                            JOIN stanza ON dispositivo.id_stanza = stanza.id
                            WHERE dispositivo.id = ?;
                            ', $id);
    return $result;
}
function addDispositivo($db, $data){
    $result = $db->exec('INSERT INTO dispositivo (nome, id_stanza) VALUES (?, ?)', $data['nome'], $data['id_stanza']);
    return $result;
}
function deleteDispositivo($db, $id){
    $result = $db->exec('DELETE FROM dispositivo WHERE id = ?', $id);
    return $result;
}
function updateDispositivo($db, $data){
    $result = $db->exec('UPDATE dispositivo SET nome = ?, id_stanza = ? WHERE id = ?', $data['nome'], $data['id_stanza'], $data['id']);
    return $result;
}
