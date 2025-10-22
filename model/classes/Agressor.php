<?php
class Agressor
{
    protected $idAgressor,$nome, $endereco;
    public function __construct($idAgressor,$nome, $endereco)
    {
        $this->idAgressor = $idAgressor;
        $this->nome = $nome;
        $this->endereco = $endereco;
    }

    public function getIdAgressor() {
        return $this->idAgressor;
    }
    public function setIdAgressor($idAgressor){
        $this->idAgressor = $idAgressor;
    }
    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getEndereco() {
        return $this->endereco;
    }
    public function setEndereco($endereco){
        $this->endereco = $endereco;
    }
}