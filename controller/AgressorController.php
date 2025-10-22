<?php

include_once ('../model/classes/Agressor.php');
include_once('../model/dao/AgressorDao.php'); 
include_once ('../controller/Data.php');

session_start();



extract($_REQUEST, EXTR_SKIP);

if (isset($acao)) {

    if ($acao == "Incluir") {
        if (isset($idAgressor)&& isset($nome) && isset($endereco)) {
            
            $idAgressor = htmlspecialchars_decode
            (strip_tags($idAgressor));
            (strip_tags($nome));
            $endereco = htmlspecialchars_decode
            (strip_tags($endereco));
            
            if($idAgressor && $nome && $endereco){
               
                if (is_string($idAgressor) && is_string($nome) && is_string($endereco)) {
                    $agressor= new Agressor (null,
                    $nome, $endereco);

          
            
                    $agressorDao = new AgressorDao ();

                 
                    $ok = false;
                    if (method_exists($agressorDao, 'incluirAgressor')) {
                        $ok = $agressorDao->incluirAgressor($agressor);
                    } elseif (method_exists($agressorDao, 'inserir')) {
                        $ok = $agressorDao->inserir($agressor);
                    } elseif (method_exists($agressorDao, 'inserirAgressor')) {
                        $ok = $agressorDao->inserirAgressor($agressor);
                    } elseif (method_exists($agressorDao, 'create')) {
                        $ok = $agressorDao->create($agressor);
                    } else {
                       
                        $ok = false;
                    }

                    if($ok){
                        $_SESSION['msg'] = "\n" ."Novo Agressor cadastrado com sucesso !!";
                        $_SESSION['tipo'] = "sucesso";     
                    } else {
                        $_SESSION['msg'] =  "\n" ."Falha no INSERT!";
                        $_SESSION['tipo'] = "erro";
                    }
   }
      }
    }   
    }
    $path = $_SERVER['HTTP_REFERER'];
    header("Location: $path");  
    exit(); 
}