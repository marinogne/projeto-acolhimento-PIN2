<?php

class Usuario{

    protected $idUsuario;
    protected $senha;

    public function __construct($idUsuario, $senha){
        $this-> setIdUsuario($idUsuario);
        $this-> setSenha($senha);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;

        return $this;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;

        return $this;
    }
}