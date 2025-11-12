<?php
session_start();


if (!isset($_SESSION['usuario_logado'])) {
    header('location: login.php');
    exit;
}


$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'Não Autorizado'; 


if ($tipo_usuario !== 'Administrador') {

    header('location: home.php'); 
    exit;
}


$listaVitimas = $_SESSION['lista_vitimas'] ?? [];

if (!isset($_SESSION['lista_vitimas'])) {
  header('location: ../controller/ConsultarVitimasController.php');
  exit;
}

$listaVitimas = $_SESSION['lista_vitimas'] ?? [];
$msg = $_SESSION['msg'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;

unset($_SESSION['lista_vitimas'], $_SESSION['msg'], $_SESSION['tipo']);


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Consultar Vítimas</title>
  <link rel="stylesheet" href="../styles/consulta.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
  <main class="consulta-wrapper">
    <div class="consulta-header">
      <h1>Consulta de Vítimas</h1>
      <a class="btn" href="../controller/ConsultarVitimasController.php">Recarregar lista</a>
      <a class="btn" href="admDashboard.php">Voltar</a>
    </div>

    <?php if ($msg): ?>
      <div class="alert <?= htmlspecialchars($tipo) ?>"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="table-container">
      <table class="tabela">
        <thead>
          <tr>
            <th>ID Cidadao</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Detalhes</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listaVitimas)): ?>
            <?php foreach ($listaVitimas as $vitima): ?>
              <tr>
                <td><?= htmlspecialchars($vitima['id_cidadao'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['nome'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['cpf'] ?? '') ?></td>
                <td><a href="detalhesVitima.php?id=<?= htmlspecialchars($vitima['id_cidadao'] ?? '') ?>">Detalhes</a></td>

              <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="15" style="text-align:center;">Nenhuma vítima encontrada.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>
