<?php
include_once('../controller/OcorrenciaController.php');
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}
if (!isset($_SESSION['logado'])) {
        header('location: ../index.php');
        exit;
}

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

$qtd_ocorrencias = count($id_das_ocorrencia);
$array_violencia = [];

if(isset($_SESSION['ocorrencia-final']) && $_SESSION['ocorrencia-final'] !== null){
        
        $ocorrencia_final = $_SESSION['ocorrencia-final'];

        $id_ocorrencia = $ocorrencia_final['numero_ocorrencia'] + 1;
        $violencia_sofrida = $ocorrencia_final['tipo_violencia'];
        $array_violencia = explode(',',$violencia_sofrida);
        $nome_agressor = $ocorrencia_final['0']['nome'];
        $endereco_agressor = $ocorrencia_final['0']['endereco'];
        $relacao_com_agressor = $ocorrencia_final['relacao_com_agressor'];
        $tempo_relacao = $ocorrencia_final['tempo_relacao'];
        $agressor_antecedentes = $ocorrencia_final['agressor_antecedentes'];
        $primeira_agressao = $ocorrencia_final['primeira_agressao'];
        $detalhe_violencia_sofrida = $ocorrencia_final['detalhe_violencia'];
        $testemunhas = $ocorrencia_final['testemunhas'];
        $boletim_ocorrencia = $ocorrencia_final['boletim_ocorrencia'];
        $medida_protetiva = $ocorrencia_final['medida_protetiva'];

}



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

                <form action="../controller/OcorrenciaController.php" method="POST">

                        <div class="form-group">
                                <label for="">Quantidade de Ocorrencias Localizadas:
                                        <?= $qtd_ocorrencias ?></label><hr>
                                <label for="qtd_ocorrencia">Consultar Ocorrencia:</label>
                                <div class="btn-consulta">
                                        <input type="number" min="1" max="<?= $qtd_ocorrencias ?>" id="qtd_ocorrencia" name="qtd_ocorrencia" value="<?= $id_ocorrencia ?>">
                                        <button type="submit" id="btn-consulta" name="acao" value="Consultar" >Consultar</button>
                                </div>
                                
                        </div>

                        <h2>Ficha de Ocorrencia</h2>

                        <div class="form-group">
                                <label for="violencia_sofrida">Tipo de violência sofrida:</label>
                                <div class="checkbox-container">
                                        <div>
                                                <input type="checkbox" id="violencia_fisica" name="violencia_sofrida[]"
                                                        value="fisica"<?= in_array('fisica',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_fisica" value="checked">Física</label>
                                        </div>
                                        <div>
                                                <input type="checkbox" id="violencia_verbal" name="violencia_sofrida[]"
                                                        value="verbal"<?= in_array('verbal',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_verbal">Verbal</label>
                                        </div>
                                        <div>
                                                <input type="checkbox" id="violencia_psicologica"
                                                        name="violencia_sofrida[]" value="psicologica"<?= in_array('psicologica',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_psicologica">Psicológica</label>
                                        </div>
                                        <div>
                                                <input type="checkbox" id="violencia_moral" name="violencia_sofrida[]"
                                                        value="moral"<?= in_array('moral',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_moral">Moral</label>
                                        </div>
                                        <div>
                                                <input type="checkbox" id="violencia_sexual" name="violencia_sofrida[]"
                                                        value="sexual"<?= in_array('sexual',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_sexual">Sexual</label>
                                        </div>
                                        <div>
                                                <input type="checkbox" id="violencia_patrimonial"
                                                        name="violencia_sofrida[]" value="patrimonial" <?= in_array('patrimonial',$array_violencia) ? 'checked' : '' ?>>
                                                <label for="violencia_patrimonial">Patrimonial</label>
                                        </div>
                                </div>
                        </div>
                        <div class="section-header">
                                <h2>Dados do Agressor</h2>
                        </div>
                        <div class="form-group">
                                <label for="nome_agressor">Nome completo do agressor:</label>
                                <input type="text" id="nome_agressor" name="nome_agressor" value="<?php echo isset($nome_agressor) ? htmlspecialchars($nome_agressor) : ''; ?>">
                        </div>
                        <div class="form-group">
                                <label for="endereco_agressor">Endereço do agressor:</label>
                                <input type="text" id="endereco_agressor" name="endereco_agressor" value="<?php echo isset($endereco_agressor) ? htmlspecialchars($endereco_agressor) : ''; ?>">
                        </div>
                        <div class="form-group">
                                <label for="relacao_com_agressor">Tipo de relação com o agressor:</label>
                                <input type="text" id="relacao_com_agressor" name="relacao_com_agressor"
                                        placeholder="Ex: companheiro, ex-marido, pai, etc." value="<?php echo isset($relacao_com_agressor) ? htmlspecialchars($relacao_com_agressor) : ''; ?>">
                        </div>
                        <div class="form-group">
                                <label for="tempo_relacao">Tempo de relação:</label>
                                <input type="text" id="tempo_relacao" name="tempo_relacao"
                                        placeholder="Ex: 5 anos, 2 meses, etc." value="<?php echo isset($tempo_relacao) ? htmlspecialchars($tempo_relacao) : ''; ?>">
                        </div>


                        <div class="section-header">
                                <h2>Dados da Violência</h2>
                        </div>
                        <div class="form-group">
                                <label for="agressor_antecedentes">O agressor tem antecedentes?</label>
                                <select id="agressor_antecedentes" name="agressor_antecedentes">
                                        <option value="">Selecione...</option>
                                        <option value="sim"<?= $agressor_antecedentes = 'sim' ? 'selected' : '' ?>>Sim</option>
                                        <option value="nao"<?= $agressor_antecedentes = 'nao' ? 'selected' : '' ?>>Não</option>
                                        <option value="nao_sei"<?= $agressor_antecedentes = 'nao_sei' ? 'selected' : '' ?>>Não Sei Informar</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="primeira_agressao">É a primeira vez que ocorre a
                                        agressão?</label>
                                <select id="primeira_agressao" name="primeira_agressao">
                                        <option value="">Selecione...</option>
                                        <option value="sim"<?= $primeira_agressao = 'sim' ? 'selected' : '' ?>>Sim</option>
                                        <option value="nao"<?= $primeira_agressao = 'nao' ? 'selected' : '' ?>>Não</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="detalhe_violencia_sofrida">Detalhes do(s) tipo(s) de violência
                                        sofrida:</label>
                                <input type="text" id="detalhe_violencia_sofrida" name="detalhe_violencia_sofrida"
                                        placeholder="Detalhe as circunstâncias da violência mais recente." value="<?php echo isset($detalhe_violencia_sofrida) ? htmlspecialchars($detalhe_violencia_sofrida) : ''; ?>">
                        </div>
                        <div class="form-group">
                                <label for="testemunhas">Filhos presenciaram a cena ou há
                                        testemunhas?</label>
                                <select id="testemunhas" name="testemunhas">
                                        <option value="">Selecione...</option>
                                        <option value="sim_filhos" <?= $testemunhas = 'sim_filhos' ? 'selected' : '' ?>>Sim (Filhos)</option>
                                        <option value="sim_outros"<?= $testemunhas = 'sim_outros' ? 'selected' : '' ?>>Sim (Outras Testemunhas)</option>
                                        <option value="nao"<?= $testemunhas = 'nao' ? 'selected' : '' ?>>Não</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="boletim_ocorrencia">Fez boletim de ocorrência (B.O.)?</label>
                                <select id="boletim_ocorrencia" name="boletim_ocorrencia">
                                        <option value="">Selecione...</option>
                                        <option value="sim"<?= $boletim_ocorrencia = 'sim' ? 'selected' : '' ?>>Sim</option>
                                        <option value="nao" <?= $boletim_ocorrencia = 'nao' ? 'selected' : '' ?>>Não</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label for="medida_protetiva">Tem medida protetiva?</label>
                                <select id="medida_protetiva" name="medida_protetiva">
                                        <option value="">Selecione...</option>
                                        <option value="sim" <?= $medida_protetiva = 'sim' ? 'selected' : '' ?>>Sim</option>
                                        <option value="nao"<?= $medida_protetiva = 'nao' ? 'selected' : '' ?>>Não</option>
                                        <option value="solicitada"<?= $medida_protetiva = 'solicitada' ? 'selected' : '' ?>>Solicitada, mas não concedida
                                        </option>
                                </select>
                        </div>

                </form>
                <br><br>

        </main>
        <footer>
                <div class="footer-content">
                        <p>&copy; 2025 Projeto Acolhimento. Todos os direitos reservados.</p>
                        <div class="protection-links">
                                <a href="https://www.institutomariadapenha.org.br" target="_blank">Instituto Maria da
                                        Penha</a> |
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