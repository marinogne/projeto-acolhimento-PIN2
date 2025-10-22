<?php
include_once __DIR__ . '/Cidadao.php';
class Vitima extends Cidadao
{
    protected $etnia;
    protected $possuiRenda;
    protected $recebeAuxilio;
    protected $trabalha;
    protected $escolaridade;
    protected $nomeMae;
    protected $possuiFilhos;
    protected $qtdFilhosMenores;
    public function __construct(
        $idCidadao,
        $nome,
        $cpf,
        $dataNascimento,
        $telefone,
        $endereco,
        $id_login,
        $etnia,
        $possuiRenda,
        $recebeAuxilio,
        $trabalha,
        $escolaridade,
        $nomeMae,
        $possuiFilhos,
        $qtdFilhosMenores,
    ) {
        // Chamada ao construtor da classe mãe (Cidadao)
        parent::__construct($idCidadao,$nome, $cpf, $dataNascimento, $telefone, $endereco, $id_login);

        // Atributos específicos
        $this->etnia = $etnia;
        $this->possuiRenda = $possuiRenda;
        $this->recebeAuxilio = $recebeAuxilio;
        $this->trabalha = $trabalha;
        $this->escolaridade = $escolaridade;
        $this->nomeMae = $nomeMae;
        $this->possuiFilhos = $possuiFilhos;
        $this->qtdFilhosMenores = $qtdFilhosMenores;
        
    }

    // --- GETTERS ---
    public function getEtnia()
    {
        return $this->etnia;
    }
    public function getPossuiRenda()
    {
        return $this->possuiRenda;
    }
    public function getRecebeAuxilio()
    {
        return $this->recebeAuxilio;
    }
    public function getTrabalha()
    {
        return $this->trabalha;
    }
    public function getEscolaridade()
    {
        return $this->escolaridade;
    }

    public function getPossuiFilhos()
    {
        return $this->possuiFilhos;
    }
    public function getQtdFilhosMenores()
    {
        return $this->qtdFilhosMenores;
    }

    public function getNomeMae()
    {
        return $this->nomeMae;
    }


    // --- SETTERS ---
    public function setEtnia($etnia)
    {
        $this->etnia = $etnia;
    }
    public function setPossuiRenda($possuiRenda)
    {
        $this->possuiRenda = $possuiRenda;
    }
    public function setRecebeAuxilio($recebeAuxilio)
    {
        $this->recebeAuxilio = $recebeAuxilio;
    }
    public function setTrabalha($trabalha)
    {
        $this->trabalha = $trabalha;
    }
    public function setEscolaridade($escolaridade)
    {
        $this->escolaridade = $escolaridade;
    }

    public function setPossuiFilhos($possuiFilhos)
    {
        $this->possuiFilhos = $possuiFilhos;
    }
    public function setQtdFilhosMenores(int $qtdFilhosMenores)
    {
        $this->qtdFilhosMenores = $qtdFilhosMenores;
    }

    public function setNomeMae($nomeMae)
    {
        $this->nomeMae = $nomeMae;
    }
}