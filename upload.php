<?php
session_start();
include_once('cadastro/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $nome = $_POST['nome'];
    $descricao = nl2br($_POST['descricao']);

    // Verifica se foi enviada uma imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_temporaria = $_FILES['imagem']['tmp_name'];
        $nome_imagem = $_FILES['imagem']['name'];
        $tipoArte = $_POST['tipo'];

        // Move a imagem para o diretório desejado (neste exemplo, o diretório 'uploads')
        $caminho_destino = 'uploads/' . $nome_imagem;
        move_uploaded_file($imagem_temporaria, $caminho_destino);
    } else {
        die("Erro ao enviar a imagem.");
    }

    $id_user = $_SESSION['id_usuario'];
    $sqlBuscarNick = "SELECT nick FROM users WHERE id = ?";
    $stmt = $conexao->prepare($sqlBuscarNick);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $resultadoBuscaNick = $stmt->get_result();

    if ($resultadoBuscaNick->num_rows > 0) {
        $row = $resultadoBuscaNick->fetch_assoc();
        $nick_usuario = $row['nick'];
    } else {
        echo "<script>alert('Usuário não encontrado'); window.location.href = 'paginaPrincipal.php';</script>";
    }

    // Inicia a transação
    $conexao->begin_transaction();

    // Insere os dados do post na tabela de posts
    $sql = "INSERT INTO Posts (imagem, nome, tipoArt, descricao, id_user) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssi", $caminho_destino, $nome, $tipoArte, $descricao, $id_user);

    if ($stmt->execute()) {
        $newPostId = $conexao->insert_id;

        // Restante do seu código com prepared statements
        // ...

        // Commit a transação
        $conexao->commit();
        echo "<script>alert('Post cadastrado!'); window.location.href = 'paginaPrincipal.php';</script>";
    } else {
        // Rollback da transação em caso de erro
        $conexao->rollback();
        echo "<script>alert('Erro ao cadastrar post'); window.location.href = 'paginaPrincipal.php';</script>";
    }

    // Fecha a conexão com o banco de dados
    $conexao->close();
}
?>
