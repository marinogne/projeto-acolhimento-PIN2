<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['dashboard_data'])) {
    header('Location: ../controller/AdmDashboardController.php');
    exit;
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

$labels_json = json_encode($_SESSION['dashboard_data']['tiposViolenciaChart']['labels'] ?? []);
$data_json = json_encode($_SESSION['dashboard_data']['tiposViolenciaChart']['data'] ?? []);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuario</title>
    <link rel="stylesheet" href="../styles/adm.css">
    <link rel="stylesheet" href="../styles/cadFunc.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <img src="../img/projeto-icon.png" alt="Logo: duas flores" class="logo">
        <h1>Projeto Acolhimento</h1>
        <p>Apoio e conscientização contra a violência doméstica</p>
        <div class="botoes">
            <div class="menu-contato">
                <a href="../index.php" class="botao">Home</a>
            </div>
            <div class="menu_logout">
                <a href="../controller/logoutController.php" class="botao">Logout</a>      
            </div>
        </div>
    </header>
    <main>
        <nav>
            <a href="../controller/AdmDashboardController.php">Atualizar Dashboard</a>
            <a href="consultarVitima.php">Consultar Vitimas</a>
            <?php
            if ($_SESSION['tipo_usuario'] === "Administrador"): ?>

                <a href="cadastrarFuncionario.php">Cadastrar Funcionario</a>
            <?php endif ?>
        </nav>


        <div class="dashboard-grid">
            <div class="card">
                <h3>Vítimas Cadastradas</h3>
                <a href="consultarVitima.php">
                    <p class="big-number"><?= $_SESSION['dashboard_data']['totalVitimas'] ?></p>
                </a>
            </div>
            <div class="card">
                <h3>Ocorrências</h3>
                <p class="big-number"><?= $_SESSION['dashboard_data']['totalOcorrencias'] ?></p>
            </div>
            <div class="card">
                <h3>Funcionários</h3>
                <p class="big-number"><?= $_SESSION['dashboard_data']['totalFuncionarios'] ?></p>
            </div>
            <div class="card">
                <h3>Voluntários</h3>
                <p class="big-number"><?= $_SESSION['dashboard_data']['totalVoluntarios'] ?></p>
            </div>
        </div><br>
        

        <div class="card chart-card">
            <h3>Distribuição por Tipo de Violência</h3>
            <canvas id="violenciaChart" style="max-height: 300px;"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('violenciaChart').getContext('2d');

            const violenciaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= $labels_json ?>,
                    datasets: [{
                        label: 'Ocorrências Registradas',
                        data: <?= $data_json ?>,
                        backgroundColor: [
                            '#EA5037', 
                            '#529CEA', 
                            '#EBAB45',
                            '#53EBB8', 
                            '#DC4DFF',
                            '#A5EA50',
                            
                        ],
                        borderColor: [
                            '#EA5037',
                            '#529CEA',
                            '#EBAB45', 
                            '#53EBB8', 
                            '#DC4DFF',
                            '#A5EA50',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total de Casos'
                            }
                        }
                    }
                }
            });
        </script>

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