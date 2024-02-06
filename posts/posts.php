<?php
include_once('../cadastro/conexao.php');
include_once('../users/buscardado.php');

// Captura o ID da imagem do post a partir do parâmetro na URL
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Use o ID para buscar as informações do post e da imagem
    $posts_sql = "SELECT * FROM posts WHERE id = '$postId'";
    $posts_result = $conexao->query($posts_sql);

    if ($posts_result !== false && $posts_result->num_rows > 0) {
        $row = $posts_result->fetch_assoc();
        $post_image = $row['imagem'];
        $name = $row['nome'];
        $tipoArt = $row['tipoArt'];
        $desc = $row['descricao'];
        $data = $row['data'];
        $user_id = $row['id_user'];

        // Corrigir a consulta para buscar os detalhes do usuário
        $user_sql = "SELECT * FROM users WHERE id = '$user_id'";
        $user_result = $conexao->query($user_sql);

        if ($user_result !== false && $user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            $non = $user_row['nick'];
            $perf = $user_row['perfil'];
        } else {
            echo "<p>Nenhum usuário encontrado!</p>";
        }
    } else {
        echo "<p>Post não encontrado.</p>";
    }
} else {
    echo "<p>ID do post não fornecido.</p>";
}

// Processamento do envio de mensagens
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conteudo = $_POST['txtConteudo'];

    $usuario = $nome; // Nome do usuário atual (você precisará ajustar isso)

    // Inserir a mensagem na tabela Mensagens
    $sqlInserirMensagem = "INSERT INTO Mensagens (MEN_POST_ID, MEN_USUARIO, MEN_CONTEUDO) VALUES ('$postId', '$usuario', '$conteudo')";

    if ($conexao->query($sqlInserirMensagem) === TRUE) {
        // Redirecionar de volta para a página de exibição do chat
        header("Location: posts.php?id=$postId");
        exit();
    } else {
        echo "Erro ao enviar a mensagem: " . $conexao->error;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="posts.css">
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
            <button><span>
                    <i class="material-symbols-outlined trans"> Add_circle </i>
                    <span>
                <a href="../up/up.php">ADICIONAR</a></span>
                </span>
            </button>
            <button><span> 
                    <i class="material-symbols-outlined">build_circle </i>
                <span><a href="../config/config.php">OPÇÕES</a></span>
                </span>
            </button>
            <button>
                <span>
                    <img src="<?php echo $perfil; ?>" alt="Foto de perfil" class="perfil2">
                    <span><a href="../users/user.php" id="usuario">
                            <?php echo $nome; ?>
                        </a></span>
                </span>
            </button>
        </nav>
    </aside>
    <div class="apagar">
        <?php
        $usuario_id = $_SESSION['id_usuario'];

        if ($user_id == $usuario_id) {
            echo "<button onclick=\"apagarPost($postId)\">Apagar</button>";
        }
        ?>
    </div>

    <article class="principal">
        <div class="post">
            <img src="../<?php echo $post_image; ?>" alt="Imagem do Post">
            <div class="conteudo">
                <div class="texto">
                    <h1>
                        <?php echo $name; ?>
                    </h1>
                    <p class="tipo">
                        <?php echo $tipoArt; ?>
                    </p>
                    <p>
                    <h4>Descrição</h4>
                    <?php echo $desc; ?>
                    </p>
                </div>
                <div class="perfil3" id="perfilDiv">
                    <div class="perfil3-container">
                        <img src="../cadastro/<?php echo $perf; ?>" alt="">
                    </div>
                    <p>
                        <?php echo $non; ?>
                    </p>
                </div>
            </div>
    </article>
    <div class="painel">
        <h2 style="border-bottom: 1px solid white;">Chat</h2>
        <div class="chat">
            <?php
            // Exibir mensagens associadas a esse post
            $mensagens_sql = "SELECT * FROM Mensagens WHERE MEN_POST_ID = '$postId'";
            $mensagens_result = $conexao->query($mensagens_sql);

            if ($mensagens_result !== false && $mensagens_result->num_rows > 0) {
                while ($mensagem_row = $mensagens_result->fetch_assoc()) {
                    $mensagemUsuario = $mensagem_row['MEN_USUARIO'];
                    $mensagemConteudo = $mensagem_row['MEN_CONTEUDO'];
                    $mensagemData = $mensagem_row['MEN_DATA'];

                    echo "<div class='mensagem'>";
                    echo "<p><strong>$mensagemUsuario</strong>: $mensagemConteudo</p>";
                    echo "<span class='data'>$mensagemData</span>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nenhuma mensagem encontrada.</p>";
            }
            ?>
        </div>
        <form action="#" class="formulario" method="POST">
            <textarea name="txtConteudo" id="" cols="30" rows="6" placeholder="Sua mensagem*"></textarea><br>
            <button type="submit">Enviar</button>
        </form>
    </div>

    </div>
    </div>
    </article>
    <script>
        document.getElementById("perfilDiv").addEventListener("click", function () {
            window.location.href = "../users/person.php?id=<?php echo $user_id ?>";
        });
        function apagarPost(postId) {
            var confirma = confirm("Tem certeza de que deseja apagar este post? Esta ação não pode ser desfeita.");
            if (confirma) {
                window.location.href = "../Codigos/excluir_post.php?id=" + postId;
            }
        };
    </script>
    <?php include('../Codigos/modalN.php'); ?>
</body>

</html>