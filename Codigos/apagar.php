<?php
session_start();
include_once('../cadastro/conexao.php');

$id_user = $_SESSION['id_usuario'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $conexao->prepare("SELECT id, senha FROM users WHERE id = ? AND email = ?");
    $stmt->bind_param("is", $id_user, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $senhaArmazenada = $row["senha"];

        if ($senha == $senhaArmazenada) {

            $stmt = $conexao->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id_user);

            if ($stmt->execute()) {
                header("Location: logout.php"); 
                exit;
            } else {
                echo "Erro ao excluir a conta: " . $stmt->error;
            }
        } else {
            echo "Senha incorreta. A conta não foi excluída.";
        }
    } else {
        echo "Email não encontrado. A conta não foi excluída.";
    }

    $stmt->close();
}

?>
