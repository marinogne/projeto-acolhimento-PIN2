<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: loginUsuario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página do Usuário</title>
</head>
<body>
    <h2>funcionou  <?php echo $_SESSION['usuario']; ?>!</h2>
    <p>TESTE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</p>
    <a href="logoutUsuario.php">Sair</a>
</body>
</html>
