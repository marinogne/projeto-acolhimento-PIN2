<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
    header('location: ../index.php');
    exit;
}
$mensagem = 'Esta Funcionalidade esta indisponivel no momento, aguarde por gentileza! <br> Estamos trabalhando para melhor atende-la.';

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
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/forms.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
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
            <a href="">Excluir Cadastro </a>
        </nav>

<form action="" method="POST">
                <?php if ($mensagem)
                    echo "<p style='color:red;'>$mensagem</p>"; ?>
                <h2>Cadastrar Nova Ficha de Ocorrencia</h2>
                
                <div class="form-group">
                        <label for="violencia_sofrida">Tipo de violência sofrida:</label>
                        <div class="checkbox-container">
                                <div>
                                        <input type="checkbox" id="violencia_fisica" name="violencia_sofrida[]"
                                                value="fisica">
                                        <label for="violencia_fisica">Física</label>
                                </div>
                                <div>
                                        <input type="checkbox" id="violencia_verbal" name="violencia_sofrida[]"
                                                value="verbal">
                                        <label for="violencia_verbal">Verbal</label>
                                </div>
                                <div>
                                        <input type="checkbox" id="violencia_psicologica" name="violencia_sofrida[]"
                                                value="psicologica">
                                        <label for="violencia_psicologica">Psicológica</label>
                                </div>
                                <div>
                                        <input type="checkbox" id="violencia_moral" name="violencia_sofrida[]"
                                                value="moral">
                                        <label for="violencia_moral">Moral</label>
                                </div>
                                <div>
                                        <input type="checkbox" id="violencia_sexual" name="violencia_sofrida[]"
                                                value="sexual">
                                        <label for="violencia_sexual">Sexual</label>
                                </div>
                                <div>
                                        <input type="checkbox" id="violencia_patrimonial" name="violencia_sofrida[]"
                                                value="patrimonial">
                                        <label for="violencia_patrimonial">Patrimonial</label>
                                </div>
                        </div>
                </div>
                <div class="section-header">
                        <h2>Dados do Agressor</h2>
                </div>
                <div class="form-group">
                        <label for="nome_agressor">Nome completo do agressor:</label>
                        <input type="text" id="nome_agressor" name="nome_agressor">
                </div>
                <div class="form-group">
                        <label for="endereco_agressor">Endereço do agressor:</label>
                        <input type="text" id="endereco_agressor" name="endereco_agressor">
                </div>
                <div class="form-group">
                        <label for="relacao_com_agressor">Tipo de relação com o agressor:</label>
                        <input type="text" id="relacao_com_agressor" name="relacao_com_agressor"
                                placeholder="Ex: companheiro, ex-marido, pai, etc.">
                </div>
                <div class="form-group">
                        <label for="tempo_relacao">Tempo de relação:</label>
                        <input type="text" id="tempo_relacao" name="tempo_relacao"
                                placeholder="Ex: 5 anos, 2 meses, etc.">
                </div>
                
                
                <div class="section-header">
                        <h2>Dados da Violência</h2>
                </div>
                <div class="form-group">
                        <label for="agressor_antecedentes">O agressor tem antecedentes?</label>
                        <select id="agressor_antecedentes" name="agressor_antecedentes">
                                <option value="">Selecione...</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                                <option value="nao_sei">Não Sei Informar</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="primeira_agressao">É a primeira vez que ocorre a
                                agressão?</label>
                        <select id="primeira_agressao" name="primeira_agressao">
                                <option value="">Selecione...</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="detalhe_violencia_sofrida">Detalhes do(s) tipo(s) de violência
                                sofrida:</label>
                        <input type="text" id="detalhe_violencia_sofrida" name="detalhe_violencia_sofrida"
                                placeholder="Detalhe as circunstâncias da violência mais recente.">
                </div>
                <div class="form-group">
                        <label for="testemunhas">Filhos presenciaram a cena ou há
                                testemunhas?</label>
                        <select id="testemunhas" name="testemunhas">
                                <option value="">Selecione...</option>
                                <option value="sim_filhos">Sim (Filhos)</option>
                                <option value="sim_outros">Sim (Outras Testemunhas)</option>
                                <option value="nao">Não</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="boletim_ocorrencia">Fez boletim de ocorrência (B.O.)?</label>
                        <select id="boletim_ocorrencia" name="boletim_ocorrencia">
                                <option value="">Selecione...</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                        </select>
                </div>
                <div class="form-group">
                        <label for="medida_protetiva">Tem medida protetiva?</label>
                        <select id="medida_protetiva" name="medida_protetiva">
                                <option value="">Selecione...</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                                <option value="solicitada">Solicitada, mas não concedida
                                </option>
                        </select>
                </div>
                <button type="submit" name="acao" value="Incluir">Salvar Nova Ocorrencia</button>
                
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