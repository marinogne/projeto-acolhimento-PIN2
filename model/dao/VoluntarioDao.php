<?php
require_once __DIR__ . '/../classes/Voluntario.php';
require_once __DIR__ . '/ConexaoBanco.php';

class VoluntarioDao
{
    private $conexao;

    public function __construct()
    {
        $conn = new ConexaoBanco();
        $this->conexao = $conn->getConexao();
    }

    public function inserirVoluntario(Voluntario $v)
    {
        $sql = "INSERT INTO voluntario (nome, email, telefone, disponibilidade, areas)
                VALUES (?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);
        if (!$stmt) {
            if (session_status() === PHP_SESSION_NONE) { @session_start(); }
            $_SESSION['msg'] = "Falha ao preparar INSERT de voluntário. Erro: " . $this->conexao->error;
            return false;
        }

        $nome            = $v->getNome();
        $email           = $v->getEmail();
        $telefone        = $v->getTelefone();
        $disponibilidade = $v->getDisponibilidade();
        $areasCsv        = $v->getAreas();

        if (!$stmt->bind_param('sssss', $nome, $email, $telefone, $disponibilidade, $areasCsv)) {
            
            $_SESSION['msg'] = "Falha ao vincular parâmetros. Erro: " . $stmt->error;
            $stmt->close();
            return false;
        }

        if (!$stmt->execute()) {
            
            $_SESSION['msg'] = "Falha ao inserir voluntário. Erro: " . $stmt->error;
            $stmt->close();
            return false;
        }

        $id = $this->conexao->insert_id;
        $stmt->close();
        return $id;
    }

    public function existePorEmail(string $email): bool
    {
        $sql = "SELECT 1 FROM voluntario WHERE email = ? LIMIT 1";
        $stmt = $this->conexao->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    
    public function existePorNomeTelefone(string $nome, string $telefone): bool
    {
        $sql = "
            SELECT 1
              FROM voluntario
             WHERE LOWER(TRIM(nome)) = LOWER(TRIM(?))
               AND REGEXP_REPLACE(telefone, '[^0-9]', '') = REGEXP_REPLACE(?, '[^0-9]', '')
             LIMIT 1
        ";

        $stmt = $this->conexao->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param('ss', $nome, $telefone);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();

        return $existe;
    }

    public function contarTotalVoluntarios()
    {
        $sql = 'SELECT COUNT(idVoluntario) AS total_voluntarios FROM voluntario;';

        if ($stmt = $this->conexao->prepare($sql)) {
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $total_voluntatios = $linha['total_voluntarios'];
            } else {
                $total_voluntatios = 0;
            }
            $stmt->close();
            return $total_voluntatios;
        }
    }
}
