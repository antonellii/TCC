<?php

include_once('../cadastro/conexao.php');
include_once('../users/buscardado.php');

$perfil = "../cadastro/" . $row["perfil"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="config.css">
    <link rel="icon" href="../icones/iconinho.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Lunar</title>

</head>

<body>
    <aside>
        <header id="logo">
            <img class="logo" src="../icones\icone.png" alt="logo">
        </header>

        <nav class="links">
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> home </i>
                    <span><a href="../paginaPrincipal.php">HOME</a></span>
                </span>
            </button>
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> &#xE8B6 </i>
                    <span><a href="../explorar/explorar.php">EXPLORAR</a></span>
                </span>
            </button>
            <button onclick="openModal()">
                <span>
                    <i class="material-symbols-outlined trans"> favorite </i>
                    <span>NOTIFICAÇÕES</span>
                </span>
            </button>
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> Add_circle </i>
                    <span><a href="../up/up.php">ADICIONAR</a></span>
                </span>
            </button>
            <button><span> 
                    <i class="material-symbols-outlined">build_circle </i>
                <span><a href="config.php">OPÇÕES</a></span>
                </span>
            </button>
            <button>
    <span>
        <div perfil2_container>
            <img src="<?php echo $perfil; ?>" alt="Foto de perfil" class="perfil2">
        </div>
        <span id="usuario">
            <a href="../users/user.php">
                <?php echo $nome; ?>
            </a>
        </span>
    </span>
</button>

        </nav>
    </aside>
    <article class="principal">
        <div class="Usuario">
            <div class="linha2">
                <div class="U">
                    <h1>CONFIGURAÇÕES DE USUARIO</h1>
                    <form method="POST" action="../Codigos/up.php" enctype="multipart/form-data">
                        <p>ATUALIZAR EMAIL: <input type="email" name="email"></p>
                        <p>ATUALIZAR SENHA: <input type="password" name="senha"></p>
                        <br>
                        <input class="enviar" type="submit" name="atualizarEmail" value="Atualizar Email">
                        <input class="enviar" type="submit" name="atualizarSenha" value="Atualizar Senha">
                    </form>
                </div>
            </div>
            <div class="linha2">
                <div class="apagar">
                    <h1 class="h2">APAGAR CONTA</h1>
                    <form method="POST" action="../Codigos/apagar.php">
                        <p>CONFIRMAR EMAIL: <input type="email" name="email"></p>
                        <p>CONFIRMAR SENHA: <input type="password" name="senha"></p>
                        <br>
                        <input class="enviar" type="submit" name="apagar" value="apagar" class="linha">
                    </form>
                </div>
            </div>
            <div class="cor">
                <div class="Imagens">
                <form action="../Codigos/prfilUp.php" method="POST" enctype="multipart/form-data">
                        <label for="perfil" class="perfil__container">
                            <h1>IMAGEM DE PERFIL</h3>
                                <input type="file" name="perfil" id="perfil">
                                <div class="perfil_preview"></div>
                        </label>
                        <br>
                        <br>
                        <input class="enviar inp1" type="submit" name="submit" value="Enviar">
                    </form>
                </div>
                <div class="Imagens2">
                <form action="../Codigos/backUp.php" method="POST" enctype="multipart/form-data">
                        <label for="back">
                            <h1>IMAGEM DE FUNDO</h1>
                            <input type="file" name="back" id="back">
                            <div class="back_preview"></div>
                        </label>
                        <br>
                        <br>
                        <input class="enviar inp2" type="submit" name="submit" value="Enviar">
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="Usuario">
            <div class="linha2">
                <div class="U">
                    <form method="POST" action="../Codigos/NickBio.php" enctype="multipart/form-data">
                        <p class="palt">ALTERAR APELIDO: <input type="text" name="apelido"></p>
                        <label for="bio">
                            <h1> Fale sobre você: </h1>
                        </label>
                        <textarea id="myTextarea" rows="6" cols="57" name="bio"
                            placeholder="ALTERAR DESCRIÇÃO"></textarea>
                        <br>
                        <input class="enviar" type="submit" name="update_nick" value="Atualizar apelido">
                        <input class="enviar" type="submit" name="update_bio" value="Atualizar bio">
                    </form>

                </div>
            </div>
            <br>

            <br>
            <button class="opcao"><a href="../Codigos/logout.php">Desconectar </a></button>

    </article>


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
    <?php 
        include('../Codigos/modalN.php');
    ?>
</body>

</html>