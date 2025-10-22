<?php

class Voluntario {
    protected $idVoluntario;
    protected $nome;
    protected $email;
    protected $telefone;
    protected $disponibilidade;
    protected $areas;

    public function __construct($idVoluntario, $nome, $email, $telefone, $disponibilidade, $areasCsv){
        $this->setIdVoluntario($idVoluntario);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setTelefone($telefone);
        $this->setDisponibilidade($disponibilidade);
        $this->setAreas($areasCsv);
    }

    public function getIdVoluntario(){ 
        return $this->idVoluntario; }
    public function setIdVoluntario($idVoluntario){ 
        $this->idVoluntario = $idVoluntario; return $this; }

    public function getNome(){ return $this->nome; }
    public function setNome($nome){ $this->nome = $nome; return $this; }

    public function getEmail(){ return $this->email; }
    public function setEmail($email){ $this->email = $email; return $this; }

    public function getTelefone(){ return $this->telefone; }
    public function setTelefone($telefone){ $this->telefone = $telefone; return $this; }

    public function getDisponibilidade(){ return $this->disponibilidade; }
    public function setDisponibilidade($disponibilidade){ $this->disponibilidade = $disponibilidade; return $this; }

    public function getAreas(){ return $this->areas; }                 
    public function setAreas($areasCsv){ $this->areas = $areasCsv; return $this; }
}
