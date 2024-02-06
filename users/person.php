<?php
include_once('buscardado.php');
include_once('../Codigos/notificacoes.php');


if (isset($_GET["id"])) {
    $id_user = $_GET["id"];

    include_once('../cadastro/conexao.php');

    $sql = "SELECT nome, nick, email, perfil, backFoto, tipoArt, bio FROM users WHERE id = $id_user";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $perf = "../cadastro/" . $row["perfil"];
        $backFoto = "../cadastro/" . $row["backFoto"];
        $non = $row["nick"];
        $tipoArt = $row["tipoArt"];
        $bio = $row['bio'];

        // Verificar se o usuário logado já segue o perfil exibido
        $my_id = $_SESSION['id_usuario'];

        $sql_verificar_segue = "SELECT id FROM seguidores WHERE seguidor_id = $my_id AND seguindo_id = $id_user";
        $result_verificar_segue = $conexao->query($sql_verificar_segue);
        $jaSegue = ($result_verificar_segue->num_rows > 0);

        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'follow') {
                $action = 'follow';
                $mensagemNotificacao = "Você foi seguido por " . $nome;
            } elseif ($_GET['action'] == 'unfollow') {
                $action = 'unfollow';
                $mensagemNotificacao = "Você foi deixado de seguir por " . $nome;
            }

            if ($action && $id_user != $_SESSION['id_usuario']) {
                $sql_follow = "INSERT INTO seguidores (seguidor_id, seguindo_id) VALUES ($_SESSION[id_usuario], $id_user)";
                $sql_unfollow = "DELETE FROM seguidores WHERE seguidor_id = $_SESSION[id_usuario] AND seguindo_id = $id_user";

                if ($action == 'follow') {
                    $result_action = $conexao->query($sql_follow);
                } elseif ($action == 'unfollow') {
                    $result_action = $conexao->query($sql_unfollow);
                }

                if ($result_action) {
                    inserirNotificacao($id_user, $mensagemNotificacao, $conexao);
                    header("Location: person.php?id=$id_user");
                } else {
                    echo "Erro ao realizar ação.";
                }
            }
        }

        // Consulta SQL para buscar os posts do usuário
        $posts_sql = "SELECT nome, imagem, id, data FROM posts WHERE id_user = '$id_user' ORDER BY data DESC";
        $posts_result = $conexao->query($posts_sql);

        $sql_numero_seguidores = "SELECT COUNT(*) AS num_seguidores FROM seguidores WHERE seguindo_id = $id_user";
        $result_numero_seguidores = $conexao->query($sql_numero_seguidores);
        $row_numero_seguidores = $result_numero_seguidores->fetch_assoc();
        $num_seguidores = $row_numero_seguidores['num_seguidores'];

        // Verificar o número de pessoas que a pessoa segue
        $sql_numero_seguindo = "SELECT COUNT(*) AS num_seguindo FROM seguidores WHERE seguidor_id = $id_user";
        $result_numero_seguindo = $conexao->query($sql_numero_seguindo);
        $row_numero_seguindo = $result_numero_seguindo->fetch_assoc();
        $num_seguindo = $row_numero_seguindo['num_seguindo'];

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "Nenhum resultado encontrado.";
    }
}
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
                    <img src="<?php echo $perf; ?>" alt="Foto de perfil" class="perfil-img">
                </div>
                <h3>
                    <?php echo $non ?>
                </h3>
                <h2 class="h2">
                    <?php echo "🌘" . $tipoArt; ?>
                </h2>

                <p class="G"><a href="seguidores.php?id=<?php echo $id_user; ?>">Seguidores:
                        <?php echo $num_seguidores; ?>
                    </a></p>
                <p class="S"><a href="seguindo.php?id=<?php echo $id_user; ?>">Seguindo:
                        <?php echo $num_seguindo; ?>
                    </a></p>


                <div class="DS">
                    <?php
                    if ($id_user != $_SESSION['id_usuario']) {
                        if ($jaSegue) {
                            echo '<a href="person.php?id=' . $id_user . '&action=unfollow">seguindo</a>';
                        } else {
                            echo '<a href="person.php?id=' . $id_user . '&action=follow">seguir</a>';
                        }
                    }
                    ?>
                </div>

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
                $post_id = $row['id'];
                $post_image = $row['imagem'];
                $post_nome = $row['nome'];
                $post_date = $row['data'];

                echo "<div class='post-item result-item post'>";
                echo "<img src='../$post_image' alt='Imagem do Post' data-id='$post_id'>";
                echo "<p class='titulosP'>$post_nome</p>";
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

</body>

</html>