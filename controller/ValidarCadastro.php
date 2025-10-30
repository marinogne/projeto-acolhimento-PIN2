<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['logado'])){
    header('location: ../index.php');
    exit;
}

require_once __DIR__ . '/../model/dao/ConexaoBanco.php';
require_once __DIR__ . '/../model/dao/CidadaoDao.php';

if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === "Administrador") {
        $_SESSION['alerta'] = "Bem-vindo ao Dashboard!";
        header('location: ../view/perfilusuario.php');
        
} else {

if(isset($_SESSION['userid'])){
    $cidadaoDao = new CidadaoDao();
    $id_login = $_SESSION['userid'];

    if($cidadaoDao->consultarIDCidadaoExiste($id_login)){
        $_SESSION['msg'] = "Cadastro recuperado com sucesso!";
        $_SESSION['cadastrado'] = true;
        header(('location: ../view/consultarCadastro.php'));
        exit;
    }else{
        $_SESSION['alerta'] = "Por Favor preencher todos os campos formulário!";
        $_SESSION['cadastrado'] = false;
        header('location: ../view/perfilusuario.php');
    }
}

}

