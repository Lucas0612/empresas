<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        $conexao = $container->get('pdo');

        $resultSet = $conexao->query('SELECT * FROM registro_empresas')->fetchAll();

        $args['empresas'] = $resultSet;
        

        // Render index view
        return $container->get('renderer')->render($response, 'inicio.phtml', $args);


    });

};
