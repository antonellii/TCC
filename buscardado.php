<?php 
session_start();
$id_user = $_SESSION['id_usuario'];

include_once('cadastro/conexao.php');

$sql = "SELECT perfil, nick FROM users WHERE id = $id_user";
$result = $conexao->query($sql);

// Exibir os resultados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $perfil = $row["perfil"];
    $nick = $row["nick"];
} else {echo "Nenhum resultado encontrado.";}

?>
