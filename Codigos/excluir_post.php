<?php
include_once('../cadastro/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Realize a exclusão do post da tabela
    $sqlExcluirPost = "DELETE FROM posts WHERE id = '$postId'";
    if ($conexao->query($sqlExcluirPost) === TRUE) {
        // Redirecione de volta para a página principal ou outra página apropriada
        header("Location: ../paginaPrincipal.php");
        exit();
    } else {
        echo "Erro ao excluir o post: " . $conexao->error;
    }
}
?>
