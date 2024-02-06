<?php
include_once("buscardado.php");
include_once("cadastro/conexao.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="Pagina.css">
    <link rel="icon" href="icones/iconinho.png" type="image/png">
    <title>Lunar</title>
</head>

<body>

    <aside>
        <header id="logo">
            <img class="logo" src="icones\icone.png" alt="logo">
        </header>

        <nav class="links">
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> home </i>
                    <span><a href="paginaPrincipal.php">HOME</a></span>
                </span>
            </button>
            <button>
                <span>
                    <i class="material-symbols-outlined trans"> &#xE8B6 </i>
                    <span><a href="explorar/explorar.php">EXPLORAR</a></span>
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
                    <span><a href="up/up.php">ADICIONAR</a></span>
                </span>
            </button>
            <button><span>
                    <i class="material-symbols-outlined">build_circle </i>
                    <span><a href="config/config.php">OPÇÕES</a></span>
                </span>
            </button>
            <button>
                <span class="perfil-container">
                    <img src="<?php echo "cadastro/" . $perfil; ?>" alt="Foto de perfil" class="perfil2">
                    <span><a href="users/user.php" id="usuario">
                            <?php echo $nick; ?>
                        </a></span>
                </span>
            </button>

        </nav>
    </aside>
    <h1 class="posts-h1">Postagens</h1>



    <article>
        <?php
       $query_seguindo = "SELECT seguindo_id FROM seguidores WHERE seguidor_id = $id_user";
       $result_seguindo = $conexao->query($query_seguindo);
       
       $seguindo_ids = array();
       while ($row_seguindo = $result_seguindo->fetch_assoc()) {
           $seguindo_ids[] = $row_seguindo['seguindo_id'];
       }
       
       $ids_seguindo = implode(',', $seguindo_ids);
       
       $data_atual = date("Y-m-d");
       $data_minima = '2012-01-01';
       
       // Loop até não haver mais posts para buscar
       echo '<div class="um">';
       $column_count = 0; // Contador para controlar as colunas
       
       while (true) {
           // Execute a consulta SQL para obter os posts dos usuários que você está seguindo na data atual
           $sql = "SELECT p.id, p.id_user, p.imagem, p.data, p.nome, u.nick, CONCAT('cadastro/', u.perfil) as perfil
           FROM posts p
           INNER JOIN users u ON p.id_user = u.id
           WHERE p.id_user IN ($ids_seguindo)
           AND DATE(p.data) = '$data_atual'
           ORDER BY p.data DESC";
       
           // Execute a consulta e processe os resultados
           $result = $conexao->query($sql);
       
           // Verifique se há algum post na data atual
           if ($result->num_rows > 0) {
               echo '<div class="row">'; // Abre uma nova linha (linha de duas colunas)
       
               while ($row = $result->fetch_assoc()) {
                   // Exiba o conteúdo do post, incluindo o nome de usuário (nick) em uma coluna
                   echo '<div class="column">';
                   echo '<a href="posts/posts.php?id=' . $row['id'] . '">';
                   echo '<div class="result" style="width: 257px; height: 500px; padding: 5px; margin-top: 10px;">';
                   echo "<p class='nome-post'>" . $row['nome'] . '</p>';
                   echo '<img src="' . $row['imagem'] . '" alt="Imagem do Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">';
                   echo '<div class="center">';
                   echo '<img src="' . $row['perfil'] . '" alt="Perfil do Usuário" style="margin-top:1px; width: 45px; height: 43px; object-fit: cover; border-radius: 50%;">';
                   echo "<p class='nickn'>" . $row['nick'] . '</p>';
                   echo '</div>';
                   echo '</div>';
                   echo '</a>';
                   echo '</div>';
       
                   $column_count++;
       
                   // Se já tivermos exibido duas colunas, feche a linha e comece uma nova
                   if ($column_count == 2) {
                       echo '</div>'; // Fecha a linha
                       echo '<div class="row">'; // Abre uma nova linha
                       $column_count = 0; // Reinicie o contador de colunas
                   }
               }
               
               
       
               echo '</div>'; // Fecha a última linha
       
           }
           
           // Vá para a data anterior (um dia antes) para a próxima iteração do loop
           $data_atual = date("Y-m-d", strtotime($data_atual . " -1 day"));
       
           // Se a data atual for anterior à data mínima, saia do loop
           if ($data_atual < $data_minima) {
               break;
           }
       }
       echo '</div>';
       
                echo '<div class="um">';

        /////////////////////////////////////
        // Calcular a média de seguidores por usuário
        $query_media_seguidores = "SELECT AVG(num_seguidores) as media_seguidores FROM (SELECT id, COUNT(*) as num_seguidores FROM seguidores GROUP BY id) as temp";
        $result_media_seguidores = $conexao->query($query_media_seguidores);
        $row_media_seguidores = $result_media_seguidores->fetch_assoc();
        $media_seguidores = $row_media_seguidores['media_seguidores'];

        $data_atual = date("Y-m-d");
        $data_minima = '2012-01-01';

        // Loop até não haver mais posts para buscar
        while (true) {
            // Execute a consulta SQL para obter os posts de usuários que têm seguidores acima da média e que você não segue na data atual
            $sql = "SELECT p.id, p.id_user, p.imagem, p.data,p.nome, u.nick, CONCAT('cadastro/', u.perfil) as perfil
            FROM posts p
            LEFT JOIN users u ON p.id_user = u.id
            LEFT JOIN seguidores s ON p.id_user = s.seguindo_id AND s.seguidor_id = $id_user
            WHERE s.seguidor_id IS NULL
            AND DATE(p.data) = '$data_atual'
            AND (SELECT COUNT(*) FROM seguidores s2 WHERE s2.seguindo_id = p.id_user) > $media_seguidores
            ORDER BY p.data DESC";

            // Execute a consulta e processe os resultados
            $result = $conexao->query($sql);

            // Verifique se há algum post na data atual
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Exiba o conteúdo do post, incluindo o nome de usuário (nick)
                    echo '<a href="posts/posts.php?id=' . $row['id'] . '">';
                    echo '<div class="result" style="width: 257px; height: 500px; padding: 5px; margin-top: 10px;">';
                    echo "<p class='nome-post'>" . $row['nome'] . '</p>';
                    echo '<img src="' . $row['imagem'] . '" alt="Imagem do Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">';
                    echo '<div class="center">';
                    echo '<img src="' . $row['perfil'] . '" alt="Perfil do Usuário" style="margin-top:1px; width: 45px; height: 43px; object-fit: cover; border-radius: 50%;">';
                    echo "<p class='nickn'>" . $row['nick'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }

            // Vá para a data anterior (um dia antes) para a próxima iteração do loop
            $data_atual = date("Y-m-d", strtotime($data_atual . " -1 day"));

            // Se a data atual for anterior à data mínima, saia do loop
            if ($data_atual < $data_minima) {
                break;
            }
        }
        echo '</div>';
        echo '<div class="dois">';

        ////////
        $query_media_seguidores = "SELECT AVG(num_seguidores) as media_seguidores FROM (SELECT id, COUNT(*) as num_seguidores FROM seguidores GROUP BY id) as temp";
        $result_media_seguidores = $conexao->query($query_media_seguidores);
        $row_media_seguidores = $result_media_seguidores->fetch_assoc();
        $media_seguidores = $row_media_seguidores['media_seguidores'];

        $data_atual = date("Y-m-d");
        $data_minima = '2012-01-01';

        // Loop até não haver mais posts para buscar
        while (true) {

            // Execute a consulta SQL para obter os posts de usuários que têm seguidores acima da média e que você não segue na data atual
            $sql = "SELECT p.id, p.id_user, p.imagem, p.nome, p.data, u.nick, CONCAT('cadastro/', u.perfil) as perfil
       FROM posts p
       LEFT JOIN seguidores s ON p.id_user = s.seguindo_id AND s.seguidor_id = $id_user
       LEFT JOIN users u ON p.id_user = u.id  -- Adicione esta linha
       WHERE s.seguidor_id IS NULL
       AND DATE(p.data) = '$data_atual'
       AND (SELECT COUNT(*) FROM seguidores s2 WHERE s2.seguindo_id = p.id_user) < $media_seguidores
       ORDER BY p.data DESC";

            // Execute a consulta e processe os resultados
            $result = $conexao->query($sql);

            // Verifique se há algum post na data atual
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Exiba o conteúdo do post
                    echo '<a href="posts/posts.php?id=' . $row['id'] . '">';
                    echo '<div class="result2" style="width: 257px; height: 500px; padding: 5px; margin-top: 10px;">';
                    echo "<p class='nome-post'>" . $row['nome'] . '</p>';
                    echo '<img src="' . $row['imagem'] . '" alt="Imagem do Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">';
                    echo '<div class="center">';
                    echo '<img src="' . $row['perfil'] . '" alt="Perfil do Usuário" style="margin-top:1px; width: 45px; height: 43px; object-fit: cover; border-radius: 50%;">';
                    echo "<p class='nickn'>" . $row['nick'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            }

            // Vá para a data anterior (um dia antes) para a próxima iteração do loop
            $data_atual = date("Y-m-d", strtotime($data_atual . " -1 day"));

            // Se a data atual for anterior à data mínima, saia do loop
            if ($data_atual < $data_minima) {
                break;
            }
        }
        echo '</div>';

        include('Codigos/modalN.php');
        ?>

    </article>
        <script>             // ... (seu código JavaScript) ...
        </script>

</body>

</html>
body {
    background-color: rgb(15, 15, 15);
    color: white;
}
.posts-h1{
    color: white;
    margin-left: 220px;
}

/*Sidebar*/
aside {
    background-color: rgb(15, 15, 15);
    position: fixed;
    top: 0;
    display: flex;
    flex-direction: column;
    border-right: 1px solid gray;
    height: 100%;
    align-items: flex-start;
    width: 200px;
    padding: 0;
    transition: all 0.50s;
}

#logo {
    width: 100%;
}

