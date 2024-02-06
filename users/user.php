<?php
include_once('../cadastro/conexao.php');
include_once('buscardado.php');
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="user.css">
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
            <?php include('../Codigos/modalN.php'); ?>
            <button onclick="openModal()">
                <span>
                    <i class="material-symbols-outlined trans"> favorite </i>
                    <span>NOTIFICAÇÕES</span>
                </span>
            </button>
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> Add_circle </i>
                    <span><a href="../up/up.php">ADICIONAR</a>
            </button>
            <button><span> 
                    <i class="material-symbols-outlined">build_circle </i>
                <span><a href="../config/config.php">OPÇÕES</a></span>
                </span>
            </button>
            <button>
                <span>
                    <div perfil2_container>
                        <img src="<?php echo $perfil; ?>" alt="Foto de perfil" class="perfil2">
                    </div>
                    <span><a href="user.php" id="usuario">
                            <?php echo $nome; ?>
                        </a></span>
                </span>
            </button>
        </nav>
    </aside>
    <article class="principal">
        <div class="linha">
            <div class="Perfil">
                <div class="area-imagem">
                    <img src="<?php echo $backFoto; ?>" alt="background">
                </div>
                <div class="perfil-container">
                    <img src="<?php echo $perfil; ?>" alt="Foto de perfil" class="perfil-img">
                </div>

                <h3>
                    <?php echo $nome; ?>
                </h3> <!-- Fechamento da tag h3 -->
                <h2 class="h2">
                    <?php echo "🌘" . $tipoArt; ?>
                </h2>

                <p class="F "><a href="seguidores.php?id=<?php echo $id_user; ?>">Seguidores:
                        <?php echo $num_seguidores; ?>
                    </a></p>
                <p class="S"><a href="seguindo.php?id=<?php echo $id_user; ?>">Seguindo:
                        <?php echo $num_seguindo; ?>
                    </a></p>


                <p class="bio" id="bio">
                    <?php echo $bio; ?>
                </p>
            </div>
        </div>

    </article>
    <div class="imagens">
        <?php
        if ($posts_result !== false && $posts_result->num_rows > 0) {
            while ($row = $posts_result->fetch_assoc()) {
                $post_id = $row['id']; // Supondo que haja um campo ID em sua tabela de posts
                $post_image = $row['imagem'];
                $post_date = $row['data'];

                echo "<div class='post-item result-item post'>";
                echo "<img src='../$post_image' alt='Imagem do Post' data-id='$post_id'>"; // Adicione o atributo data-id
                echo "</div>";
            }
        } else {
            echo "<p>Nenhum post encontrado.</p>";
        }
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const postImages = document.querySelectorAll('.post-item img');

                postImages.forEach(img => {
                    img.addEventListener('click', function () {
                        const postId = this.getAttribute('data-id');
                        window.location.href = `../posts/posts.php?id=${postId}`; // Passa o ID como parâmetro na URL
                    });
                });
            });

        </script>
        <?php include('../Codigos/modalN.php'); ?>

</body>

</html>