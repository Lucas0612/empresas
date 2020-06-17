<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->post('/alterar/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');

        $adicionar = $_POST;

        $nome = $adicionar['nome_empresa'];

        $pontuacao = $adicionar['pontuacao'];

     
        $conexao->query("INSERT INTO registro_empresas (nome_empresa, pontuacao) VALUES ('$nome','$pontuacao') ");
     
        


        header("Refresh: 0; url=routesInicio.php");

        return $container->get('renderer')->render($response, 'inicio.phtml', $args);


    });


};
