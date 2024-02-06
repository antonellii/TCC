<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="update.css">
    <link rel="icon" href="../icones/iconinho.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Lunar</title>

</head>

<img id="logo" src="../icones/iconinho.png" alt="logo">

<h1>Atualizar seu perfil</h1>
<form method="POST" action="pup.php" enctype="multipart/form-data">
    <label for="perfil" class="perfil__container">
        <h3>Imagem do perfil</h3>
        <input type="file" name="perfil" id="perfil">
        <div class="perfil_preview"></div>
    </label>
    <br>
    <br>
    <label for="back">
        <h2>Imagme de fundo</h2>
        <input type="file" name="back" id="back">
        <div class="back_preview"></div>
    </label>
    <br>
    <br>
    <label for="tipoArt">Tipo de arte:</label>
    <select id="tipo" name="tipoArt">
        <option value="Pintura">Pintura</option>
        <option value="Desenho">Desenho</option>
        <option value="Arte_Digital">Arte Digital</option>
        <option value="Foto">Fotografia</option>
    </select>
    <br>		<br>		<br>
    <label for="bio">Fale sobre você:</label>
    <textarea id="myTextarea" rows="6" cols="57" name="bio"
        placeholder="Fale um pouco sobre você! <br> no maximo 5 linhas"></textarea>
    <p></p>
    <input class="enviar" type="submit" name="submit" value="Enviar">
</form>

<script>
document.getElementById('perfil').addEventListener('change', function (event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const perfilPreview = document.querySelector('.perfil_preview');
            perfilPreview.innerHTML = '';

            const imagem = new Image();
            imagem.src = e.target.result;
            imagem.alt = 'Imagem selecionada';
            imagem.style.height = '100%';
            perfilPreview.appendChild(imagem);
        }

        reader.readAsDataURL(input.files[0]);
    }
});

document.getElementById('back').addEventListener('change', function (event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const backPreview = document.querySelector('.back_preview');
            backPreview.innerHTML = '';

            const imagem = new Image();
            imagem.src = e.target.result;
            imagem.alt = 'Imagem selecionada';
            imagem.style.height = '100%';
            backPreview.appendChild(imagem);
        }

        reader.readAsDataURL(input.files[0]);
    }
});

</script>
</body>

</html>