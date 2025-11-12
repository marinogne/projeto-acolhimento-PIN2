<?php
include_once('../model/dao/CidadaoDao.php');
include_once('../model/dao/VoluntarioDao.php');
include_once('../model/dao/FuncionarioDao.php');
include_once('../model/dao/OcorrenciaDao.php');

session_start();

$dashboardData = [];

$cidadaoDao = new CidadaoDao();
$ocorrenciaDao = new OcorrenciaDao();
$funcionarioDao = new FuncionarioDao();
$voluntarioDao = new VoluntarioDao();


$dashboardData['totalVitimas'] = $cidadaoDao->contarTotalCidadaos();
$dashboardData['totalOcorrencias'] = $ocorrenciaDao->contarTotalOcorrencias();
$dashboardData['totalFuncionarios'] = $funcionarioDao->contarTotalFuncionarios();
$dashboardData['totalVoluntarios'] = $voluntarioDao->contarTotalVoluntarios();

$dadosBrutosViolencia = $ocorrenciaDao->contarTiposViolencia();

$contagemNormalizada = [];

foreach ($dadosBrutosViolencia as $registro) {
    // 1. Pega a string de tipos e a padroniza para minúsculas
    $tiposString = mb_strtolower($registro['tipo_violencia']);
    
    // 2. Separa a string em um array de tipos individuais
    //    Usando a vírgula (,) como separador, e removendo espaços em branco em excesso
    $tiposArray = array_map('trim', explode(',', $tiposString));
    
    // 3. O valor total da contagem original (sempre 1, já que cada linha do BD é única)
    $contagemOriginal = $registro['total'];
    
    // 4. Itera sobre cada tipo individual e acumula a contagem
    foreach ($tiposArray as $tipo) {
        // Inicializa se o tipo for novo, ou adiciona a contagem existente
        if (isset($contagemNormalizada[$tipo])) {
            $contagemNormalizada[$tipo] += $contagemOriginal;
        } else {
            $contagemNormalizada[$tipo] = $contagemOriginal;
        }
    }
}

$dashboardData['tiposViolenciaChart'] = [
    'labels' => array_keys($contagemNormalizada),
    'data' => array_values($contagemNormalizada)
];



$_SESSION['dashboard_data'] = $dashboardData;

header('Location: ../view/admDashboard.php');
exit;

?>