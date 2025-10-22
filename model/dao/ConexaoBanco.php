<?php

class ConexaoBanco{

    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'projeto_acolhimento';
    private $charset = 'utf8mb4';
    private $conexao;

    public function __construct() {
        $this->conexao = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if($this->conexao->connect_error){
            die("Conexao falhou" . $this->conexao->connect_error);
        }
        $this->conexao->set_charset($this->charset);

        if ($this->conexao->connect_error) {
            $erro = "erro ao conectar com o Database" . $this->conexao->connect_error;

            die($erro);
        }
    }

    public function getConexao():mysqli{
        return $this->conexao;
    }
}