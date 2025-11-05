<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
    header('location: ../index.php');
    exit;
}
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] !== "Administrador") {
        header('location: ../index.php');
        exit;
}
$mensagem = '';

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    $mensagem = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuario</title>
    <link rel="stylesheet" href="../styles/cadFunc.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
    <header>
        <img src="../img/projeto-icon.png" alt="Logo: duas flores" class="logo">
        <h1>Projeto Acolhimento</h1>
        <p>Apoio e conscientização contra a violência doméstica</p>


        <div class="menu_logout">
            <a href="../controller/logoutController.php" class="botao">Logout</a>      
        </div>

        <div class="menu-contato">
            <a href="../index.php" class="botao">Home</a>
        </div>
    </header>
    <main>
        <nav>
            <a href="admDashboard.php">Dashboard</a>
            <a href="">Consultar Vitimas</a>
            <a href="cadastrarFuncionario.php">Cadastrar Funcionario</a>
        </nav>

        <form action="../controller/FuncionarioController.php" method="POST">
            <?php if ($mensagem)
                echo "<p style='color:red;'>$mensagem</p>"; ?>
            <h2>Cadastro de Funcionário</h2>


            <div class="form-group">
                <label for="nome">Nome completo:</label>
                <input type="text" id="nome" name="nome">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf">
            </div>
            <div class="form-group">
                <label for="matricula">Matricula:</label>
                <input type="text" id="matricula" name="matricula">
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo">
            </div>
            <div class="form-group">
                <label for="usuario">Usuario/Login:</label>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario que o agente cadastrou - ex: Agente@123">
            </div>


            <div class="section-header">

                <div class="botoes">
                    <button type="submit" name="acao" value="Incluir">Salvar Dados</button>
                </div>
            </div>

        </form><br><br>

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