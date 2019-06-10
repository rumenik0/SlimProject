<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });


    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $clientCRUD = require __DIR__ . '/../src/model/Cliente.php'; // Pessoa Entity
    $clientCRUD($app, $container);

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($req, $res) {
        $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
        return $handler($req, $res);
    });

    /*$app->get('/rumenik', function (Request $request, Response $response, array $args) use ($container) {
          // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);

        $newResponse = $response->withJson($args);

        //return $newResponse->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
        //                  ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        //                   ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    #REDIRECT
    $app->get('/teste', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        
        // Render index view
        $data = array('name' => 'Bob', 'age' => 40);
        
        return $response->withRedirect('/new-url', 301);

        $newResponse = $response->withJson($args);

        return $newResponse->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
                          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                           ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    #JSON
    $app->get('/JASON/{nome}/{idade}', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $data = array('var' => $args['nome'], 'var2' => $args['idade']);
        $container->get('logger')->info($data);
        #return $response->withRedirect('/new-url', 301);

        $newResponse = $response->withJson($data);

        return $newResponse->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
                          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                           ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });*/


};
