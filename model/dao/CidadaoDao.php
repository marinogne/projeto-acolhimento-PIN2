<?php

require_once __DIR__ . '/../classes/Cidadao.php';
include_once('ConexaoBanco.php');

class CidadaoDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function inserirCidadao($cidadao)
    {
        $sql = "INSERT INTO cidadao (nome, cpf, data_nasci, telefone, endereco, id_login) VALUES (?, ?, ?,?,?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            $erro_prepare = $this->conexao->error;
            $_SESSION['msg'] = "Falha na Preparação da Consulta! Erro - " . $erro_prepare;
            return false;
        } else {
            $nome = $cidadao->getNome();
            $cpf = $cidadao->getCpf();
            $data_nasci = $cidadao->getDataNascimento();
            $telefone = $cidadao->getTelefone();
            $endereco = $cidadao->getEndereco();
            $id_login = $cidadao->getIdLogin();

            $stmt->bind_param('sisssi', $nome, $cpf, $data_nasci, $telefone, $endereco, $id_login);

            if ($stmt->execute() === false) {
                $msg = $stmt->error;
                $_SESSION['msg'] = "Falha ao inserir cidadão! Mensagem de erro: '$msg'";

                $stmt->close();
                return false;
            } else {
                $id_recuperado = $this->conexao->insert_id;
                $stmt->close();
                return $id_recuperado;
            }
        }
    }

    public function consultarCidadaoPorCPF($cidadao)
    {
        $sql = "SELECT * FROM cidadao WHERE cpf = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('s', $cidadao->getCpf());
            $stmt->execute();
            $stmt->store_result();


            if ($stmt->num_rows() > 0) {
                $id_cidadao = 0;
                $stmt->bind_result($id_cidadao, $nome, $cpf, $data_nasci, $telefone, $endereco, $id_login);
                if ($stmt->fetch()) {
                    $cidadao->setIdCidadao($id_cidadao);
                    $cidadao->setNome($nome);
                    $cidadao->setCpf($cpf);
                    $cidadao->setDataNascimento($data_nasci);
                    $cidadao->setTelefone($telefone);
                    $cidadao->setEndereco($endereco);
                    $cidadao->setIdLogin($id_login);
                    $stmt->close();
                    return $cidadao;

                } else {
                    $stmt->close();
                    return null;
                }
            }
        }
    }

    public function consultarIDCidadaoExiste($id_login)
    {
        $sql = "SELECT 1 FROM cidadao WHERE id_login = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_login);
            $stmt->execute();
            $stmt->store_result();

            $existe = ($stmt->num_rows > 0);
            $stmt->close();

            return $existe;
        }
    }
    public function consultarIDCidadao($id_login)
    {
        $sql = "SELECT id_cidadao FROM cidadao WHERE id_login = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_login);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $id_cidadao = null;
            if ($resultado->num_rows > 0) {
                $id_cidadao = $resultado->fetch_assoc();
            }
            $stmt->close();

            return $id_cidadao;
        }
    }

    public function consultarCidadaoCompleto($id_login)
    {
        $sql = "SELECT * FROM cidadao WHERE id_login = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_login);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if (($resultado->num_rows > 0)) {
                $cidadao = $resultado->fetch_assoc();
            }
            $stmt->close();
            return $cidadao;
        }
        return false;
    }
    public function consultarCidadaoPorID($id_cidadao)
    {
        $sql = "SELECT * FROM cidadao WHERE id_cidadao = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_cidadao);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if (($resultado->num_rows > 0)) {
                $cidadao = $resultado->fetch_assoc();
            }
            $stmt->close();
            return $cidadao;
        }
        return false;
    }
    public function atualizarCidaddao($cidadao)
    {
        $sql = "UPDATE cidadao SET 
        nome = ?,
        cpf = ?,
        data_nasci = ?,
        telefone = ?,
        endereco = ? 
         WHERE id_login = ? ";

        if ($stmt = $this->conexao->prepare($sql)) {

            $nome = $cidadao->getNome();
            $cpf = $cidadao->getCpf();
            $data_nasci = $cidadao->getDataNascimento();
            $telefone = $cidadao->getTelefone();
            $endereco = $cidadao->getEndereco();
            $id_login = $cidadao->getIdLogin();

            $stmt->bind_param(
                'sssssi',
                $nome,
                $cpf,
                $data_nasci,
                $telefone,
                $endereco,
                $id_login
            );

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }
        return false;
    }


    public function contarTotalCidadaos()
    {
        $sql = 'SELECT COUNT(id_cidadao) AS total_vitimas FROM cidadao';

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $total_vitimas = $linha['total_vitimas'];
            } else {
                $total_vitimas = 0;
            }
            $stmt->close();
            return $total_vitimas;
        }
    }
}
