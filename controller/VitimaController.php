<?php
require_once "../model/dao/UsuarioDao.php";

class UsuarioController {
    private $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDao();
    }

    public function login($idUsuario, $senha) {
        if ($this->usuarioDao->verificarLogin($idUsuario, $senha)) {
            session_start();
            $_SESSION['usuario'] = $idUsuario;
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: loginUsuario.php");
        exit;
    }
}
