<?php

require_once __DIR__ . '/../classes/Vitima.php';
include_once('ConexaoBanco.php');

class VitimaDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function inserirVitima($vitima)
    {
        $sql = "INSERT INTO vitima (id_cidadao,etnia, possui_renda, recebe_auxilio, trabalha, escolaridade, possui_filhos, qtd_filhos_menores, nome_mae) VALUES (?,?,?,?,?,?,?,?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            error_log("DAO - Falha na Preparação da Consulta: " . $this->conexao->error);
            return false;
        } else {
            $id_cidadao = $vitima->getIdCidadao();
            $etnia = $vitima->getEtnia();
            $possui_renda = $vitima->getPossuiRenda();
            $recebe_auxilio = $vitima->getRecebeAuxilio();
            $trabalha = $vitima->getTrabalha();
            $escolaridade = $vitima->getEscolaridade();
            $possui_filhos = $vitima->getPossuiFilhos();
            $qtd_filhos_menores = $vitima->getQtdFilhosMenores();
            $nome_mae = $vitima->getNomeMae();

            $stmt->bind_param('issssssis', $id_cidadao, $etnia, $possui_renda, $recebe_auxilio, $trabalha, $escolaridade, $possui_filhos, $qtd_filhos_menores, $nome_mae);

            if ($stmt->execute() === false) {
                $msg = $stmt->error;
                error_log("DAO - Falha ao inserir vítima: " . $msg);

                $stmt->close();
                return false;
            } else {
                $stmt->close();
                return true;
            }
        }
    }

    public function consultarVitimaCompleto($id_cidadao)
    {
        $sql = "SELECT * FROM vitima WHERE id_cidadao = ?";
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_cidadao);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $vitima = null;

            if (($resultado->num_rows > 0)) {
                $vitima = $resultado->fetch_assoc();
            }
            $stmt->close();
            return $vitima;
        }
        return false;
    }

    public function atualizarVitima($vitima){
        $sql = "UPDATE vitima SET 
            etnia = ?,
            possui_renda = ?,
            recebe_auxilio = ?,
            trabalha = ?,
            escolaridade = ?,
            possui_filhos = ?,
            qtd_filhos_menores = ?,
            nome_mae = ?
            WHERE id_cidadao = ?";
        
        if ($stmt = $this->conexao->prepare($sql)) {

            $etnia              = $vitima->getEtnia();
            $possui_renda       = $vitima->getPossuiRenda();
            $recebe_auxilio     = $vitima->getRecebeAuxilio();
            $trabalha           = $vitima->getTrabalha();
            $escolaridade       = $vitima->getEscolaridade();
            $possui_filhos      = $vitima->getPossuiFilhos();
            $qtd_filhos_menores = $vitima->getQtdFilhosMenores();
            $nome_mae           = $vitima->getNomeMae();
            $id_cidadao         = $vitima->getIdCidadao();

            $stmt->bind_param('ssssssisi', 
                $etnia, 
                $possui_renda, 
                $recebe_auxilio, 
                $trabalha, 
                $escolaridade, 
                $possui_filhos, 
                $qtd_filhos_menores, 
                $nome_mae,
                $id_cidadao
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

}
