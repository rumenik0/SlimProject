<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function($app, $container){

    $app->post('/entregador/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $nome = $body['nome'];
        $telefone = $body['telefone'];
        
        $stmt = $connection->prepare('INSERT INTO entregador(nome, telefone) VALUES (:nome, :telefone)');
        $stmt->execute(array(
                ':nome' => $nome,
                ':telefone' => $telefone
				)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });

    // GET All individual entities from DB
    $app->get('/entregador/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Pessoas App: [GET] pessoas/");

        $connection = $this->db;
        $stmt = $connection->query("SELECT * FROM entregador;");

        $data = $stmt->fetchAll();

        return $response->withJson($data)
            ->withStatus(200);
    });
	
	$app->post('/entregador/update/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $nome = $body['nome'];
        $telefone = $body['telefone'];
		$id = $body['id'];
        $sql = "update entregador set nome = :nome, telefone = :telefone where id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array(
                ':nome' => $nome,
                ':telefone' => $telefone,
				':id' => $id
				)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });
	
	$app->get('/entregador/delete/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

		$id = $args['id'];
        $sql = "delete from entregador where id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array(
				':id' => $id
				)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });
};