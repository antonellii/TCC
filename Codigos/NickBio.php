<?php
session_start();
include_once('../cadastro/conexao.php');

$id_user = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_nick"])) {
        // Ação para atualizar o apelido
        $apelido = $_POST["apelido"];

        if (!empty($apelido)) {
            $stmt = $conexao->prepare("UPDATE users SET nick = ? WHERE id = ?");
            $stmt->bind_param("si", $apelido, $id_user);

            if ($stmt->execute()) {
                // A atualização do apelido foi bem-sucedida
            } else {
                echo "Erro ao atualizar o apelido: " . $stmt->error;
            }

            $stmt->close();
        }
    } elseif (isset($_POST["update_bio"])) {
        // Ação para atualizar a bio
        $bio = nl2br($_POST['bio']);

        if (!empty($bio)) {
            $stmt = $conexao->prepare("UPDATE users SET bio = ? WHERE id = ?");
            $stmt->bind_param("si", $bio, $id_user);

            if ($stmt->execute()) {
                // A atualização da bio foi bem-sucedida
            } else {
                echo "Erro ao atualizar a bio: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        echo "<script>
        alert('Nenhum botão de atualização pressionado.');
        window.location.href = '../config/config.php'; // Redireciona para a página desejada
        </script>";
    }

    header("Location: ../config/config.php");
    exit;
} else {
    echo "<script>
    alert('Erro em atualizar o bio ou apelido');
    window.location href = '../config/config.php'; // Redireciona para a página desejada
    </script>";
}
?>
