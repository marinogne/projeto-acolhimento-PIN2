<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['logado'])){
    header('location: ../index.php');
    exit;
}
$mensagem = '';

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
    $mensagem = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Login</title>
    <link rel="stylesheet" href="../styles/loginUsuario.css">
</head>
<body>
    <div class="loginContainer">
        <h1>CADASTRAR</h1>
        <?php if ($mensagem) echo "<p style='color:red;'>$mensagem</p>"; ?>
        <form method="post" action="../controller/UsuarioController.php">
            Usuário: <input type="text" name="username" required>
            Senha: <input type="password" name="senha" required>
            Confirmar senha: <input type="password" name="conf_senha" required>
            <button type="submit" name="acao" value="cadastro">Cadastrar</button>
            <a href="loginUsuario.php" style="color: blueviolet;">Já sou cadastrado!</a>
        </form>
    </div>
</body>
</html>
