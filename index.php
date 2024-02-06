<?php
session_start();
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
} else {
    header('Location: paginaPrincipal.php');
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

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="icon" href="icones/iconinho.png" type="image/png">
    <title>Lunar</title>
</head>

<body>

    <article>
        <div class="conteudo">
        <img class="lua" src="icones\iconinho.png" alt="logo">
            <div class="Sobre">
                <h1>Sobre:</h1>
                <p> &nbsp;&nbsp;&nbsp;Com o crescente aumento do uso das redes sociais para promover artistas vem crescendo
                ao longo dos anos. Mas em meio a isso vemos artistas ficando presos às poucas ferramentas para ganhar
                visibilidade, e alcançar cada vez mais pessoas que tenham um gosto artístico parecido com o seu.
                Tornando o seu crescimento ainda mais lento e dependente de um algoritmo que muitas vezes não mostra
                seus posts a novas pessoas.
                O objetivo da Lunar é ser um local com ferramentas, visibilidade e que com o tempo se torne uma grande
                comunidade de artistas.
                </p>
            </div>
                <h1 id="h1">POSTS</h1>
            <br>            <br>

            <div class="Sobre">
                <p>&nbsp;&nbsp;&nbsp;Ao se cadastrar no site ele pede para você seguir um numero minimo de pessoas, isso de para que os sistema funcione perfeitamente aasssim logo na primeira pagina, home a pagina dos posts, você se deparara com 4 colunas de posts explicadas a seguir.</p>           </div>
            <div class="post">
                <img class="Foto" src="icones\Ap1.PNG" alt="logo">
                <p class="posts"> &nbsp;&nbsp;&nbsp;Inicialmente, o código realiza uma análise das pessoas que você segue e busca seus últimos posts. Em seguida, ele organiza esses posts em duas colunas à esquerda, ordenadas por data, sendo a primeira coluna dedicada aos posts mais recentes e a segunda aos posts mais antigos.<br>
                     &nbsp;&nbsp;&nbsp;Em seguida é feito um calculo do numero de seguidores e da media das pessoas para que então seja formadas a terceira coluna, essa coluna mostra os posts de pessoas que estão a cima dessa media, seguino para a quarta coluna, aqui podemos ver a coluna de pessoas que estão a baixo dessa média, essa coluna existe para que pessoas novas ou com baixos seguidores possam ganhar mais visibilidade.
            </p>
            <div class="conteudpsAd">
                <p>
                &nbsp;&nbsp;&nbsp;A pagina de opções é o local onde você pode trocar seus  (apelido, email, senha, bio e fotos) alem disso tambem temos a opção de desconectar e apagar conta dentro desta pagina.
                </p>
            </div>
            <div class="conteudpsAd">
                <p>&nbsp;&nbsp;&nbsp;Em relação as outras paginas elas sõa bem intuitivas por si só, adicionar é para fazer postagens, notificações e perfil de usuario.</p>
            </div>
            </div>
        </div>
    </article>

    <div class="logar">
        <button class="login" onclick="window.location.href = 'cadastro/login.php'">conectar</button>
        <button class="logi" onclick="window.location.href = 'cadastro/cadastro.php'">cadastrar</button>
    </div>

    <script>
        var a = window.document.getElementById('usuario');

        function clicar1() {
            confirm('Você precisa estar logado para acessar esta pagina!!!');
        }
    </script>


</body>

</html>