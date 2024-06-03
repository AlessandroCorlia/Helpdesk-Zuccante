 <?php
function getStanze($db){
    $result = $db->exec('SELECT * FROM stanza');
    return $result;
}
function getStanzaById($db, $id){
    $result = $db->exec('SELECT nome FROM stanza WHERE id = ?', $id);
    return $result;
}
function getStanzaByNome($db, $nome){
    $result = $db->exec('SELECT * FROM stanza WHERE nome LIKE ?', "%$nome%");
    return $result;
}
//getStanzabyTipo
function getStanzaByTipo($db, $tipo){
    $result = $db->exec('SELECT * FROM stanza WHERE tipo = ?', $tipo);
    return $result;
}
function getStanzaByPiano($db, $piano){
    $result = $db->exec('SELECT * FROM stanza WHERE piano = ?', $piano);
    return $result;
}
function addStanza($db, $data){
    $result = $db->exec('INSERT INTO stanza (nome, numero, piano, tipo) VALUES (?, ?, ?, ?)', $data['nome'], $data['numero'], $data['piano'], $data['tipo']);
    return $result;
}
function deleteStanza($db, $nome){
    $result = $db->exec('DELETE FROM stanza WHERE nome = ?', $nome);
    return $result;
}
function updateStanza($db, $data){
    $result = $db->exec('UPDATE stanza SET nome = ?, numero = ?, piano = ?, tipo = ? WHERE nome = ?', $data['nome'], $data['numero'], $data['piano'], $data['tipo']);
    return $result;
}
