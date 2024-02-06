<?php
session_start(); // Inicia a sessão

if (isset($_POST['submit'])) { 
    include_once('conexao.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nick = $_POST['nick'];
    $senha = $_POST['senha'];
    $perfil = "fotosPerfil/shkajsdskf87349gb.jpg";
    $backFoto = "fotosPerfil/kjmkhinfwvruiiw31.jpg";


    if (!empty($nome) && !empty($email) && !empty($nick) && !empty($senha)) {
        $result = mysqli_query($conexao, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($result) > 0) {
            echo "<script> alert('O email já existe. Por favor, tente novamente com outro email.'); </script>";
        } else {
            $result = mysqli_query($conexao, "SELECT * FROM users WHERE nome = '$nome'");
            if (mysqli_num_rows($result) > 0) {
                echo "<script> alert('O nome já existe. Por favor, tente novamente com outro nome.'); </script>";
            } else {
                $result = mysqli_query($conexao, "INSERT INTO users(nome,email,nick,senha,perfil,backFoto) VALUES ('$nome','$email','$nick','$senha', '$perfil', '$backFoto')");
                
                if ($result) {
                    $last_inserted_id = mysqli_insert_id($conexao); // Obtém o ID do último usuário inserido
                    
                    // Salva o ID do usuário na sessão
                    $_SESSION['id_usuario'] = $last_inserted_id;

                    // Redireciona para a página principal ou outra página desejada
                    header('Location: update.php');
                } else {
                    echo "<script> alert('Erro ao cadastrar usuário.'); </script>";
                }
            }
        }
    } else {
        echo "<script> alert('Todos os campos são obrigatórios'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="cadastro.css">
    <link rel="icon" href="../icones/iconinho.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Lunar</title>
    <script src="cadastro.js"></script>

</head>

    <img id="logo" src="../icones/iconinho.png" alt="logo">

	<h1>cadastrar</h1>
	<form method="POST" action="cadastro.php" enctype="multipart/form-data">
		<label for="nome">Nome:</label>
		<input type="text" name="nome" placeholder="Nome">
		<br>
		<label for="email">E-mail:</label>
		<input type="email" name="email" placeholder="E-mail">
		<br>
        <label for="telefone">Como você quer ser chamado:</label>
		<input type="text" name="nick" placeholder="Nick">
		<br>
        <label for="senha">Senha:</label>
		<input type="password" name="senha" placeholder="No maximo 20 caracteres">
        <br>
		<input class="enviar" type="submit" name="submit" value="Enviar">
	</form>

</body>
</html> 