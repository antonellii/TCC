<?php
    include_once('../cadastro/conexao.php');
    session_start();

if (isset($_GET['action']) && $_GET['action'] == 'follow' && isset($_GET['id'])) {
    $id_to_follow = $_GET['id'];
    $my_id = $_SESSION['id_usuario'];

    $sql_follow = "INSERT INTO seguidores (seguidor_id, seguindo_id) VALUES ($my_id, $id_to_follow)";
    $result_action = $conexao->query($sql_follow);

    if ($result_action) {
    } else {
        echo "<script>alert('Erro ao seguir o usuário.')</script>";
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'unfollow' && isset($_GET['id'])) {
    $id_to_unfollow = $_GET['id'];
    $my_id = $_SESSION['id_usuario'];

    $sql_unfollow = "DELETE FROM seguidores WHERE seguidor_id = $my_id AND seguindo_id = $id_to_unfollow";
    $result_action = $conexao->query($sql_unfollow);

}
$my_id = $_SESSION['id_usuario'];


if (isset($_POST['action']) && $_POST['action'] == 'executar_funcao') {
$sql = "SELECT COUNT(*) AS num_seguidores FROM seguidores WHERE seguidor_id = $my_id";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $num_seguidores = $row['num_seguidores'];

    if ($num_seguidores >= 2) {
        header('Location: ../paginaprincipal.php');
        exit();
    } else {
        echo "<script>alert('Você deve seguir no mínimo 2 pessoas');</script>";
    }
} else {
    echo "Erro ao consultar o banco de dados.";
}}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="seguir.css">
    <link rel="icon" href="../icones/iconinho.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Lunar</title>
</head>

<body>

<img id="logo" src="../icones/iconinho.png" alt="logo">

    <article>

        <h1>SUGESTÕES</h1>
        
        <div class="usuarios">
            <h3>Escolha  2 pessoas para seguir</h2>
            <br>
            <div class="perfil3">
                <div class="perfil3-container">
                    <?php
                    $sql = "SELECT id, nick, perfil FROM users WHERE id >= 6 AND id <= 12";
                    $result = $conexao->query($sql);
            
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<a href='person.php?id=" . $row['id'] . "' class='imgP'>";
                            echo "<img class='perf' src='../cadastro/" . $row["perfil"] . "'>";
                            echo "<p> " . $row["nick"]. "</p>";
                            $sql_check_follow = "SELECT * FROM seguidores WHERE seguidor_id = $_SESSION[id_usuario] AND seguindo_id = " . $row['id'];
$result_check_follow = $conexao->query($sql_check_follow);

if ($result_check_follow->num_rows > 0) {
    echo "<a href='seguir.php?action=unfollow&id=" . $row['id'] . "'>
        <button style='background-color: #ffbb00; border-radius: 15px; height: 50px; position: absolute; margin-left: 650px; margin-top: -75px; cursor: pointer; font-weight: bold;'>SEGUINDO</button>
    </a>";
} else {
    echo "<a href='seguir.php?action=follow&id=" . $row['id'] . "'>
        <button style='background-color: #ffbb00; border-radius: 15px; height: 50px; position: absolute; margin-left: 650px; margin-top: -75px; cursor: pointer; font-weight: bold;'>SEGUIR</button>
    </a>";
}
                        }
                    } else {
                        echo "0 resultados";
                    }
                    ?>
                    <form action="seguir.php" method="post">
    <input type="hidden" name="action" value="executar_funcao">
    <button type="submit" style='background-color: #ffbb00; border-radius: 15px; height: 60px; width: 100px; position: absolute; margin-left: 640px; margin-top: 30px; cursor: pointer;font-weight: bold;'>PROXIMO</button>
</form>
                    </div>        
                    </div>

                    
                    </article>                    

</body>

</html>