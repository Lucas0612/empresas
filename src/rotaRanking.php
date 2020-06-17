<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/ranking/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/ranking/' route");

        $conexao = $container->get('pdo');

        $resultSet = $conexao->query('SELECT * FROM registro_empresas ORDER BY pontuacao DESC')->fetchAll();

        $args['empresas'] = $resultSet;
        // asort($args['empresas']['pontuacao']);
        

        // Render index view
        return $container->get('renderer')->render($response, 'ranking.phtml', $args);


    });

};