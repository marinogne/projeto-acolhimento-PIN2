<?php
// Exibe mensagens de sessão (sucesso/erro) no topo do formulário
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Seja Voluntário(a)</title>

  <link rel="stylesheet" href="../styles/forms.css" />
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Nunito:wght@400;600&display=swap" rel="stylesheet">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <h2>Seja voluntário(a) do nosso projeto</h2>

  <?php if (!empty($_SESSION['msg'])): ?>
    <div class="msg" style="max-width:900px;margin:10px auto 0; padding:10px 14px; border-radius:6px; background:#fff3cd; border:1px solid #ffeeba; color:#856404;">
      <b><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></b>
    </div>
  <?php endif; ?>

  <form action="../controller/VoluntarioController.php" method="POST" novalidate>
    <input type="hidden" name="acao" value="Incluir">

    <div class="campo-linha">
      <div class="form-group">
        <label for="nome">Nome completo:</label>
        <input id="nome" type="text" name="nome" required />
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input id="telefone" type="text" name="telefone" required />
      </div>
    </div>

    <div class="form-group">
      <label for="disponibilidade">Disponibilidade:</label>
      <select id="disponibilidade" name="disponibilidade" required>
        <option value="" hidden>Selecione...</option>
        <option>Manhã</option>
        <option>Tarde</option>
        <option>Noite</option>
        <option>Fins de semana</option>
      </select>
    </div>

    <div class="form-group">
      <label>Áreas de interesse:</label>
      <div class="checkbox-container" role="group" aria-label="Áreas de interesse">
        <div>
          <input id="area-psi" type="checkbox" name="areas[]" value="Apoio psicológico" />
          <label for="area-psi">Apoio psicológico</label>
        </div>
        <div>
          <input id="area-jur" type="checkbox" name="areas[]" value="Apoio jurídico" />
          <label for="area-jur">Apoio jurídico</label>
        </div>
        <div>
          <input id="area-atend" type="checkbox" name="areas[]" value="Atendimento" />
          <label for="area-atend">Atendimento</label>
        </div>
        <div>
          <input id="area-div" type="checkbox" name="areas[]" value="Divulgação" />
          <label for="area-div">Divulgação</label>
        </div>
      </div>
    </div>

      <div class="botoes">
        <button type="submit" name="acao" value="Incluir">Salvar Dados</button>
        <a href="../index.php">Voltar</a>
      </div>

</form>
</body>
</html>
