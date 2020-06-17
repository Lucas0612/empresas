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

        $resultSet = $conexao->query('SELECT * FROM dados_empresas')->fetchAll();

        $args['valores'] = $resultSet;

    
        foreach($args['valores'] as $valores){

        
            $valores['total_notas'] = $valores['total_notas'] + $nota_fiscal;
            $valores['total_debito'] = $valores['total_debito'] + $debito;
            echo($valor['total_notas']);
            $notas = $valores['total_notas'];
            $debt = $valores['total_debito'];
            $conexao->query("UPDATE dados_empresas SET total_notas = '$notas',total_debito = '$debt' WHERE id_empresas LIKE $id");

        }



        $resultSet2 = $conexao->query('SELECT * FROM registro_empresas')->fetchAll();

        //Calculo do Ranking
        $args['pontuacao'] = $resultSet2;
        
        $pontuacao = CalculaIndice($args, $notas, $debt);

        $conexao->query("UPDATE registro_empresas SET pontuacao= '$pontuacao' WHERE id LIKE $id");

        // foreach($args['pontuacao'] as $pontuacao){

        //  $pontTotal =((0.02 * $notas) * $pontuacao['pontuacao'])+$pontuacao['pontuacao'];
        //  $pontTotal = floor($pontTotal);
        //  echo '<br>';
        // //  echo $pontTotal;
 
        //  $pontTotal2 = $pontTotal-((0.04 * $debt) * $pontTotal);
        //  $pontTotal2 = ceil($pontTotal2);
        //  echo '<br>';
        // //  echo $pontTotal2;
        //  $conexao->query("UPDATE registro_empresas SET pontuacao= '$pontTotal2' WHERE id LIKE $id");

 
        // }

        // if ($pontTotal2<0){
        //     $conexao->query("UPDATE registro_empresas SET pontuacao= '0' WHERE id LIKE $id");
        // }

        // if ($pontTotal2>100){
        //     $conexao->query("UPDATE registro_empresas SET pontuacao= '100' WHERE id LIKE $id");
        // }

        // Render index view
        return $container->get('renderer')->render($response, 'texto.phtml', $args);


    });

};

function CalculaIndice(array $args, int $notas, int $debitos): float {

    foreach($args['pontuacao'] as $pontuacao){

        $pontTotal =((0.02 * $notas) * $pontuacao['pontuacao'])+$pontuacao['pontuacao'];
        $pontTotal = floor($pontTotal);
        echo '<br>';
       //  echo $pontTotal;

        $pontTotal2 = $pontTotal-((0.04 * $debitos) * $pontTotal);
        $pontTotal2 = ceil($pontTotal2);
        echo '<br>';
       //  echo $pontTotal2;

       
       }

       if ($pontTotal2<0){
        $pontTotal2 = 0;
       }

       if ($pontTotal2>100){
            $pontTotal2 = 100;
       }
       return $pontTotal2;
};
