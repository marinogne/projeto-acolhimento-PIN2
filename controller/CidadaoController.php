<?php
include_once('../model/classes/Cidadao.php');
include_once('../model/dao/CidadaoDao.php');
include_once('../model/classes/Agressor.php');
include_once('../model/dao/AgressorDao.php');
include_once('../model/classes/Vitima.php');
include_once('../model/dao/VitimaDao.php');
include_once('../model/classes/Ocorrencia.php');
include_once('../model/dao/OcorrenciaDao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Incluir") {
    
    $nome_completo = filter_input(INPUT_POST, 'nome_completo', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome_mae = filter_input(INPUT_POST, 'nome_mae', FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
    $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_SPECIAL_CHARS);
    $etnia = filter_input(INPUT_POST, 'etnia', FILTER_SANITIZE_SPECIAL_CHARS);
    $possui_renda = filter_input(INPUT_POST, 'possui_renda', FILTER_SANITIZE_SPECIAL_CHARS);
    $recebe_auxilio = filter_input(INPUT_POST, 'recebe_auxilio', FILTER_SANITIZE_SPECIAL_CHARS);
    $trabalha = filter_input(INPUT_POST, 'trabalha', FILTER_SANITIZE_SPECIAL_CHARS);
    $escolaridade = filter_input(INPUT_POST, 'escolaridade', FILTER_SANITIZE_SPECIAL_CHARS);
    $possui_filhos = filter_input(INPUT_POST, 'filho', FILTER_SANITIZE_SPECIAL_CHARS);
    $qtd_filhos_menores = filter_input(INPUT_POST, 'qtd_filho', FILTER_VALIDATE_INT);
    $violencia_sofrida = filter_input(INPUT_POST, 'violencia_sofrida', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $detalhe_violencia_sofrida = filter_input(INPUT_POST, 'detalhe_violencia_sofrida', FILTER_SANITIZE_SPECIAL_CHARS);
    $agressor_antecedentes = filter_input(INPUT_POST, 'agressor_antecedentes', FILTER_SANITIZE_SPECIAL_CHARS);
    $primeira_agressao = filter_input(INPUT_POST, 'primeira_agressao', FILTER_SANITIZE_SPECIAL_CHARS);
    $testemunhas = filter_input(INPUT_POST, 'testemunhas', FILTER_SANITIZE_SPECIAL_CHARS);
    $boletim_ocorrencia = filter_input(INPUT_POST, 'boletim_ocorrencia', FILTER_SANITIZE_SPECIAL_CHARS);
    $medida_protetiva = filter_input(INPUT_POST, 'medida_protetiva', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome_agressor = filter_input(INPUT_POST, 'nome_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco_agressor = filter_input(INPUT_POST, 'endereco_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
    $relacao_com_agressor = filter_input(INPUT_POST, 'relacao_com_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
    $tempo_relacao = filter_input(INPUT_POST, 'tempo_relacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $id_login = $_SESSION['userid'];

    if (
        empty($nome_completo) ||
        empty($nome_mae) ||
        empty($endereco) ||
        empty($cpf) ||
        empty($telefone) ||
        empty($data_nascimento) ||
        empty($etnia) ||
        empty($escolaridade) ||
        empty($possui_renda) ||
        empty($recebe_auxilio) ||
        empty($trabalha) ||
        empty($possui_filhos) ||
        empty($violencia_sofrida) || 
        empty($detalhe_violencia_sofrida) ||
        empty($agressor_antecedentes) ||
        empty($primeira_agressao) ||
        empty($testemunhas) ||
        empty($boletim_ocorrencia) ||
        empty($medida_protetiva) ||
        empty($nome_agressor) ||
        empty($endereco_agressor) ||
        empty($relacao_com_agressor) ||
        empty($tempo_relacao)
        ) {
        $_SESSION['msg'] = "Por favor, preencha todos os campos em todas as seções do formulário.";
        
        header('Location: ../view/perfilusuario.php');
        exit;
    }

    if ($possui_filhos === 'Sim') {
        if ($qtd_filhos_menores === false || $qtd_filhos_menores === null || $qtd_filhos_menores < 0) {
            $_SESSION['msg'] = "Você indicou ter filhos. Por favor, preencha a quantidade de filhos menores com um número válido.";
            header('Location: ../view/perfilusuario.php');
            exit;
        }
    }

    $vitima = new Vitima(null,$nome_completo, $cpf, $data_nascimento, $telefone, $endereco,$id_login, $etnia, $possui_renda, $recebe_auxilio, $trabalha, $escolaridade, $nome_mae, $possui_filhos, $qtd_filhos_menores);

    $agressor = new Agressor(null, $nome_agressor, $endereco_agressor);

    $cidadaoDao = new CidadaoDao();
    $vitimaDao = new VitimaDao();
    $agressorDao = new AgressorDao();
    $ocorrenciaDao = new OcorrenciaDao();

    if ($cidadaoDao->consultarCidadaoPorCPF($vitima)) {

        $_SESSION['msg'] = "Falha: Vítima já está cadastrada no sistema. Utilize o fluxo de atualização se necessário ou inclua uma nova Ocorrencia.";

    } else {

        $id_vitima_recuperado = $cidadaoDao->inserirCidadao($vitima);

        if (!$id_vitima_recuperado) {
            $_SESSION['msg'] = "Não foi possível inserir os dados básicos do cidadão.";

        } else {

            $vitima->setIdCidadao($id_vitima_recuperado);

            if ($vitimaDao->inserirVitima($vitima)) {

                $_SESSION['msg'] = "Sucesso: Cadastro de Vítima concluído.";

                $id_agressor_recuperado = $agressorDao->inserirAgressor($agressor);

                if ($id_agressor_recuperado) {

                    $agressor->setIdAgressor($id_agressor_recuperado);

                    $ocorrencia = new Ocorrencia(
                        $id_vitima_recuperado,
                        $id_agressor_recuperado,
                        $relacao_com_agressor,
                        $tempo_relacao,
                        $violencia_sofrida,
                        $primeira_agressao,
                        $detalhe_violencia_sofrida,
                        $testemunhas,
                        $boletim_ocorrencia
                        ,
                        $medida_protetiva,
                        $agressor_antecedentes
                    );

                    if ($ocorrenciaDao->inserirOcorrencia($ocorrencia)) {
                        $_SESSION['msg'] = "Sucesso: Cadastro concluído com exito.";
                    } else {
                        $_SESSION['msg'] = "Aviso: Falha ao inserir detalhes da Ocorrencia. Revise o log de erros.";
                    }

                } else {
                    $_SESSION['msg'] = "Aviso: Falha ao inserir detalhes do Agressor. Revise o log de erros.";
                }


            } else {
                $_SESSION['msg'] = "Aviso: Falha ao inserir detalhes da Vítima. Revise o log de erros.";
            }


        }
    }

    header("Location: ../view/cadastroVitima.php");
    exit();


}
