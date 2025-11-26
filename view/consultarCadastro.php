<?php
include_once('../controller/VitimaController.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
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

$nome = $vitima_completa["nome"];
$cpf = $vitima_completa["cpf"];
$data_nascimento = $vitima_completa["data_nasci"];
$telefone = $vitima_completa["telefone"];
$endereco = $vitima_completa["endereco"];
$nome_mae = $vitima_completa["nome_mae"];
$etnia = $vitima_completa["etnia"];
$possui_renda = $vitima_completa["possui_renda"];
$recebe_auxilio = $vitima_completa["recebe_auxilio"];
$trabalha = $vitima_completa["trabalha"];
$escolaridade = $vitima_completa["escolaridade"];
$possui_filhos = $vitima_completa["possui_filhos"];
$qtd_filhos_menores = $vitima_completa["qtd_filhos_menores"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuario</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/forms.css">
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
            <p>Bem-vinda! ** <?= $username ?> **</p>
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
            <?php if (isset($_SESSION['cadastro']) && $_SESSION['cadastrado'] === true): ?>
            <a href="../controller/ValidarCadastro.php">Criar Cadastro Completo</a>
            <?php endif ?>
            <a href="consultarCadastro.php">Exibir Cadastro Pessoal</a>
            <a href="consultarOcorrencia.php">Consultar Ocorrencia</a>
            <a href="novaOcorrencia.php">Nova Ocorrencia</a>
        </nav>
        <div>
            <form action="../controller/VitimaController.php" method="POST">
                <?php if ($mensagem)
                    echo "<p style='color:red;'>$mensagem</p>"; ?>
                <h2>Ficha de Cadastro</h2>
                <div class="form-group">
                    <label for="nome_completo">Nome completo:</label>
                    <input type="text" id="nome_completo" name="nome_completo" required value="<?= $nome ?>">
                </div>
                <div class="campo-linha">
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" required value="<?= $cpf ?>">
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data de nascimento:</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $data_nascimento ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" value="<?= $telefone ?>">
                    </div>
                    <div class="form-group">
                        <label for="etnia">Etnia:</label>
                        <select id="etnia" name="etnia">
                            <option value="">Selecione...</option>
                            <option value="branca" <?= $etnia == 'branca' ? 'selected' : '' ?>>Branca</option>
                            <option value="preta" <?= $etnia == 'preta' ? 'selected' : '' ?>>Preta</option>
                            <option value="parda" <?= $etnia == 'parda' ? 'selected' : '' ?>>Parda</option>
                            <option value="amarela" <?= $etnia == 'amarela' ? 'selected' : '' ?>>Amarela</option>
                            <option value="indigena" <?= $etnia == 'indigena' ? 'selected' : '' ?>>Indígena</option>
                            <option value="outra" <?= $etnia == 'outra' ? 'selected' : '' ?>>Outra</option>
                            <option value="nao_informada" <?= $etnia == 'nao_informada' ? 'selected' : '' ?>>Não Informada</option>
                            <option value="sem_declaracao" <?= $etnia == 'sem_declarcao' ? 'selected' : '' ?>>Sem Declaração</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="possui_renda">Possui renda:</label>
                        <select id="possui_renda" name="possui_renda">
                            <option value="">Selecione...</option>
                            <option value="sim" <?= $possui_renda == 'sim' ? 'selected' : '' ?>>Sim</option>
                            <option value="nao" <?= $possui_renda == 'nao' ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recebe_auxilio">Recebe auxílio:</label>
                        <select id="recebe_auxilio" name="recebe_auxilio">
                            <option value="">Selecione...</option>
                            <option value="sim" <?= $recebe_auxilio == 'sim' ? 'selected' : '' ?>>Sim</option>
                            <option value="nao" <?= $recebe_auxilio == 'nao' ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trabalha">Trabalha:</label>
                        <select id="trabalha" name="trabalha">
                            <option value="">Selecione...</option>
                            <option value="sim"<?= $trabalha == 'sim' ? 'selected' : '' ?>>Sim</option>
                            <option value="nao"<?= $trabalha == 'nao' ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="escolaridade">Nível de escolaridade:</label>
                        <select id="escolaridade" name="escolaridade">
                            <option value="">Selecione...</option>
                            <option value="fundamental_incompleto" <?= $escolaridade == 'fundamental_incompleto' ? 'selected' : '' ?>>Fundamental
                                Incompleto</option>
                            <option value="fundamental_completo" <?= $escolaridade == 'fundamental_completo' ? 'selected' : '' ?>>Fundamental
                                Completo</option>
                            <option value="medio_incompleto" <?= $escolaridade == 'medio_incompleto' ? 'selected' : '' ?>>Médio Incompleto
                            </option>
                            <option value="medio_completo" <?= $escolaridade == 'medio_completo' ? 'selected' : '' ?>>Médio Completo</option>
                            <option value="superior_incompleto" <?= $escolaridade == 'superior_incompleto' ? 'selected' : '' ?>>Superior Incompleto
                            </option>
                            <option value="superior_completo" <?= $escolaridade == 'superior_completo' ? 'selected' : '' ?>>Superior Completo
                            </option>
                            <option value="pos_graduacao" <?= $escolaridade == 'pos_graduacao' ? 'selected' : '' ?>>Pós-Graduação</option>
                            <option value="nao_alfabetizado" <?= $escolaridade == 'nao_alfabetizado' ? 'selected' : '' ?>>Não Alfabetizado
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" value="<?= $endereco ?>">
                </div>
                <div class="form-group">
                    <label for="nome_mae">Nome da Mãe:</label>
                    <input type="text" id="nome_mae" name="nome_mae" value="<?= $nome_mae ?>">
                </div>
                <div class="form-group">
                        <label for="filho">Possui Filhos?</label>
                        <select id="filho" name="filho">
                                <option value="">Selecione...</option>
                                <option value="sim" <?= $possui_filhos == 'sim' ? 'selected' : '' ?>>Sim</option>
                                <option value="nao" <?= $possui_filhos == 'nao' ? 'selected' : '' ?>>Não</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="qtd_filho">Quantos filhos Menores de Idade?</label>
                        <input type="number" id="qtd_filho" name="qtd_filho" value="<?= $qtd_filhos_menores ?>">
                </div>
                <div class="botoes">
                    <button type="submit" name="acao" value="Alterar">Salvar Alteração</button>
                </div>
                

        </div><br><br>


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