.logo {
    width: 100%;
    min-height: 35px;
    margin-left: -5px;
}

.links button {
    list-style-type: none;
    color: inherit;
    background: transparent;
    border: 0;
    font-family: inherit;
    cursor: pointer;
    text-align: left;
    padding: 0;
}

.links button>span {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    height: 48px;
    padding: 7px 16px 0 9px;
    border-radius: 24px;
    line-height: 1;
    margin-left: 20px;
}

.links button>span>span {
    transition: 0.10s;
}

.links button:hover>span {
    background-color: rgba(255, 255, 255, 0.08);
    transition: all 0.2s;
}

.links button i {
    font-size: x-large;
    transition: 0.2s;
}

.links a {
    color: white;
    text-decoration: none;
}

/*Botão do usuario no fim*/
.links button:nth-last-child(1) {
    margin-top: 70px;
}

.perfil-container {
    width: 150px;
    height: 40px;
    overflow: hidden;
}

.perfil2 {
    width: 45px;
    height: 45px;
    object-fit: cover; /* Isso ajuda a manter a proporção da imagem */
    border-radius: 50%; /* Isso cria um recorte circular na imagem */
    margin-top: -8px;
}

#usuario {
    font-size: 20px;
}


/*Conteudo*/
article {
    display: flex;
    flex-direction: row; /* Mantenha "row" para exibir duas colunas */
    margin-left: 220px;
    width: 84%;
    height: 100%;
    top: 0;
    transition: all 0.50s;
}

