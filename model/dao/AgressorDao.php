<?php

require_once __DIR__ . '/../classes/Agressor.php';
include_once('ConexaoBanco.php');

class AgressorDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function inserirAgressor($agressor)
    {
        $sql = "INSERT INTO agressor (nome, endereco) VALUES (?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            $erro_prepare = $this->conexao->error;
            $_SESSION['msg'] = "Falha na Preparação da Consulta! Erro - " . $erro_prepare;
            return false;
        } else {
            $nome = $agressor->getNome();
            $endereco = $agressor->getEndereco();

            $stmt->bind_param('ss', $nome,$endereco);

            if ($stmt->execute() === false) {
                $msg = $stmt->error;
                $_SESSION['msg'] = "Falha ao inserir agressor! Mensagem de erro: '$msg'";

                $stmt->close();
                return false;
            } else {
                $id_agressor_recuperado = $this->conexao->insert_id;
                $stmt->close();
                return $id_agressor_recuperado;
            }
        }
    }

    public function consultarAgressor($agressor){
        $sql = "SELECT * FROM agressor WHERE nome = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('s',$agressor->getNome());
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() > 0){
                $id_agressor = 0;
                $stmt->bind_result($id_agressor,$nome,$endereco);
                if($stmt->fetch()){
                    $agressor->setIdCidadao($id_agressor);
                    $agressor->setNome($nome);
                    $agressor->setEndereco($endereco);
                    $stmt->close();
                    return $agressor;

                }else{
                    $stmt->close();
                    return null;
                }  
            }
    }

    public function consultarAgressorCompleto($id_agressor){
        $sql = "SELECT * FROM agressor WHERE id_agressor = ?";
        if($stmt = $this->conexao->prepare($sql)){
            $stmt->bind_param('i',$id_agressor);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $agressor_completo = [];

            if($resultado->num_rows > 0){
                $agressor_completo[] = $resultado->fetch_assoc();
            
            }
            $stmt->close();
            return $agressor_completo;
        }
        return false;
    }

}
