<?php
session_start();
include_once('../cadastro/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_SESSION['id_usuario'];

    if (isset($_FILES['back'])) { 

        $imagem_temporaria_back = $_FILES['back']['tmp_name'];
        $nome_imagem_back = $_FILES['back']['name'];
        $caminho_destino_back = 'fotosPerfil/' . $nome_imagem_back;
        $destino = '../cadastro/fotosPerfil/' . $nome_imagem_back;

        if (move_uploaded_file($imagem_temporaria_back, $destino)) {

            $result = mysqli_query($conexao, "UPDATE users SET backFoto='$caminho_destino_back' WHERE id = $id");

            if ($result) {
                header('Location: ../config/config.php');
            } else {
                echo "<script> alert('Erro ao atualizar perfil.'); </script>";
            }
        } else {
            echo "<script> alert('Erro ao enviar a imagem.'); </script>";
        }
    } else {
        echo "<script> alert('Imagem de perfil ou imagem de fundo não foi selecionada.'); </script>";
    }
    
} else {
    echo "<script> alert('Método de requisição inválido.'); </script>";
}

$conexao->close();
?>
