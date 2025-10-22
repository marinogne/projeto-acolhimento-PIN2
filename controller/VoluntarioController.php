<?php
include_once('../model/classes/Voluntario.php');
include_once('../model/dao/VoluntarioDao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "Incluir") {

    $nome            = trim((string)filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $emailRaw        = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email           = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';
    $telefone        = trim((string)filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS));
    $disponibilidade = trim((string)filter_input(INPUT_POST, 'disponibilidade', FILTER_SANITIZE_SPECIAL_CHARS));
    $areasArr        = filter_input(INPUT_POST, 'areas', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    $areasArr  = is_array($areasArr) ? array_map('trim', $areasArr) : [];
    $areasCsv  = implode(',', $areasArr);

    if (empty($nome) || empty($email) || empty($telefone) || empty($disponibilidade)) {
        $_SESSION['msg'] = "Por favor, preencha nome, e-mail, telefone e disponibilidade.";
        header('Location: ../view/cadastroVoluntario.php');
        exit;
    }

    $dao = new VoluntarioDao();

    if ($dao->existePorEmail($email)) {
        $_SESSION['msg'] = "Já existe um voluntário cadastrado com este e-mail.";
        header('Location: ../view/cadastroVoluntario.php');
        exit;
    }

    if ($dao->existePorNomeTelefone($nome, $telefone)) {
        $_SESSION['msg'] = "Já existe um voluntário cadastrado com este nome e telefone.";
        header('Location: ../view/cadastroVoluntario.php');
        exit;
    }

    $vol = new Voluntario(
        null,
        $nome,
        $email,
        $telefone,
        $disponibilidade,
        $areasCsv
    );

    $id = $dao->inserirVoluntario($vol);

    if ($id === false) {
        if (!isset($_SESSION['msg'])) {
            $_SESSION['msg'] = "Não foi possível inserir o voluntário. Tente novamente.";
        }
        header('Location: ../view/cadastroVoluntario.php');
        exit;
    }

    $_SESSION['msg'] = "Sucesso: Cadastro de voluntário concluído!";
    header('Location: ../view/cadastroVoluntario.php');
    exit;
}
