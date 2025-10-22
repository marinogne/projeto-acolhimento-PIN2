<?php
require_once "../controller/UsuarioController.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';

if(isset($_SESSION['logado'])){
    header('location: ../index.php');
    exit;
}

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
    $mensagem = $_SESSION['msg'];
    unset($_SESSION['msg']);
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
            Usuário: <input type="text" name="username" required>
            Senha: <input type="password" name="senha" required>
            <button type="submit" name="acao" value="login">Entrar</button>
            <a href="cadastrarusuario.php" style="color: blueviolet;">Cadastrar-se!</a>
        </form>
    </div>
</body>
</html>
