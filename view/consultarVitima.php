<?php
session_start();

if (!isset($_SESSION['logado'])) {
    header('location: ../index.php');
    exit;
}
if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] !== "Administrador") {
        header('location: ../index.php');
        exit;
}
$listaVitimas = $_SESSION['lista_vitimas'] ?? [];
$msg  = $_SESSION['msg']  ?? null;
$tipo = $_SESSION['tipo'] ?? null;

unset($_SESSION['lista_vitimas'], $_SESSION['msg'], $_SESSION['tipo']);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Consultar Vítimas</title>
    <link rel="stylesheet" href="../styles/consulta.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
            <th>Data Nascimento</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>ID Login</th>
            <th>Etinia</th>
            <th>Possui Renda</th>
            <th>Recebe Auxilio</th>
            <th>Trebalha</th>
            <th>Escolaridade</th>
            <th>Nome Mãe</th>
            <th>Possui Filhos</th>
            <th>Qtd Filhos Menores</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($listaVitimas)): ?>
            <?php foreach ($listaVitimas as $vitima): ?>
              <tr>
                <td><?= htmlspecialchars($vitima['id_cidadao'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['nome'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['cpf'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['data_nascimento'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['telefone'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['endereco'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['id_login'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['etnia'] ?? '') ?></td>

                <td><?= htmlspecialchars($vitima['possuiRenda'] ?? $vitima['possui_renda'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['recebeAuxilio'] ?? $vitima['recebe_auxilio'] ?? '') ?></td>

                <td><?= htmlspecialchars($vitima['trabalha'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['escolaridade'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['nomeMae'] ?? $vitima['nome_mae'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['possuiFilhos'] ?? $vitima['possui_filhos'] ?? '') ?></td>
                <td><?= htmlspecialchars($vitima['qtdFilhosMenores'] ?? $vitima['qtd_filhos_menores'] ?? '') ?></td>
              </tr>
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
