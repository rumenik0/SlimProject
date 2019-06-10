<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function($app, $container){

    $app->post('/cliente/{id}', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;
        
        $stmt = $connection->prepare('INSERT INTO  cliente(nome, telefone, cep, rua, numero, referencia) VALUES (:nome, :telefone, :cep, :rua, :numero, :referencia)');
        $stmt->execute(array(
                ':nome' => $body["nome"],
                ':telefone' => $body["telefone"],
                ':cep' => $body["cep"],
                ':rua' => $body["rua"],
                ':numero' => $body["numero"],
                ':referencia' => $body["referencia"])
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });

    // GET All individual entities from DB
    $app->get('/cliente/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Pessoas App: [GET] pessoas/");

        $connection = $this->db;
        $stmt = $connection->query("SELECT * FROM cliente;");

        $data = $stmt->fetchAll();

        return $response->withJson($data)
            ->withStatus(200);
    });

    $app->get('/JASON/{nome}/{idade}', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $data = array('var' => $args['nome'], 'var2' => $args['idade']);
        $container->get('logger')->info($data);
        #return $response->withRedirect('/new-url', 301);

        $newResponse = $response->withJson($data);

        return $newResponse->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
                          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                           ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $app->get('/', function(Request $request, Response $response, array $args) use ($container){
        return phpinfo();
    });
    
    /* $app->get('/', function ( Request $request, Response $response, array $args ) use ($container){
        return phpinfo{};
    });*/
        
    

};