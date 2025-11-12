<?php

require_once __DIR__ . '/../classes/Funcionario.php';
include_once('ConexaoBanco.php');

class FuncionarioDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function inserirFuncionario($funcionario)
    {
        $sql = "INSERT INTO funcionario (nome, cpf, matricula, cargo, id_usuario) VALUES (?,?,?,?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            $erro_prepare = $this->conexao->error;
            $_SESSION['msg'] = "Falha na Preparação da Consulta! Erro - " . $erro_prepare;
            return false;
        } else {

            $nome = $funcionario->getNome();
            $cpf = $funcionario->getCpf();
            $matricula = $funcionario->getMatricula();
            $cargo = $funcionario->getCargo();
            $id_login = $funcionario->getIdLogin();

            $stmt->bind_param('ssssi', $nome, $cpf, $matricula, $cargo, $id_login);

            if ($stmt->execute() === false) {
                $msg = $stmt->error;
                $_SESSION['msg'] = "Falha ao inserir agressor! Mensagem de erro: '$msg'";

                $stmt->close();
                return false;
            } else {
                $id_funcionario = $this->conexao->insert_id;
                $stmt->close();
                return $id_funcionario;
            }
        }
    }

    public function verificarDuplicidade($matricula, $cpf)
    {
        $sql = "SELECT idFuncionario FROM funcionario WHERE matricula = ? OR cpf = ?";

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('ss', $matricula, $cpf);
            $stmt->execute();
            $stmt->store_result();

            $existe = $stmt->num_rows > 0;

            $stmt->close();
            return $existe;
        }
        return false;
    }

    public function contarTotalFuncionarios()
    {
        $sql = 'SELECT COUNT(idFuncionario) AS total_funcionarios FROM funcionario';

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $total_funcionarios = $linha['total_funcionarios'];
            } else {
                $total_funcionarios = 0;
            }
            $stmt->close();
            return $total_funcionarios;
        }
    }
}
