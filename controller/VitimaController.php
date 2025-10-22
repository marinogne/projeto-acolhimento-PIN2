<?php

include_once __DIR__ . '/../model/classes/Vitima.php';
include_once __DIR__ . '/../model/dao/VitimaDao.php';
include_once __DIR__ . '/../model/classes/Cidadao.php';
include_once __DIR__ . '/../model/dao/CidadaoDao.php';

session_start();

if(isset($_SESSION['userid'])){

    $id_login = $_SESSION['userid'];

    $cidadaoDao = new CidadaoDao();
    $vitimaDao = new VitimaDao();

    $vitima_completa = [];

    $cidadao = $cidadaoDao->consultarCidadaoCompleto($id_login);

    if($cidadao){
        $id_cidadao = $cidadao["id_cidadao"];

        $vitima = $vitimaDao->consultarVitimaCompleto($id_cidadao) ?? [];

        $vitima_completa = array_merge($cidadao,$vitima);

    }else{
        
        $_SESSION['alerta'] = "Erro: Dados iniciais do cadastro não encontrados.\n Por Favor efetue o Cadastro!!";

        header('location: ../view/perfilusuario.php');
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Alterar") {

        $nome_completo = filter_input(INPUT_POST, 'nome_completo', FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
        $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
        $id_login = $_SESSION['userid'];
        
        
        $etnia = filter_input(INPUT_POST, 'etnia', FILTER_SANITIZE_SPECIAL_CHARS);
        $possui_renda = filter_input(INPUT_POST, 'possui_renda', FILTER_SANITIZE_SPECIAL_CHARS);
        $recebe_auxilio = filter_input(INPUT_POST, 'recebe_auxilio', FILTER_SANITIZE_SPECIAL_CHARS);
        $trabalha = filter_input(INPUT_POST, 'trabalha', FILTER_SANITIZE_SPECIAL_CHARS);
        $escolaridade = filter_input(INPUT_POST, 'escolaridade', FILTER_SANITIZE_SPECIAL_CHARS);
        $possui_filhos = filter_input(INPUT_POST, 'filho', FILTER_SANITIZE_SPECIAL_CHARS);
        $qtd_filhos_menores = filter_input(INPUT_POST, 'qtd_filho', FILTER_VALIDATE_INT);
        $nome_mae = filter_input(INPUT_POST, 'nome_mae', FILTER_SANITIZE_SPECIAL_CHARS);

        $vitima_atualizada = new Vitima($id_cidadao,$nome_completo,$cpf,$data_nascimento,$telefone,$endereco,$id_login,$etnia,$possui_renda,$recebe_auxilio,$trabalha,$escolaridade,$nome_mae,$possui_filhos,$qtd_filhos_menores);

        if($cidadaoDao->atualizarCidaddao($vitima_atualizada)){
            
            if($vitimaDao->atualizarVitima($vitima_atualizada)){
                $_SESSION['alerta'] = "Cadastro Atualizado com sucesso!";
            }else{
                $_SESSION['alerta'] = "Erro: Dados da Vítima falharam na atualização.";
            }

        }else{
            $_SESSION['alerta'] = "Erro: Dados do Cidadão falharam na atualização.";
        }

        header('Location: ../view/consultarCadastro.php');
    }
    
}

