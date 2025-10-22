<?php

require_once __DIR__ . '/../model/dao/OcorrenciaDao.php';
require_once __DIR__ . '/../model/dao/AgressorDao.php';
require_once __DIR__ . '/../model/dao/CidadaoDao.php';

session_start();

if(isset($_SESSION['userid'])){

    $id_login = $_SESSION['userid'];

    $ocorrenciaDao = new OcorrenciaDao();
    $agressorDao = new AgressorDao();
    $cidadaoDao = new CidadaoDao();

    $id_cidadao = $cidadaoDao->consultarIDCidadao($id_login);

    if($id_cidadao){
        $id_cidadao_final = $id_cidadao['id_cidadao'];

        $id_das_ocorrencia = $ocorrenciaDao->consultarIdsOcorrenciasUsuario($id_cidadao_final);

        if(count($id_das_ocorrencia) === 1){
            
            
            $id_ocorrencia = 0;
            $todas_ocorrencias = $ocorrenciaDao->consultarOcorrenciaCompleta($id_cidadao_final);

            $ocorrencia_pelo_id = $todas_ocorrencias[$id_ocorrencia];

            $id_agressor = $ocorrencia_pelo_id['id_agressor'];

            $agressor_completo = $agressorDao->consultarAgressorCompleto($id_agressor);

            $ocorrencia_final = array_merge($ocorrencia_pelo_id,$agressor_completo);
            $ocorrencia_final['numero_ocorrencia'] = $id_ocorrencia;

            $_SESSION['ocorrencia-final'] = $ocorrencia_final;
            
        }else{
            //falha consultar ocorrencias
        }
        
        
    }else{
        //falha localizar id cidadao
    }
      

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Consultar" && isset($_POST['qtd_ocorrencia'])) {

        $numero_ocorrencia = filter_input(INPUT_POST,'qtd_ocorrencia',FILTER_VALIDATE_INT);  
        

        if($numero_ocorrencia !== false && $numero_ocorrencia !== null){
            
            $id_ocorrencia = $numero_ocorrencia -1;
            $todas_ocorrencias = $ocorrenciaDao->consultarOcorrenciaCompleta($id_cidadao_final);

            $ocorrencia_pelo_id = $todas_ocorrencias[$id_ocorrencia];

            $id_agressor = $ocorrencia_pelo_id['id_agressor'];

            $agressor_completo = $agressorDao->consultarAgressorCompleto($id_agressor);

            $ocorrencia_final = array_merge($ocorrencia_pelo_id,$agressor_completo);
            $ocorrencia_final['numero_ocorrencia'] = $id_ocorrencia;

            $_SESSION['ocorrencia-final'] = $ocorrencia_final;
            header('location: ../view/consultarOcorrencia.php');
        }else{
            //falha consultar ocorrencias
        }
    }

}