<?php

class Funcionario {

    protected $idFuncionario;
    protected $matricula;
    protected $nome;
    protected $cargo;
    protected $cpf;
    protected $id_login;

    
    public function __construct($idFuncionario, $matricula, $nome, $cargo, $cpf, $id_login) {
        $this->idFuncionario = $idFuncionario;
        $this->matricula = $matricula;
        $this->nome = $nome;
        $this->cargo = $cargo;
        $this->cpf = $cpf;
        $this->id_login = $id_login;
    }

    public function getIdFuncionario(){
        return $this->idFuncionario;
    }

    public function getMatricula(){
        return $this->matricula;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getCargo(){
        return $this->cargo;
    }

    public function getCpf(){
        return $this->cpf;
    }
    public function getIdLogin(){
        return $this->id_login;
    }

    public function setIdFuncionario($idFuncionario){
        $this->idFuncionario = $idFuncionario;
    }

    public function setMatricula($matricula){
        $this->matricula = $matricula;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setCargo($cargo){
        $this->cargo = $cargo;
    }

    public function setCpf($cpf){
        $this->cpf = $cpf;
    }
    public function setIdLogin($id_login){
        $this->id_login = $id_login;
    }
    
}