.titulosP{
    position: absolute;
    margin-top: -100px;
    margin-left: 35px;
    font-size: 20px;
    font-weight: bold;
    color: white;
    text-decoration: none;
    background: rgba(0, 0, 0, 0.5);
    padding: 5px; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    border-radius: 20px;
}
.perfildono{
    width: 45px;
    height: 45px;
    object-fit: cover; /* Isso ajuda a manter a proporção da imagem */
    border-radius: 50%; /* Isso cria um recorte circular na imagem */

}
.nomedono{
    color: white;
    text-decoration: none;
    font-size: 18px;
    margin-left: 15px;
    margin-top: 10px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}
.centro{
    position: absolute;
    display: flex;
    flex-direction: row;
    margin-left: 15px;
    margin-top: -63px;
    background: rgba(0, 0, 0, 0.5);
    padding: 2px 6px 2px; 
    height: 45px;
    border-radius: 20px;
}
/*ajuste sidebar*/

@media (width < 1020px) {
    aside {
        width: 70px;
    }

    .links button>span>span {
        opacity: 0;
        visibility: hidden;
    }

    .trans {
        border-radius: 5px;
        margin-left: 9px;
    }

    article {
        margin-left: 80px;
    }

    .links button:hover>span {
        background-color: rgba(255, 255, 255, 0);
    }

    .logo {
        width: 100%;
        padding: 10% 0% 20% 0%;
        margin-left: -4px;
    }
}

@media (width < 1366px) {
    article{
        margin-left: 210px;
    }
}