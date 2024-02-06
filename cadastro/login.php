<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="../icones/iconinho.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Lunar</title>
</head>
<body>

    <img id="logo" src="../icones/iconinho.png" alt="logo">

	<h1>conectar</h1>
	<form method="POST" action="logar.php">
		<label for="email">E-mail:</label>
		<input type="email" name="email" placeholder="Email">
		<br>
        <label for="senha">Senha:</label>
		<input type="password" name="senha" placeholder="Senha">
		<br>
		<input class="inputSubmit" type="submit" name="submit" value="Enviar">
	</form>

</body>
</html>