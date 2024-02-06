<?php
session_start();
include_once('conexao.php');

if(isset($_POST['submit'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if(empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos!');</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

    $sql = "SELECT * FROM users WHERE email = '$email' and senha = '$senha'";
    $result = $conexao->query($sql);

    if(mysqli_num_rows($result) < 1){
        echo "<script>alert('E-mail ou senha incorretos!');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        $usuario = $result->fetch_assoc(); //*! Serve para obter informações do usuario

        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        $_SESSION['id_usuario'] = $usuario['id'];

        header('Location: ../paginaPrincipal.php');
    }

} else {
    header('Location: login.php');
    exit();
}
?>