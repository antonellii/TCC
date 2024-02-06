<?php
session_start();
include_once('../cadastro/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_SESSION['id_usuario'];

    if (isset($_FILES['perfil'])) { 

        $imagem_temporaria_perfil = $_FILES['perfil']['tmp_name'];
        $nome_imagem_perfil = $_FILES['perfil']['name'];
        $caminho_destino_perfil = 'fotosPerfil/' . $nome_imagem_perfil;
        $destino = '../cadastro/fotosPerfil/' . $nome_imagem_perfil;

        if (move_uploaded_file($imagem_temporaria_perfil, $destino)) {

            $result = mysqli_query($conexao, "UPDATE users SET perfil='$caminho_destino_perfil' WHERE id = $id");

            if ($result) {
                header('Location: ../users/user.php');
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
