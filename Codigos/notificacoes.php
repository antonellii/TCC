<?php
include_once('../cadastro/conexao.php');
function inserirNotificacao($user_id, $mensagem, $conexao) {

    $mensagem = $conexao->real_escape_string($mensagem);

    $sql = "INSERT INTO notifications (user_id, mensagem, lida) VALUES ('$user_id', '$mensagem', 0)";
    if ($conexao->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    
}
function novaNotificacao($user_id, $mensagem, $conexao) {

    $mensagem = $conexao->real_escape_string($mensagem);

    $sql = "INSERT INTO notifications (user_id, mensagem, lida) VALUES ('$user_id', '$mensagem', 0)";
    if ($conexao->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    
}


?>
