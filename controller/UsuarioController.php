<?php
require_once "../model/dao/UsuarioDao.php";
include_once('../model/classes/Usuario.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST['acao'])) {

        $acao = $_POST["acao"];

        if ($acao === "cadastro") {

            $username = htmlspecialchars_decode(strip_tags($_POST['username']));
            $senha_pura = htmlspecialchars_decode(strip_tags($_POST['senha']));
            $conf_senha = htmlspecialchars_decode(strip_tags($_POST['conf_senha']));

            if($senha_pura !== $conf_senha){
                $_SESSION['msg'] = "Confirmação de senha falhou. Certifique-se de que os campos \"Senha\" e \"Confirmar Senha\" coincidam.";
                header('location: ../view/cadastrarUsuario.php');
                exit;

            }else{

                $senha_cripto = password_hash($senha_pura,PASSWORD_DEFAULT);
                $tipo_usuario = "Vitima";

                $usuario = new Usuario(null,$username,$senha_cripto,$tipo_usuario);

                $usuarioDao = new UsuarioDao();

                if($usuarioDao->verificarUsuarioExiste($usuario)){
                    $_SESSION['msg'] = "Erro: O nome de usuário (login) '{$usuario->getUsuario()}' já está em uso. Escolha outro.";
                    header('location: ../view/cadastrarUsuario.php');
                    exit;
                }

                if($usuarioDao->InserirUsuario($usuario)){
                    $_SESSION['msg'] = "Usuario inserido com sucesso";
                    
                }else{
                    $_SESSION['msg'] = "Não foi possivel incluir o usuario.";
                }
            }
            header('location: ../view/loginUsuario.php');
            exit;
        }

        if ($acao === "login") {

            $username = htmlspecialchars_decode(strip_tags($_POST['username']));
            $senha_pura = htmlspecialchars_decode(strip_tags($_POST['senha']));

            if(empty($username) || empty($senha_pura)){
                $_SESSION['msg'] = "Favor informar Usuario e Senha!";
                header('location: ../view/loginUsuario.php');
                exit;
            }

            $usuarioDao = new UsuarioDao();
            $usuario = $usuarioDao->verificarLogin($username);

            if($usuario !== null){
                $senha_cripto = $usuario->getSenha();

                if(password_verify($senha_pura,$senha_cripto)){

                    $_SESSION['logado']= true;
                    $_SESSION['username']= $usuario->getUsuario();
                    $_SESSION['userid'] = $usuario->getIdUsuario();
                    $_SESSION['tipo_usuario'] = $usuario->getTipoUsuario();

                    header('location: ../index.php');
                    exit;
                }else{
                    $_SESSION['msg'] = "Usuario ou Senha invalido!";
                }
            }else{

                $_SESSION['msg'] = "Usuario ou Senha não Encontrado!";
            }
            header('location: ../view/loginUsuario.php');
            exit;
        }
    }
}
