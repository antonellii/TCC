<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="explorar.css">
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
                    <span><a href="explorar.php">EXPLORAR</a></span>
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
                <span class="perfil-container"> <img src="<?php
                include_once('../buscardado.php');
                echo "../cadastro/" . $perfil;
                ?>" alt="Foto de perfil" class="perfil2">
                    <span><a href="../users/user.php" id="usuario">
                            <?php echo $nick; ?>
                        </a></span>
                </span>
            </button>
        </nav>
    </aside>

    <article>

        <form class="search-box" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" class="search" name="search_name" id="search_name" required>
            <br>
            <select name="tipoArt" id="tipoArt">
                <option value="">Filtro</option>
                <option value="Pintura">Pintura</option>
                <option value="Desenho">Desenho</option>
                <option value="Escultura">Arte_digital</option>
                <option value="Fotografia">Fotografia</option>
            </select>

            <button type="submit" class="button"><i class="material-symbols-outlined trans">Search</i></button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include_once('../cadastro/conexao.php'); // Substitua pelo caminho correto para o arquivo de conexão
            $search_name = $_POST['search_name']; // Nome que o usuário digitou
            $tipoArt = $_POST['tipoArt']; // Tipo de arte a ser filtrado
        
            // Verificar a conexão
            if ($conexao->connect_error) {
                die("Conexão falhou: " . $conexao->connect_error);
            }

            // Consulta SQL para buscar o ID na tabela "users"
            $user_sql = "SELECT id, perfil, tipoArt, nick AS name FROM users WHERE nick LIKE '$search_name%'";
            $user_result = $conexao->query($user_sql);

            // Consulta SQL para buscar o ID na tabela "posts" com filtro de tipoArt
            $post_sql = "SELECT id, imagem FROM posts WHERE nome LIKE '$search_name%'";

            // Adicione a cláusula WHERE para filtrar por tipoArt
            if (!empty($tipoArt)) {
                $post_sql .= " AND tipoArt = '$tipoArt'";
            }

            $post_result = $conexao->query($post_sql);
        }

        ?>

        <div class="toggle-buttons">
            <button id="toggleUsers" class="toggle-button" onclick="toggleUsers()">Usuários</button>
            <button id="togglePosts" class="toggle-button" onclick="togglePosts()">Artes</button>
        </div>
        <div id="userResults" class="result-list">
    <?php
    if (isset($user_result) && $user_result->num_rows > 0) {
        while ($row = $user_result->fetch_assoc()) {
            if (isset($row["id"]) && isset($row["name"]) && isset($row["perfil"]) && isset($row["tipoArt"])) {
                $user_id = $row["id"];
                $user_name = $row["name"];
                $perfil = $row["perfil"];
                $tipoArtUsuario = $row["tipoArt"];

                // Verifique se o tipoArt do usuário corresponde ao filtro
                if (empty($tipoArtUsuario) || $tipoArtUsuario === $tipoArtUsuario) {
                    echo "<div class='result-item name'>
                    <a class='direcao' href='../users/person.php?id=$user_id'>
                        <img src='../cadastro/$perfil' class='perfil3'>
                        <h3  class='nomed'>$user_name</h3>
                    </a>
                </div>";
                }
            }
        }
    } else {
        echo "<p class='no-result-message'>Nenhum usuário encontrado!</p>";
    }
    ?>
</div>




        <div id="postResults" class="result-list hidden">
            <?php
            if (isset($post_result) && $post_result->num_rows > 0) {
                while ($row = $post_result->fetch_assoc()) {
                    echo "<div class='result-item post'><a href='../posts/posts.php?id=$row[id]'><img src='../$row[imagem]'></a></div>";
                }
            } else {
                echo "<p class='no-result-message'>Nenhuma arte encontrada!</p>";
            }
            ?>
        </div>


        <script>
            function toggleUsers() {
                const userResults = document.getElementById("userResults");
                const postResults = document.getElementById("postResults");

                userResults.classList.remove("hidden");
                postResults.classList.add("hidden");
            }

            function togglePosts() {
                const userResults = document.getElementById("userResults");
                const postResults = document.getElementById("postResults");

                userResults.classList.add("hidden");
                postResults.classList.remove("hidden");
            }
        </script>

    </article>
    <?php include('../Codigos/modalN.php'); ?>
</body>

</html>