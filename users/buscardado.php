<?php
session_start();
$id_user = $_SESSION['id_usuario'];

include_once('../cadastro/conexao.php');

$sql = "SELECT nome, nick, email, perfil, backFoto, tipoArt, bio FROM users WHERE id = $id_user";
$result = $conexao->query($sql);

// Consulta SQL para buscar os posts do usuário
$posts_sql = "SELECT * FROM posts WHERE id_user = '$id_user'";
$posts_result = $conexao->query($posts_sql);

// Exibir os resultados do usuário
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $perfil = "../cadastro/" . $row["perfil"];
    $backFoto = "../cadastro/" . $row["backFoto"];
    $nome = $row["nick"];
    $tipoArt = $row["tipoArt"];
    $bio = $row['bio'];

    $posts_sql = "SELECT * FROM posts WHERE id_user = '$id_user' ORDER BY data DESC";
    $posts_result = $conexao->query($posts_sql);

    $sql_numero_seguidores = "SELECT COUNT(*) AS num_seguidores FROM seguidores WHERE seguindo_id = $id_user";
    $result_numero_seguidores = $conexao->query($sql_numero_seguidores);
    $row_numero_seguidores = $result_numero_seguidores->fetch_assoc();
    $num_seguidores = $row_numero_seguidores['num_seguidores'];

    // Verificar o número de pessoas que a pessoa segue
    $sql_numero_seguindo = "SELECT COUNT(*) AS num_seguindo FROM seguidores WHERE seguidor_id = $id_user";
    $result_numero_seguindo = $conexao->query($sql_numero_seguindo);
    $row_numero_seguindo = $result_numero_seguindo->fetch_assoc();
    $num_seguindo = $row_numero_seguindo['num_seguindo'];
} else {
    echo "Nenhum resultado encontrado.";
}

// Fechar a conexão
?>