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
    <link rel="stylesheet" type="text/css" href="styles.css">
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

        <div class="article">
        <?php
       $query_seguindo = "SELECT seguindo_id FROM seguidores WHERE seguidor_id = $id_user";
       $result_seguindo = $conexao->query($query_seguindo);
       
       $seguindo_ids = array();
       while ($row_seguindo = $result_seguindo->fetch_assoc()) {
           $seguindo_ids[] = $row_seguindo['seguindo_id'];
       }
       
       $ids_seguindo = implode(',', $seguindo_ids);
       
       $data_atual = '2023-10-31 17:00:00'; // Início às 5 da tarde em 01/11/2023
$data_minima = '2023-10-31 09:00:00'; // Fim às 9 da manhã em 01/11/2023

       
       // Loop até não haver mais posts para buscar
       echo '<div class="um">';
while (true) {
    $sql = "SELECT p.id, p.id_user, p.imagem, p.data, p.nome, u.nick, CONCAT('cadastro/', u.perfil) as perfil
    FROM posts p
    INNER JOIN users u ON p.id_user = u.id
    WHERE p.id_user IN ($ids_seguindo)
    AND p.data >= '$data_minima' AND p.data <= '$data_atual'
    ORDER BY p.data DESC";

    // Execute a consulta e processe os resultados
    $result = $conexao->query($sql);

    // Verifique se há algum post no período especificado
    if ($result->num_rows > 0) {
        echo '<div class="row">'; // Abre uma nova linha

        // Exibe a primeira coluna
        echo '<div class="column">';
        while ($row = $result->fetch_assoc()) {
            // Exiba o conteúdo do post, incluindo o nome de usuário (nick)
            echo '<a href="posts/posts.php?id=' . $row['id'] . '">';
            echo '<div class="result" style="width: 257px; height: 500px; padding: 5px; margin-top: 10px;">';
            echo "<p class='titulosP'>" . $row['nome'] . '</p>';
            echo '<img src="' . $row['imagem'] . '" alt="Imagem do Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">';
            echo '<div class="center">';
            echo '<img src="' . $row['perfil'] . '" alt="Perfil do Usuário" style="margin-top:1px; width: 45px; height: 43px; object-fit: cover; border-radius: 50%;">';
            echo "<p class='nickn'>" . $row['nick'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }
        echo '</div>'; // Fecha a primeira coluna

        echo '</div>'; // Fecha a linha
    }

    // Vá para a data anterior (um dia antes) para a próxima iteração do loop
    $data_atual = date("Y-m-d H:i:s", strtotime($data_atual . " -1 day"));

    // Se a data atual for anterior à data mínima, saia do loop
    if ($data_atual < $data_minima) {
        break;
    }
}
echo '</div>';

    ///////
    $query_seguindo = "SELECT seguindo_id FROM seguidores WHERE seguidor_id = $id_user";
    $result_seguindo = $conexao->query($query_seguindo);
    
    $seguindo_ids = array();
    while ($row_seguindo = $result_seguindo->fetch_assoc()) {
        $seguindo_ids[] = $row_seguindo['seguindo_id'];
    }
    
    $ids_seguindo = implode(',', $seguindo_ids);
    
    $data_atual = '2023-10-31 08:59:00'; // Início às 9 da manhã em 01/11/2023
$data_minima = '2023-10-30 00:00:00'; // Fim no início do dia em 31/10/2023

    
    // Loop até não haver mais posts para buscar
    echo '<div class="um">';
while (true) {
    $sql = "SELECT p.id, p.id_user, p.imagem, p.data, p.nome, u.nick, CONCAT('cadastro/', u.perfil) as perfil
    FROM posts p
    INNER JOIN users u ON p.id_user = u.id
    WHERE p.id_user IN ($ids_seguindo)
    AND p.data >= '$data_minima' AND p.data < '$data_atual'
    ORDER BY p.data DESC";

    // Execute a consulta e processe os resultados
    $result = $conexao->query($sql);

    // Verifique se há algum post no período especificado
    if ($result->num_rows > 0) {
        echo '<div class="row">'; // Abre uma nova linha

        // Exibe a primeira coluna
        echo '<div class="column">';
        while ($row = $result->fetch_assoc()) {
            // Exiba o conteúdo do post, incluindo o nome de usuário (nick)
            echo '<a href="posts/posts.php?id=' . $row['id'] . '">';
            echo '<div class="result" style="width: 257px; height: 500px; padding: 5px; margin-top: 10px;">';
            echo "<p class='titulosP'>" . $row['nome'] . '</p>';
            echo '<img src="' . $row['imagem'] . '" alt="Imagem do Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">';
            echo '<div class="center">';
            echo '<img src="' . $row['perfil'] . '" alt="Perfil do Usuário" style="margin-top:1px; width: 45px; height: 43px; object-fit: cover; border-radius: 50%;">';
            echo "<p class='nickn'>" . $row['nick'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
        }
        echo '</div>'; // Fecha a primeira coluna

        echo '</div>'; // Fecha a linha
    }

    // Vá para a data anterior (um dia antes) para a próxima iteração do loop
    $data_atual = date("Y-m-d H:i:s", strtotime($data_atual . " -1 day"));

    // Se a data atual for anterior à data mínima, saia do loop
    if ($data_atual < $data_minima) {
        break;
    }
}
echo '</div>';
    
                echo '<div class="um">';
?>
        <?php
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
                    echo "<p class='titulosP'>" . $row['nome'] . '</p>';
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
                    echo "<p class='titulosP' id='titulosP'>" . $row['nome'] . '</p>';
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
 </div>
 <script>
    const titleContainer = document.querySelector('.title-container');

    // Ajuste a margem superior quando o conteúdo quebrar para uma nova linha
    if (titleContainer.offsetHeight > titleContainer.clientHeight) {
        titleContainer.style.marginTop = '-10px'; // Mova 10 pixels para cima
    }
</script>

</body>

</html>