<?php
session_start();

include_once('../cadastro/conexao.php');

$id_user = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["senha"])) {
    $novoEmail = $_POST["email"];
    $novaSenha = $_POST["senha"];

    if (!empty($novoEmail)) {
        $stmt = $conexao->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $novoEmail, $id_user);
    
        if ($stmt->execute()) {
            // A atualização do email foi bem-sucedida
        } else {
            echo "Erro ao atualizar o email: " . $stmt->error;
        }
    
        $stmt->close();
    }
    
    if (!empty($novaSenha)) {
    
        $stmt = $conexao->prepare("UPDATE users SET senha = ? WHERE id = ?");
        $stmt->bind_param("si", $novaSenha, $id_user);
    
        if ($stmt->execute()) {
            // A atualização da senha foi bem-sucedida
        } else {
            echo "Erro ao atualizar a senha: " . $stmt->error;
        }
    
        $stmt->close();
    }
    

    header("Location: ../config/config.php");
    exit;
}else{
    echo "<script>
    alert('Erro em atualizar o email ou senha');
    window.location.href = '../config/config.php'; // Redireciona para a página desejada
    </script>";
}
?>