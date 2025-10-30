<?php

require_once __DIR__ . '/../classes/Usuario.php';
include_once('ConexaoBanco.php');

class UsuarioDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function InserirUsuario($usuario)
    {
        $sql = "INSERT INTO usuario (usuario, senha, tipo_usuario) VALUES (?, ?, ?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            $erro_prepare = $this->conexao->error;
            $_SESSION['msg'] = "Falha na Preparação da Consulta! Erro - " . $erro_prepare;
            return false;
        } else {
            $user = $usuario->getUsuario();
            $senha = $usuario->getSenha();
            $tipo_usuario = $usuario->getTipoUsuario();

            $stmt->bind_param('sss', $user, $senha, $tipo_usuario);

            if ($stmt->execute() === false) {
                $msg = $stmt->error;
                $_SESSION['msg'] = "Falha ao inserir usuario! Mensagem de erro: '$msg'";

                $stmt->close();
                return false;
            } else {
                $id_inserido = $this->conexao->insert_id;
                echo "Usuario inserido com sucesso! ID - " . $id_inserido;
                $stmt->close();
                return true;
            }
        }
    }

    public function verificarLogin($username): ?Usuario
    {
        $sql = "SELECT id_usuario,usuario,senha,tipo_usuario FROM usuario WHERE usuario = ?";

        if (!$stmt = $this->conexao->prepare($sql)) {
            $erro_prepare = $this->conexao->error;
            $_SESSION['msg'] = "Falha na Preparação da Consulta! Erro - " . $erro_prepare;
            return null;
        } else {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            $idUsuario = null;
            $usuario = null;
            $senha = null;
            $tipo_usuario = null;

            $stmt->bind_result($idUsuario, $usuario, $senha, $tipo_usuario);

            if ($stmt->fetch()) {
                $usuario_valido = new Usuario($idUsuario, $usuario, $senha, $tipo_usuario);

                $stmt->close();
                return $usuario_valido;
            } else {
                $stmt->close();
                return null;
            }
        }
    }

    public function verificarUsuarioExiste($usuario)
    {
        $sql = "SELECT id_usuario FROM usuario WHERE usuario = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('s', $usuario->getUsuario());
            $stmt->execute();
            $stmt->store_result();
            $existe = $stmt->num_rows > 0;
            $stmt->close();
            return $existe;
        }
        return false;
    }

    public function alterarTipoUsuario($usuario, $tipo_usuario)
    {
        $sql = "UPDATE usuario SET tipo_usuario = ? WHERE id_usuario = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('ss', $tipo_usuario,$usuario->getIdUsuario());

            if ($stmt->execute()) {
                $linhas_afetadas = $stmt->affected_rows;
                $stmt->close();
                return $linhas_afetadas > 0;
            }
        }
        return false;
    }
}
