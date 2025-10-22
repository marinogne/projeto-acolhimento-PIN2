<?php

class Usuario{

    private $idUsuario, $usuario, $senha, $tipo_usuario;

    public function __construct($idUsuario, $usuario, $senha, $tipo_usuario){
        $this-> setIdUsuario($idUsuario);
        $this->setUsuario($usuario);
        $this-> setSenha($senha);
        $this->setTipoUsuario($tipo_usuario);
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;

        return $this;
    }
    public function getUsuario(){
        return $this->usuario;
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;

        return $this;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;

        return $this;
    }
    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }

    public function setTipoUsuario($tipo_usuario){
        $this->tipo_usuario = $tipo_usuario;

        return $this;
    }
}