<?php

include_once ('../model/classes/Funcionario.php');
include_once('../model/dao/FuncionarioDao.php'); 
include_once ('../controller/Data.php');

session_start();



extract($_REQUEST, EXTR_SKIP);

if (isset($acao)) {

    if ($acao == "Incluir") {
        if (isset($idFuncionario)&&  isset($matricula)&& isset($nome) && isset($cargo)&& isset($cpf)) {
            
            $idFuncionario = htmlspecialchars_decode
            (strip_tags($idFuncionario));
            $matricula = htmlspecialchars_decode
            (strip_tags($matricula));
            $nome = htmlspecialchars_decode
            (strip_tags($nome));
            $cargo = htmlspecialchars_decode
            (strip_tags($cargo));
            $cpf = htmlspecialchars_decode
            (strip_tags($cpf));
            if($idFuncionario && $matricula && $nome && $cargo && $cpf){
               
                if (is_string($nome) && is_string($cargo)) {
                    $funcionario= new Funcionario (null,
                    $matricula, $nome, $cargo, $cpf);

          
            
                    $funcionarioDao = new FuncionarioDao ();


                    if($funcionarioDao->incluirFuncionario ($porteiro)){
                        $_SESSION['msg'] = "\n" ."Novo Funcionario cadastrado com sucesso !!";
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