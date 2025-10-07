<?php

class Voluntario {
    protected $idVoluntario;
    protected $servicoPrestado;

    public function __construct($idVoluntario, $servicoPrestado){
        $this-> setIdVoluntario($idVoluntario);
        $this-> setServicoPrestado($servicoPrestado);
    }

    public function getIdVoluntario(){
        return $this->idVoluntario;
    }

    public function setIdVoluntario($idVoluntario){
        $this-> idVoluntario = $idVoluntario;

        return $this;
    }

    public function getServicoPrestado(){
        return $this->servicoPrestado;

    }

    public function setServicoPrestado($servicoPrestado){
        $this-> servicoPrestado = $servicoPrestado;

        return $this;
    }
}