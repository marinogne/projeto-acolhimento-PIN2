<!-- esse usuario dao nao esta linkado a nenhum banco de dados
 os usuarios estao armazenados aqui mesmo -->


<?php

require_once "../model/classes/Usuario.php";

class UsuarioDao {
    private $usuarios;

    public function __construct() {
        $this->usuarios = [
            "usuario01" => password_hash("12345", PASSWORD_DEFAULT),
            "usuario02"  => password_hash("senha123", PASSWORD_DEFAULT)
        ];
    }

    public function verificarLogin($idUsuario, $senha) {
        if (isset($this->usuarios[$idUsuario]) && password_verify($senha, $this->usuarios[$idUsuario])) {
            return true;
        }
        return false;
    }
}
