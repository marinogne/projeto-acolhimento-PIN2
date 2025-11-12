<?php

require_once __DIR__ . '/../classes/Ocorrencia.php';
include_once('ConexaoBanco.php');

class OcorrenciaDao
{
    private $conn;
    private $conexao;

    public function __construct()
    {
        $this->conn = new ConexaoBanco();
        $this->conexao = $this->conn->getConexao();
    }

    public function inserirOcorrencia($ocorrencia)
    {
        $sql = "INSERT INTO ocorrencia(id_vitima, id_agressor, relacao_com_agressor, tempo_relacao, tipo_violencia, primeira_agressao, detalhe_violencia, testemunhas, boletim_ocorrencia, medida_protetiva, agressor_antecedentes) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            error_log("DAO - Falha na Preparação da Consulta: " . $this->conexao->error);
            return false;
        } else {
            $id_vitima = $ocorrencia->getIdVitima();
            $id_agressor = $ocorrencia->getIdAgressor();
            $relacao_com_agressor = $ocorrencia->getRelacaoComAgressor();
            $tempo_relacao = $ocorrencia->getTempoRelacao();
            $tipos_violencia_string = implode(',', $ocorrencia->getTiposViolenciaSofrida());
            $primeira_agressao = $ocorrencia->getPrimeiraAgressao();
            $detalhe_violencia = $ocorrencia->getDetalheViolenciaSofrida();
            $testemunhas = $ocorrencia->getTestemunhas();
            $boletim_ocorrencia = $ocorrencia->getBoletimOcorrencia();
            $medida_protetiva = $ocorrencia->getMedidaProtetiva();
            $agressor_antecedentes = $ocorrencia->getAgressorAntecedentes();

            $stmt->bind_param(
                'iisssssssss',
                $id_vitima,
                $id_agressor,
                $relacao_com_agressor,
                $tempo_relacao,
                $tipos_violencia_string,
                $primeira_agressao,
                $detalhe_violencia,
                $testemunhas,
                $boletim_ocorrencia,
                $medida_protetiva,
                $agressor_antecedentes
            );

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

    public function consultarIdsOcorrenciasUsuario($id_vitima){
        $sql = "SELECT id_ocorrencia FROM ocorrencia WHERE id_vitima = ?";
        if($stmt = $this->conexao->prepare($sql)){
            $stmt->bind_param('i',$id_vitima);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $id_ocorrencia = [];

            if($resultado->num_rows > 0){
                while($linha = $resultado->fetch_assoc()){
                    $id_ocorrencia[] = $linha['id_ocorrencia'];
                }
            }
            $stmt->close();
            return $id_ocorrencia;
        }
        return false;
    }

    public function consultarOcorrenciaCompleta($id_vitima){
        $sql = "SELECT * FROM ocorrencia WHERE id_vitima = ?";
        if($stmt = $this->conexao->prepare($sql)){
            $stmt->bind_param('i',$id_vitima);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $ocorrencia_completa = [];

            if($resultado->num_rows > 0){
                while($linha = $resultado->fetch_assoc()){
                    $ocorrencia_completa[] = $linha;
                }
            }
            $stmt->close();
            return $ocorrencia_completa;
        }
        return false;
    }

    public function contarTotalOcorrencias()
    {
        $sql = 'SELECT COUNT(id_ocorrencia) AS total_ocorrencias FROM ocorrencia';

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $total_ocorrencias = $linha['total_ocorrencias'];
            } else {
                $total_ocorrencias = 0;
            }
            $stmt->close();
            return $total_ocorrencias;
        }
    }

    public function contarTiposViolencia() {
    // Esta query agrupa e conta o total de ocorrências para cada tipo registrado
    // Assumindo que 'tipo_violencia' é a coluna que você usa.
    $sql = "SELECT tipo_violencia, COUNT(*) AS total FROM ocorrencia GROUP BY tipo_violencia ORDER BY total DESC";
    
    if ($stmt = $this->conexao->prepare($sql)) {
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $dados = [];
        while ($linha = $resultado->fetch_assoc()) {
            // Adiciona cada linha (Tipo e Total) ao array
            $dados[] = $linha; 
        }
        
        $stmt->close();
        return $dados; // Retorna um array de arrays (ex: [{'tipo_violencia':'Física', 'total': 10}, ...])
    }
    
    return []; // Retorna um array vazio em caso de falha
}
}
