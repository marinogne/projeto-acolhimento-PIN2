<?php
include_once __DIR__ . '/../model/classes/Vitima.php';
include_once __DIR__ . '/../model/dao/VitimaDao.php';
include_once __DIR__ . '/../model/classes/Cidadao.php';
include_once __DIR__ . '/../model/dao/CidadaoDao.php';
require_once __DIR__ . '/../model/dao/OcorrenciaDao.php';
require_once __DIR__ . '/../model/dao/AgressorDao.php';



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cidadaoDao = new CidadaoDao();
$vitimaDao = new VitimaDao();
$ocorrenciaDao = new OcorrenciaDao();
$agressorDao = new AgressorDao();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = (int) $_GET['id'];
    $_SESSION['id_atual'] = $id;

    $vitima_completa = [];

    $cidadao = $cidadaoDao->consultarCidadaoPorID($id);

    if ($cidadao) {
        $id_cidadao = $cidadao["id_cidadao"];
        $_SESSION['id_cidadao_atual'] = $id_cidadao;

        $vitima = $vitimaDao->consultarVitimaCompleto($id_cidadao) ?? [];

        $vitima_completa = array_merge($cidadao, $vitima);

        $_SESSION['vitima_completa'] = $vitima_completa;

        $id_das_ocorrencia = $ocorrenciaDao->consultarIdsOcorrenciasUsuario($id_cidadao);

        $_SESSION['qtd_ocorrencias'] = count($id_das_ocorrencia);


        if (count($id_das_ocorrencia) >= 1) {


            $id_ocorrencia = 0;
            $todas_ocorrencias = $ocorrenciaDao->consultarOcorrenciaCompleta($id_cidadao);

            $ocorrencia_pelo_id = $todas_ocorrencias[$id_ocorrencia];

            $id_agressor = $ocorrencia_pelo_id['id_agressor'];

            $agressor_completo = $agressorDao->consultarAgressorCompleto($id_agressor);

            $ocorrencia_final = array_merge($ocorrencia_pelo_id, $agressor_completo);
            $ocorrencia_final['numero_ocorrencia'] = $id_ocorrencia;

            $_SESSION['ocorrencia-final'] = $ocorrencia_final;
        }

    }

}



?>