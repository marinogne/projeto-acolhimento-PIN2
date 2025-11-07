<?php

require_once __DIR__ . '/../classes/Vitima.php';
require_once __DIR__ . '/ConexaoBanco.php'; 

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
        $sql = "INSERT INTO vitima (id_cidadao, etnia, possui_renda, recebe_auxilio, trabalha, escolaridade, possui_filhos, qtd_filhos_menores, nome_mae)
                VALUES (?,?,?,?,?,?,?,?,?)";

        if (!$stmt = $this->conexao->prepare($sql)) {
            error_log("DAO - Falha na Preparação da Consulta: " . $this->conexao->error);
            return false;
        } else {
            $id_cidadao          = $vitima->getIdCidadao();
            $etnia               = $vitima->getEtnia();
            $possui_renda        = $vitima->getPossuiRenda();
            $recebe_auxilio      = $vitima->getRecebeAuxilio();
            $trabalha            = $vitima->getTrabalha();
            $escolaridade        = $vitima->getEscolaridade();
            $possui_filhos       = $vitima->getPossuiFilhos();
            $qtd_filhos_menores  = $vitima->getQtdFilhosMenores();
            $nome_mae            = $vitima->getNomeMae();

            $stmt->bind_param('issssssis', $id_cidadao, $etnia, $possui_renda, $recebe_auxilio, $trabalha, $escolaridade, $possui_filhos, $qtd_filhos_menores, $nome_mae);

            if ($stmt->execute() === false) {
                error_log("DAO - Falha ao inserir vítima: " . $stmt->error);
                $stmt->close();
                return false;
            } else {
                $stmt->close();
                return true;
            }
        }
    }

    public function listarVitimasCompleto(): array
    {
        $sql = "
            SELECT
                c.id_cidadao               AS id_cidadao,
                c.nome                     AS nome,
                c.cpf                      AS cpf,
                c.data_nasci               AS data_nascimento,  -- <— aqui!
                c.telefone                 AS telefone,
                c.endereco                 AS endereco,
                c.id_login                 AS id_login,
                v.etnia                    AS etnia,
                v.possui_renda             AS possui_renda,
                v.recebe_auxilio           AS recebe_auxilio,
                v.trabalha                 AS trabalha,
                v.escolaridade             AS escolaridade,
                v.nome_mae                 AS nome_mae,
                v.possui_filhos            AS possui_filhos,
                v.qtd_filhos_menores       AS qtd_filhos_menores
            FROM cidadao c
            INNER JOIN vitima v ON v.id_cidadao = c.id_cidadao
            ORDER BY c.nome ASC
        ";

        $lista = [];
        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $lista[] = [
                    'id_cidadao'         => $row['id_cidadao'],
                    'nome'               => $row['nome'],
                    'cpf'                => $row['cpf'],
                    'data_nascimento'    => $row['data_nascimento'],
                    'telefone'           => $row['telefone'],
                    'endereco'           => $row['endereco'],
                    'id_login'           => $row['id_login'],
                    'etnia'              => $row['etnia'],
                    'possui_renda'       => $row['possui_renda'],
                    'recebe_auxilio'     => $row['recebe_auxilio'],
                    'trabalha'           => $row['trabalha'],
                    'escolaridade'       => $row['escolaridade'],
                    'nome_mae'           => $row['nome_mae'],
                    'possui_filhos'      => $row['possui_filhos'],
                    'qtd_filhos_menores' => $row['qtd_filhos_menores'],
                ];
            }
            $stmt->close();
        }
        return $lista;
    }

    public function consultarVitimaCompleto(int $id_cidadao): ?array
    {
        $sql = "
            SELECT
                c.id_cidadao               AS id_cidadao,
                c.nome                     AS nome,
                c.cpf                      AS cpf,
                c.data_nasci               AS data_nascimento,  -- <— aqui também!
                c.telefone                 AS telefone,
                c.endereco                 AS endereco,
                c.id_login                 AS id_login,
                v.etnia                    AS etnia,
                v.possui_renda             AS possui_renda,
                v.recebe_auxilio           AS recebe_auxilio,
                v.trabalha                 AS trabalha,
                v.escolaridade             AS escolaridade,
                v.nome_mae                 AS nome_mae,
                v.possui_filhos            AS possui_filhos,
                v.qtd_filhos_menores       AS qtd_filhos_menores
            FROM cidadao c
            INNER JOIN vitima v ON v.id_cidadao = c.id_cidadao
            WHERE c.id_cidadao = ?
            LIMIT 1
        ";

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->bind_param('i', $id_cidadao);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc() ?: null;
            $stmt->close();
            return $row;
        }
        return null;
    }
}
