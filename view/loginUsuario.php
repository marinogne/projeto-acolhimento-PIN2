<?php
require_once "../controller/UsuarioController.php";
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit;
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $controller = new UsuarioController();
    if ($controller->login($_POST['usuario'], $_POST['senha'])) {
        header("Location: paginaUsuario.php"); 
        exit;
    } else {
        $mensagem = "Usuário ou senha incorretos.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../styles/loginUsuario.css">
</head>
<body>
    <div class="loginContainer">
        <h1>LOGIN</h1>
        <?php if ($mensagem) echo "<p style='color:red;'>$mensagem</p>"; ?>
        <form method="post">
            Usuário: <input type="text" name="usuario" required>
            Senha: <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
