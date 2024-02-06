<?php
include_once('buscardado.php');

if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    $sql_seguindo = "SELECT * FROM seguidores WHERE seguidor_id = $id_user";
    $result_seguindo = $conexao->query($sql_seguindo);

    $seguindo_ids = array();

    if ($result_seguindo !== false && $result_seguindo->num_rows > 0) {
        while ($row = $result_seguindo->fetch_assoc()) {
            $seguindo_ids[] = $row['seguindo_id']; // Adicione o ID da pessoa seguida ao array
        }
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
    <link rel="stylesheet" href="listaS.css">
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
            <h1>Seguindo</h1>
            <?php
            // Reabrir a conexão para buscar informações sobre os usuários seguidos
            include_once('../cadastro/conexao.php');

            foreach ($seguindo_ids as $seguindo_id) {
                // Consulta SQL para buscar informações da pessoa seguida
                $sql_info_seguindo = "SELECT nome, nick, perfil FROM users WHERE id = $seguindo_id";
                $result_info_seguindo = $conexao->query($sql_info_seguindo);
                $row_info_seguindo = $result_info_seguindo->fetch_assoc();

                // Exibir informações da pessoa seguida
                echo '<a href="person.php?id=' . $seguindo_id . '" class="seguidor-link">';
                echo '<div class="seguidor">';
                echo '<div class="perfil-container">';
                echo '<img src="../cadastro/' . $row_info_seguindo['perfil'] . '" alt="Foto de perfil" class="perfil-imagem">';
                echo '</div>';
                echo "<div class='perfil-info'>";
                echo "<div class='result-item name'>$row_info_seguindo[nick]</div>";
                echo '</div>';
                echo '</div>';
                echo '</a>';

            }

            $conexao->close();
            ?>
        </div>
    </article>
    <?php include('../Codigos/modalN.php'); ?>

</body>

</html>