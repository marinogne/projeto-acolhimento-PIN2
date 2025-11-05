<?php


require_once('../model/Classes/Vitima.php');

session_start();


if (!isset($_SESSION['usuario_logado'])) {
    header('location: login.php');
    exit;
}


$tipo_usuario = $_SESSION['tipo_usuario'] ?? 'Não Autorizado'; 


if ($tipo_usuario !== 'Administrador') {

    header('location: home.php'); 
    exit;
}


$listaVitimas = $_SESSION['lista_vitimas'] ?? [];

unset($_SESSION['lista_vitimas']);

$mensagem = '';
$tipo_mensagem = ''; 

if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
     $mensagem = $_SESSION['msg'];
    if (isset($_SESSION['tipo'])) {
         $tipo_mensagem = $_SESSION['tipo'];
        unset($_SESSION['tipo']); 
 }
 unset($_SESSION['msg']);
}

$temResultados = !empty($listaVitimas);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="../styles/style.css">
 <link rel="stylesheet" href="../styles/consultaVitima.css">
 <link rel="icon" href="../img/lupa.png">
 <title>Consulta Vitimas</title>

</head>

<body>
    <main> <div class="content">
            <?php if (!empty($mensagem)): ?>
                <div class="msg <?php echo $tipo_mensagem; ?>">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php
        switch ($tipo_usuario):
            
            case "Administrador": ?>

                <nav class="sidebar">
                    <ul class="navbar-lateral">
                        <li><a href="home.php">Home</a></li>
                        <br>

                        <li class="titulo-nav">Cadastrar</li>                       
                        <li><a href="cadastroVitima.php">Cadastro de Vitima</a></li>           
                        

                        <br><br><br>

                        <li class="titulo-nav">Consultar</li>
                        <li><a href="../controller/ConsultarVitimasController.php">Consultar Vitimas</a></li>
                        <br><br><br>

                        <li><a href="Logout.php">Sair</a></li>


                    </ul>
                </nav>

                <?php break;
        endswitch;
        ?>  

        <hr>
        
        <div class="container tabela">
            <h1>Resultados da Consulta</h1>

        <table>
            <thead>
                <tr>
                    <th>ID Cidadao</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data Nascimento</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>ID Login</th>
                    <th>Etinia</th>
                    <th>Possui Renda</th>
                    <th>Recebe Auxilio</th>
                    <th>Trebalha</th>
                    <th>Escolaridade</th>
                    <th>Nome Mãe</th>
                    <th>Possui Filhos</th>
                    <th>Qtd Filhos Menores</th>
                </tr>
            </thead>
                        
            <tbody>

                <?php if ($temResultados): ?>
                    <?php foreach ($listaVitimas as $vitima): ?>
                        <tr>
                            <td><?php echo $vitima['id_cidadao']; ?></td>
                            <td><?php echo $vitima['nome']; ?></td>
                            <td><?php echo $vitima['cpf']; ?></td>
                            <td><?php echo $vitima['data_nascimento']; ?></td>
                            <td><?php echo $vitima['telefone']; ?></td>
                            <td><?php echo $vitima['endereco']; ?></td>
                            <td><?php echo $vitima['id_login']; ?></td>
                            <td><?php echo $vitima['etnia']; ?></td>
                            <td><?php echo $vitima['possuiRenda'] ?? $vitima['possui_renda']; ?></td> <td><?php echo $vitima['recebeAuxilio'] ?? $vitima['recebe_auxilio']; ?></td>
                            <td><?php echo $vitima['trabalha']; ?></td>
                            <td><?php echo $vitima['escolaridade']; ?></td> 
                            <td><?php echo $vitima['nomeMae'] ?? $vitima['nome_mae']; ?></td>
                            <td><?php echo $vitima['possuiFilhos'] ?? $vitima['possui_filhos']; ?></td>
                            <td><?php echo $vitima['qtdFilhosMenores'] ?? $vitima['qtd_filhos_menores']; ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="15" style="text-align: center;">
                            Nenhuma vítima encontrada.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
            
    </main>

</body>

</html>
