<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="up.css">
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
                    <span><a href="up.php">ADICIONAR</a></span>
                </span>
            </button>
            <button><span> 
                    <i class="material-symbols-outlined">build_circle </i>
                <span><a href="../config/config.php">OPÇÕES</a></span>
                </span>
            </button>
            <button>
                <span class="perfil-container">
                    <img src="<?php
                    include_once('../buscardado.php');
                    echo "../cadastro/" . $perfil; ?>" alt="Foto de perfil" class="perfil2">
                    <span><a href="../users/user.php" id="usuario">
                            <?php echo $nick; ?>
                        </a></span>
                </span>
            </button>
        </nav>
    </aside>

    <article>
        <form method="POST" action="../upload.php" enctype="multipart/form-data">

            <h1>Postagem</h1>
            <label for="imagem">
                <input type="file" name="imagem" id="imagem">
                <span class="picture__image">colocar artes</span>
            </label>
            <br>
            <br>

            <label for="nome">Titulo: </label>
            <input type="text" name="nome" placeholder="De um titulo à seu post">
            <br>
            <label for="nome">Descrição:</label>
            <br>
            <textarea id="myTextarea" rows="6" cols="57" name="descricao"
                placeholder="Fale um pouco sobre O post! <br> no maximo 5 linhas"></textarea>
            <br>
            <label for="nome">Tipo de arte:</label>
            <select id="tipo" name="tipo">
                <option value="Pintura">Pintura</option>
                <option value="Desenho">Desenho</option>
                <option value="Arte_digital">Arte_digital</option>
                <option value="Foto">Fotografia</option>
            </select>
            <br>
            <br><!--
            <label for="checkboxInput" class="custom-checkbox"><h2>Materiais usados:</h2>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Lapis</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Pincel</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Mesa digitalizadora</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Dedo</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Papel</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Vidro</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Madeira</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Pedra</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Oleo</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Aquaréla</span> 
            <br>
            <input type="checkbox" name="material" value="Ciências" id="checkboxInput"><span class="checkmark">Guache</span> 
            </label>
            <br>
            <br>-->
            <br>
            <button type="submit">Enviar</button>
        </form>
    </article>

    <script>
        document.getElementById('imagem').addEventListener('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const spanImagem = document.querySelector('.picture__image');
                    spanImagem.textContent = '';

                    const imagem = new Image();
                    imagem.src = e.target.result;
                    imagem.alt = 'Imagem selecionada';
                    imagem.style.maxWidth = '100%';
                    spanImagem.appendChild(imagem);
                }

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
    <?php include('../Codigos/modalN.php'); ?>

</body>

</html>