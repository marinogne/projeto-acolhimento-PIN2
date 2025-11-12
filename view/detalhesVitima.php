<?php
include_once('../controller/DetalhesVitimaController.php');
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
$mensagem = '';

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    $mensagem = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

$vitima_completa = $_SESSION['vitima_completa'] ;
unset($_SESSION['vitima_completa']);

if(isset($_SESSION['id_atual'])){
    unset($_SESSION['id_atual']);
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

$qtd_ocorrencias = $_SESSION['qtd_ocorrencias'] ?? 0;
$array_violencia = [];

if (isset($_SESSION['ocorrencia-final']) && $_SESSION['ocorrencia-final'] !== null) {

    $ocorrencia_final = $_SESSION['ocorrencia-final'];

    $id_ocorrencia = $ocorrencia_final['numero_ocorrencia'] + 1;
    $violencia_sofrida = $ocorrencia_final['tipo_violencia'];
    $array_violencia = explode(',', $violencia_sofrida);
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
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>Consultar Vítimas</title>
    <link rel="stylesheet" href="../styles/consulta.css">
    <link rel="stylesheet" href="../styles/forms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <main class="consulta-wrapper">
        <div class="consulta-header">
            <h1>Detalhes da Vítimas</h1>
            <a class="btn" href="consultarVitima.php">Voltar</a>
        </div>

        <div>
            <form action="../controller/DetalhesVitimaController.php" method="GET">
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
                        <input type="tel" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX"
                            value="<?= $telefone ?>">
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
                            <option value="nao_informada" <?= $etnia == 'nao_informada' ? 'selected' : '' ?>>Não Informada
                            </option>
                            <option value="sem_declaracao" <?= $etnia == 'sem_declarcao' ? 'selected' : '' ?>>Sem
                                Declaração</option>
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
                            <option value="sim" <?= $trabalha == 'sim' ? 'selected' : '' ?>>Sim</option>
                            <option value="nao" <?= $trabalha == 'nao' ? 'selected' : '' ?>>Não</option>
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
                            <option value="medio_incompleto" <?= $escolaridade == 'medio_incompleto' ? 'selected' : '' ?>>
                                Médio Incompleto
                            </option>
                            <option value="medio_completo" <?= $escolaridade == 'medio_completo' ? 'selected' : '' ?>>Médio
                                Completo</option>
                            <option value="superior_incompleto" <?= $escolaridade == 'superior_incompleto' ? 'selected' : '' ?>>Superior Incompleto
                            </option>
                            <option value="superior_completo" <?= $escolaridade == 'superior_completo' ? 'selected' : '' ?>>Superior Completo
                            </option>
                            <option value="pos_graduacao" <?= $escolaridade == 'pos_graduacao' ? 'selected' : '' ?>>
                                Pós-Graduação</option>
                            <option value="nao_alfabetizado" <?= $escolaridade == 'nao_alfabetizado' ? 'selected' : '' ?>>
                                Não Alfabetizado
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
            </form><br>
        

        <form action="../controller/DetalhesVitimaController.php" method="POST">

            <div class="form-group">
                <label for="">Quantidade de Ocorrencias Localizadas:
                    <?= $qtd_ocorrencias ?></label>
                <hr>
                <label for="qtd_ocorrencia">Consultar Ocorrencia:</label>
                <div class="btn-consulta">
                    <input type="number" min="1" max="<?= $qtd_ocorrencias ?>" id="qtd_ocorrencia" name="qtd_ocorrencia"
                        value="<?= $id_ocorrencia ?>">
                    <button type="submit" id="btn-consulta" name="acao" value="Consultar">Consultar</button>
                </div>

            </div>

            <h2>Ficha de Ocorrencia</h2>

            <div class="form-group">
                <label for="violencia_sofrida">Tipo de violência sofrida:</label>
                <div class="checkbox-container">
                    <div>
                        <input type="checkbox" id="violencia_fisica" name="violencia_sofrida[]" value="fisica"
                            <?= in_array('fisica', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_fisica" value="checked">Física</label>
                    </div>
                    <div>
                        <input type="checkbox" id="violencia_verbal" name="violencia_sofrida[]" value="verbal"
                            <?= in_array('verbal', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_verbal">Verbal</label>
                    </div>
                    <div>
                        <input type="checkbox" id="violencia_psicologica" name="violencia_sofrida[]" value="psicologica"
                            <?= in_array('psicologica', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_psicologica">Psicológica</label>
                    </div>
                    <div>
                        <input type="checkbox" id="violencia_moral" name="violencia_sofrida[]" value="moral"
                            <?= in_array('moral', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_moral">Moral</label>
                    </div>
                    <div>
                        <input type="checkbox" id="violencia_sexual" name="violencia_sofrida[]" value="sexual"
                            <?= in_array('sexual', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_sexual">Sexual</label>
                    </div>
                    <div>
                        <input type="checkbox" id="violencia_patrimonial" name="violencia_sofrida[]" value="patrimonial"
                            <?= in_array('patrimonial', $array_violencia) ? 'checked' : '' ?>>
                        <label for="violencia_patrimonial">Patrimonial</label>
                    </div>
                </div>
            </div>
            <div class="section-header">
                <h2>Dados do Agressor</h2>
            </div>
            <div class="form-group">
                <label for="nome_agressor">Nome completo do agressor:</label>
                <input type="text" id="nome_agressor" name="nome_agressor"
                    value="<?php echo isset($nome_agressor) ? htmlspecialchars($nome_agressor) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="endereco_agressor">Endereço do agressor:</label>
                <input type="text" id="endereco_agressor" name="endereco_agressor"
                    value="<?php echo isset($endereco_agressor) ? htmlspecialchars($endereco_agressor) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="relacao_com_agressor">Tipo de relação com o agressor:</label>
                <input type="text" id="relacao_com_agressor" name="relacao_com_agressor"
                    placeholder="Ex: companheiro, ex-marido, pai, etc."
                    value="<?php echo isset($relacao_com_agressor) ? htmlspecialchars($relacao_com_agressor) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="tempo_relacao">Tempo de relação:</label>
                <input type="text" id="tempo_relacao" name="tempo_relacao" placeholder="Ex: 5 anos, 2 meses, etc."
                    value="<?php echo isset($tempo_relacao) ? htmlspecialchars($tempo_relacao) : ''; ?>">
            </div>


            <div class="section-header">
                <h2>Dados da Violência</h2>
            </div>
            <div class="form-group">
                <label for="agressor_antecedentes">O agressor tem antecedentes?</label>
                <select id="agressor_antecedentes" name="agressor_antecedentes">
                    <option value="">Selecione...</option>
                    <option value="sim" <?= $agressor_antecedentes = 'sim' ? 'selected' : '' ?>>Sim</option>
                    <option value="nao" <?= $agressor_antecedentes = 'nao' ? 'selected' : '' ?>>Não</option>
                    <option value="nao_sei" <?= $agressor_antecedentes = 'nao_sei' ? 'selected' : '' ?>>Não Sei Informar
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="primeira_agressao">É a primeira vez que ocorre a
                    agressão?</label>
                <select id="primeira_agressao" name="primeira_agressao">
                    <option value="">Selecione...</option>
                    <option value="sim" <?= $primeira_agressao = 'sim' ? 'selected' : '' ?>>Sim</option>
                    <option value="nao" <?= $primeira_agressao = 'nao' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="detalhe_violencia_sofrida">Detalhes do(s) tipo(s) de violência
                    sofrida:</label>
                <input type="text" id="detalhe_violencia_sofrida" name="detalhe_violencia_sofrida"
                    placeholder="Detalhe as circunstâncias da violência mais recente."
                    value="<?php echo isset($detalhe_violencia_sofrida) ? htmlspecialchars($detalhe_violencia_sofrida) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="testemunhas">Filhos presenciaram a cena ou há
                    testemunhas?</label>
                <select id="testemunhas" name="testemunhas">
                    <option value="">Selecione...</option>
                    <option value="sim_filhos" <?= $testemunhas = 'sim_filhos' ? 'selected' : '' ?>>Sim (Filhos)</option>
                    <option value="sim_outros" <?= $testemunhas = 'sim_outros' ? 'selected' : '' ?>>Sim (Outras
                        Testemunhas)</option>
                    <option value="nao" <?= $testemunhas = 'nao' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="boletim_ocorrencia">Fez boletim de ocorrência (B.O.)?</label>
                <select id="boletim_ocorrencia" name="boletim_ocorrencia">
                    <option value="">Selecione...</option>
                    <option value="sim" <?= $boletim_ocorrencia = 'sim' ? 'selected' : '' ?>>Sim</option>
                    <option value="nao" <?= $boletim_ocorrencia = 'nao' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
            <div class="form-group">
                <label for="medida_protetiva">Tem medida protetiva?</label>
                <select id="medida_protetiva" name="medida_protetiva">
                    <option value="">Selecione...</option>
                    <option value="sim" <?= $medida_protetiva = 'sim' ? 'selected' : '' ?>>Sim</option>
                    <option value="nao" <?= $medida_protetiva = 'nao' ? 'selected' : '' ?>>Não</option>
                    <option value="solicitada" <?= $medida_protetiva = 'solicitada' ? 'selected' : '' ?>>Solicitada, mas
                        não concedida
                    </option>
                </select>
            </div>

        </form>
        </div>

    </main>
</body>

</html>