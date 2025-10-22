<?php

class Cidadao {

    protected $idCidadao;
    protected $nome;
    protected $cpf;
    protected $dataNascimento;
    protected $telefone;
    protected $endereco;
    protected $id_login;

    public function __construct($idCidadao, $nome, $cpf, $dataNascimento, $telefone, $endereco, $id_login) {
        $this->idCidadao = $idCidadao;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->id_login = $id_login;
    }

    // --- GETTERS ---
    public function getIdCidadao(): ?int { return $this->idCidadao; }
    public function getNome(): string { return $this->nome; }
    public function getCpf(): string { return $this->cpf; }
    public function getDataNascimento(): ?string { 
        return $this->dataNascimento; }
    public function getTelefone(): ?string { return $this->telefone; }
    public function getEndereco(): ?string { return $this->endereco; }

    public function getIdLogin(): ?int { return $this->id_login;}
    

    // --- SETTERS ---
    public function setIdCidadao(int $idCidadao): void {
         $this->idCidadao = $idCidadao; }
    public function setNome(string $nome): void {
         $this->nome = $nome; }
    public function setCpf(string $cpf): void {
         $this->cpf = $cpf; }
    public function setDataNascimento(string $dataNascimento): void {
         $this->dataNascimento = $dataNascimento; }
    public function setTelefone(string $telefone): void { 
        $this->telefone = $telefone; }
    public function setEndereco(string $endereco): void {
         $this->endereco = $endereco; }
     public function setIdLogin(int $id_login): void{
          $this->id_login = $id_login;
     }
    
}