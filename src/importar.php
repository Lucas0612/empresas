<?php

use phpDocumentor\Reflection\Types\Integer;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/importar/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');

        $resultSet = $conexao->query('SELECT * FROM registro_empresas')->fetchAll();

        $args['empresas'] = $resultSet;
        

        // Render index view
        return $container->get('renderer')->render($response, 'texto.phtml', $args);


    });

    $app->post('/importar/', function (Request $request, Response $response, array $args) use ($container) {        
        // Sample log message

        $empresaSelecionada = $_POST['campoemp'];        

        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');

        $arquivo_tmp = $_FILES['arquivo'] ['tmp_name'];
        
        $dados = file($arquivo_tmp);

        foreach($dados as $linha) {
            $linha = trim($linha);
            $valor = explode(';',$linha);                    
        }

        $id = $valor[0];
        $nota_fiscal = $valor[1];
        $debito = $valor[2];

        $idEmpresa = $conexao->query("SELECT * FROM registro_empresas WHERE nome_empresa like  '$empresaSelecionada' ")->fetchAll();        
         
        if ($idEmpresa[0]['id'] != $id) {
           return "Empresa não localizada";
        }

        $resultSet = $conexao->query("SELECT * FROM dados_empresas where id_empresas = '$id' ")->fetchAll();
        
        $args['valores'] = $resultSet;

        $resultSet[0]['total_notas'] = $resultSet[0]['total_notas'] + $nota_fiscal;
        $resultSet[0]['total_debito'] = $resultSet[0]['total_debito'] + $debito;
        
        $notas = $resultSet[0]['total_notas'];
        $debt = $resultSet[0]['total_debito'];
        $conexao->query("UPDATE dados_empresas SET total_notas = '$notas',total_debito = '$debt' WHERE id_empresas LIKE $id"); 



        $resultSet2 = $conexao->query('SELECT * FROM registro_empresas')->fetchAll();

        //Calculo do Ranking
        $args['pontuacao'] = $resultSet2;
        
        $pontuacao = CalculaIndice($args, $notas, $debt);

        $conexao->query("UPDATE registro_empresas SET pontuacao= '$pontuacao' WHERE id LIKE $id");

        header("Refresh: 0; url=routesInicio.php");

 
        return $container->get('renderer')->render($response, 'texto.phtml', $args);


    });

};

function CalculaIndice(array $args, int $notas, int $debitos): float {

    foreach($args['pontuacao'] as $pontuacao){

        $pontTotal =((0.02 * $notas) * $pontuacao['pontuacao'])+$pontuacao['pontuacao'];
        $pontTotal = floor($pontTotal);

        $pontTotal2 = $pontTotal-((0.04 * $debitos) * $pontTotal);
        $pontTotal2 = ceil($pontTotal2);
       
       }

       if ($pontTotal2<0){
        $pontTotal2 = 0;
       }

       if ($pontTotal2>100){
            $pontTotal2 = 100;
       }
       return $pontTotal2;
};
