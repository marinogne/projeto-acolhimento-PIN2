<?php

class Ocorrencia
{
    private $idVitima;
    private $idAgressor;
    private $relacaoComAgressor; 
    private $tempoRelacao;
    private array $tiposViolenciaSofrida = []; 
    private $primeiraAgressao; 
    private $detalheViolenciaSofrida;
    private $testemunhas; 
    private $boletimOcorrencia;
    private $medidaProtetiva; 
    private $agressorAntecedentes; 

    public function __construct(
        $idVitima,
        $idAgressor,
        $relacaoComAgressor, 
        $tempoRelacao,
        $tiposViolenciaSofrida = [],
        $primeiraAgressao,
        $detalheViolenciaSofrida,
        $testemunhas,
        $boletimOcorrencia,
        $medidaProtetiva,
        $agressorAntecedentes
    ) {
        $this->idVitima = $idVitima;
        $this->idAgressor = $idAgressor;
        $this->relacaoComAgressor = $relacaoComAgressor;
        $this->tempoRelacao = $tempoRelacao;
        $this->tiposViolenciaSofrida = $tiposViolenciaSofrida;
        $this->primeiraAgressao = $primeiraAgressao;
        $this->detalheViolenciaSofrida = $detalheViolenciaSofrida;
        $this->testemunhas = $testemunhas;
        $this->boletimOcorrencia = $boletimOcorrencia;
        $this->medidaProtetiva = $medidaProtetiva;
        $this->agressorAntecedentes = $agressorAntecedentes;
        
    }

    public function getIdVitima()
    {
        return $this->idVitima;
    }
    public function getIdAgressor()
    {
        return $this->idAgressor;
    }
    public function getRelacaoComAgressor()
    {
        return $this->relacaoComAgressor;
    }
    public function getTempoRelacao()
    {
        return $this->tempoRelacao;
    }
    public function getTiposViolenciaSofrida()
    {
        return $this->tiposViolenciaSofrida;
    }
    public function getPrimeiraAgressao()
    {
        return $this->primeiraAgressao;
    }
    public function getDetalheViolenciaSofrida()
    {
        return $this->detalheViolenciaSofrida;
    }
    public function getTestemunhas()
    {
        return $this->testemunhas;
    }
    public function getBoletimOcorrencia()
    {
        return $this->boletimOcorrencia;
    }
    public function getMedidaProtetiva()
    {
        return $this->medidaProtetiva;
    }
    public function getAgressorAntecedentes()
    {
        return $this->agressorAntecedentes;
    }



    public function setIdVitima($idVitima)
    {
        $this->idVitima = $idVitima;
    }
    public function setIdAgressor($idAgressor){
        $this->idAgressor = $idAgressor;
    }
    public function setRelacaoComAgressor($relacaoComAgressor)
    {
        $this->relacaoComAgressor = $relacaoComAgressor;
    }
    public function setTempoRelacao($tempoRelacao)
    {
        $this->tempoRelacao = $tempoRelacao;
    }
    public function setTiposViolenciaSofrida(array $tiposViolenciaSofrida)
    {
        $this->tiposViolenciaSofrida = $tiposViolenciaSofrida;
    }
    public function setPrimeiraAgressao($primeiraAgressao)
    {
        $this->primeiraAgressao = $primeiraAgressao;
    }
    public function setDetalheViolenciaSofrida($detalheViolenciaSofrida)
    {
        $this->detalheViolenciaSofrida = $detalheViolenciaSofrida;
    }
    public function setTestemunhas($testemunhas)
    {
        $this->testemunhas = $testemunhas;
    }
    public function setBoletimOcorrencia($boletimOcorrencia)
    {
        $this->boletimOcorrencia = $boletimOcorrencia;
    }
    public function setMedidaProtetiva($medidaProtetiva)
    {
        $this->medidaProtetiva = $medidaProtetiva;
    }
    public function setAgressorAntecedentes($agressorAntecedentes)
    {
        $this->agressorAntecedentes = $agressorAntecedentes;
    }


}