<?php
session_start();

// Destrua todas as variáveis de sessão
session_destroy();

// Redirecione o usuário para a página de login (ou qualquer outra página desejada)
header('Location: ../index.php');
exit();
?>
