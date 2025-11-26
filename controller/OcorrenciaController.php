<?php

require_once __DIR__ . '/../model/dao/OcorrenciaDao.php';
require_once __DIR__ . '/../model/dao/AgressorDao.php';
require_once __DIR__ . '/../model/dao/CidadaoDao.php';

session_start();

if (isset($_SESSION['userid'])) {

    $id_login = $_SESSION['userid'];

    $ocorrenciaDao = new OcorrenciaDao();
    $agressorDao = new AgressorDao();
    $cidadaoDao = new CidadaoDao();

    $id_cidadao = $cidadaoDao->consultarIDCidadao($id_login);

    if ($id_cidadao) {
        $id_cidadao_final = $id_cidadao['id_cidadao'];

        $id_das_ocorrencia = $ocorrenciaDao->consultarIdsOcorrenciasUsuario($id_cidadao_final);

        if (count($id_das_ocorrencia) === 1) {


            $id_ocorrencia = 0;
            $todas_ocorrencias = $ocorrenciaDao->consultarOcorrenciaCompleta($id_cidadao_final);

            $ocorrencia_pelo_id = $todas_ocorrencias[$id_ocorrencia];

            $id_agressor = $ocorrencia_pelo_id['id_agressor'];

            $agressor_completo = $agressorDao->consultarAgressorCompleto($id_agressor);

            $ocorrencia_final = array_merge($ocorrencia_pelo_id, $agressor_completo);
            $ocorrencia_final['numero_ocorrencia'] = $id_ocorrencia;

            $_SESSION['ocorrencia-final'] = $ocorrencia_final;

        } else {
            //falha consultar ocorrencias
        }


    } else {
        //falha localizar id cidadao
    }


    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Consultar" && isset($_POST['qtd_ocorrencia'])) {

        $numero_ocorrencia = filter_input(INPUT_POST, 'qtd_ocorrencia', FILTER_VALIDATE_INT);


        if ($numero_ocorrencia !== false && $numero_ocorrencia !== null) {

            $id_ocorrencia = $numero_ocorrencia - 1;
            $todas_ocorrencias = $ocorrenciaDao->consultarOcorrenciaCompleta($id_cidadao_final);

            $ocorrencia_pelo_id = $todas_ocorrencias[$id_ocorrencia];

            $id_agressor = $ocorrencia_pelo_id['id_agressor'];

            $agressor_completo = $agressorDao->consultarAgressorCompleto($id_agressor);

            $ocorrencia_final = array_merge($ocorrencia_pelo_id, $agressor_completo);
            $ocorrencia_final['numero_ocorrencia'] = $id_ocorrencia;

            $_SESSION['ocorrencia-final'] = $ocorrencia_final;
            header('location: ../view/consultarOcorrencia.php');
        } else {
            //falha consultar ocorrencias
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "NovaOcorrencia") {

        $violencia_sofrida = filter_input(INPUT_POST, 'violencia_sofrida', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $nome_agressor = filter_input(INPUT_POST, 'nome_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
        $endereco_agressor = filter_input(INPUT_POST, 'endereco_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
        $relacao_com_agressor = filter_input(INPUT_POST, 'relacao_com_agressor', FILTER_SANITIZE_SPECIAL_CHARS);
        $tempo_relacao = filter_input(INPUT_POST, 'tempo_relacao', FILTER_SANITIZE_SPECIAL_CHARS);
        $detalhe_violencia_sofrida = filter_input(INPUT_POST, 'detalhe_violencia_sofrida', FILTER_SANITIZE_SPECIAL_CHARS);
        $agressor_antecedentes = filter_input(INPUT_POST, 'agressor_antecedentes', FILTER_SANITIZE_SPECIAL_CHARS);
        $primeira_agressao = filter_input(INPUT_POST, 'primeira_agressao', FILTER_SANITIZE_SPECIAL_CHARS);
        $testemunhas = filter_input(INPUT_POST, 'testemunhas', FILTER_SANITIZE_SPECIAL_CHARS);
        $boletim_ocorrencia = filter_input(INPUT_POST, 'boletim_ocorrencia', FILTER_SANITIZE_SPECIAL_CHARS);
        $medida_protetiva = filter_input(INPUT_POST, 'medida_protetiva', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_login = $_SESSION['userid'];

        if (
            empty($violencia_sofrida) ||
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

            header('Location: ../view/novaOcorrencia.php');
            exit;
        }


        $agressor = new Agressor(null, $nome_agressor, $endereco_agressor);

        $agressorDao = new AgressorDao();

        $agressor_existente = $agressorDao->consultarAgressor($agressor);

        if (!$agressor_existente) {
            // 2. Se o agressor NÃO EXISTE, insere e pega o novo ID
            $idAgressor = $agressorDao->inserirAgressor($agressor);

        } else {
            // 3. Se o agressor EXISTE, usa o ID dele
            $idAgressor = $agressor_existente->getIdAgressor(); // Presumindo que o método retorna o objeto Agressor
        }

        $cidadaoDao = new CidadaoDao();
        $id_vitima_recuperado = $cidadaoDao->consultarIDCidadao($id_login);

        if (is_array($id_vitima_recuperado) && isset($id_vitima_recuperado['id_cidadao'])) {

            $id_vitima_valido = $id_vitima_recuperado['id_cidadao'];

        } else {
            
            $id_vitima_valido = $id_vitima_recuperado;
        }

        $ocorrencia = new Ocorrencia($id_vitima_valido, $idAgressor, $relacao_com_agressor, $tempo_relacao, $violencia_sofrida, $primeira_agressao, $detalhe_violencia_sofrida, $testemunhas, $boletim_ocorrencia, $medida_protetiva, $agressor_antecedentes);

        $ocorrenciaDao = new OcorrenciaDao();

        if ($ocorrenciaDao->inserirOcorrencia($ocorrencia)) {
            $_SESSION['msg'] = "Nova Ocorrencia cadastrada com sucesso.";
            header('location: ../view/consultarocorrencia.php');
            exit();

        }

    }

}