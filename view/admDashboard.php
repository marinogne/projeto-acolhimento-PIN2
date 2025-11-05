<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
    header('location: ../index.php');
    exit;
}
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === "Vitima") {
        header('location: ../index.php');
        exit;
}
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

$mensagem = '';

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    $mensagem = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
$alerta = null;

if (isset($_SESSION['alerta'])) {
    $alerta = $_SESSION['alerta'];
    unset($_SESSION['alerta']);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuario</title>
    <link rel="stylesheet" href="../styles/adm.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
    <?php if ($alerta): ?>
        <script>
            alert(<?php echo json_encode($alerta); ?>);
        </script>
    <?php endif; ?>
    <header>
        <img src="../img/projeto-icon.png" alt="Logo: duas flores" class="logo">
        <h1>Projeto Acolhimento</h1>
        <p>Apoio e conscientização contra a violência doméstica</p>

        <div class="menu-boas-vindas">
            <p>Acessado,  <?= $username ?> </p>
        </div>

        <div class="menu_logout">
            <a href="../controller/logoutController.php" class="botao">Logout</a>      
        </div>

        <div class="menu-contato">
            <a href="../index.php" class="botao">Home</a>
        </div>
    </header>
    <main>
        <nav>
            <a href="consultarVitima.php">Consultar Vitimas</a>
            
            <?php
            if($_SESSION['tipo_usuario'] === "Administrador"): ?>
            
            <a href="cadastrarFuncionario.php">Cadastrar Funcionario</a>

            <?php endif ?>
            
        </nav>
        
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Projeto Acolhimento. Todos os direitos reservados.</p>
            <div class="protection-links">
                <a href="https://www.institutomariadapenha.org.br" target="_blank">Instituto Maria da Penha</a> |
                <a href="https://www.justiceiras.org.br" target="_blank">Projeto Justiceiras</a> |
                <a href="https://www.mapadoacolhimento.org" target="_blank">Mapa do Acolhimento</a> |
                <a href="tel:180">Ligue 180</a> |
                <a href="https://www.gov.br/mulheres/pt-br/assuntos/violencia-contra-a-mulher/canais-de-denuncia"
                    target="_blank">Canais de Denúncia</a>
            </div>
        </div>
    </footer>
</body>

</html>