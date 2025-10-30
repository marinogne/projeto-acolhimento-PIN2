<?php

include_once('../model/classes/Funcionario.php');
include_once('../model/classes/Usuario.php');
include_once('../model/dao/FuncionarioDao.php');
include_once('../model/dao/UsuarioDao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Incluir") {
    
    $matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome      = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $cargo     = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_SPECIAL_CHARS);
    $cpf       = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
    $usuario   = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$matricula || !$nome || !$cargo || !$cpf || !$usuario) {
        $_SESSION['msg'] = "Erro: Todos os campos são obrigatórios.";
    } else {
        
        $funcionarioDao = new FuncionarioDao();
        
        if ($funcionarioDao->verificarDuplicidade($matricula, $cpf)) {
            $_SESSION['msg'] = "Erro: Já existe um funcionário cadastrado com esta Matrícula ou CPF.";
            header("Location: ../view/cadastrarFuncionario.php");
            exit();
        }
        
        $usuarioDao = new UsuarioDao();
        $usuario_existente = $usuarioDao->verificarLogin($usuario);
        
        if ($usuario_existente) {
            $id_login = $usuario_existente->getIdUsuario();

            $funcionario = new Funcionario(
                null, $matricula, $nome, $cargo, $cpf, $id_login
            );
            
            if ($funcionarioDao->inserirFuncionario($funcionario)) {
                $usuarioDao->alterarTipoUsuario($usuario_existente, 'Funcionario');
                $_SESSION['msg'] = "Novo Funcionario cadastrado com sucesso!";
            } else {
                $_SESSION['msg'] = "Falha ao inserir o Funcionário no banco de dados.";
            }

        } else {
            $_SESSION['msg'] = "Erro: Usuário de login ('$usuario') não encontrado na base de usuários.";
        }
    }

    header("Location: ../view/cadastrarFuncionario.php");
    exit();
}

