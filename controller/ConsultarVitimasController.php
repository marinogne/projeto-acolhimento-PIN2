<?php
session_start();

require_once __DIR__ . '/../model/dao/VitimaDao.php';

try {
    $dao = new VitimaDao();
    $lista = $dao->listarVitimasCompleto();


    $normalizada = [];
    foreach ($lista as $v) {
        $normalizada[] = array_merge($v, [
            'possuiRenda'       => $v['possui_renda']       ?? null,
            'recebeAuxilio'     => $v['recebe_auxilio']     ?? null,
            'nomeMae'           => $v['nome_mae']           ?? null,
            'possuiFilhos'      => $v['possui_filhos']      ?? null,
            'qtdFilhosMenores'  => $v['qtd_filhos_menores'] ?? null,
        ]);
    }

    $_SESSION['lista_vitimas'] = $normalizada;
    $_SESSION['msg']  = count($normalizada) . ' registro(s) encontrado(s).';
    $_SESSION['tipo'] = 'ok';
} catch (Throwable $e) {
    $_SESSION['lista_vitimas'] = [];
    $_SESSION['msg']  = 'Erro ao consultar vítimas: ' . $e->getMessage();
    $_SESSION['tipo'] = 'erro';
}


header('Location: ../view/consultarVitima.php');
exit;

