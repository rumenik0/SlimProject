<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function($app, $container){

    $app->post('/produto/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $nome = $body['nome'];
        $descricao = $body['descricao'];		
        $valor = $body['valor'];
        
        $stmt = $connection->prepare('INSERT INTO produto(nome, descricao, valor) VALUES (:nome, :descricao,:valor)');
        $stmt->execute(array(
                ':nome' => $nome,
                ':descricao' => $descricao,
				':valor' => $valor
				)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });

    // GET All individual entities from DB
    $app->get('/produto/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Pessoas App: [GET] pessoas/");

        $connection = $this->db;
        $stmt = $connection->query("SELECT * FROM produto;");

        $data = $stmt->fetchAll();

        return $response->withJson($data)
            ->withStatus(200);
    });
	
	$app->post('/produto/update/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $nome = $body['nome'];
        $descricao = $body['descricao'];		
        $valor = $body['valor'];
		$id = $body['id'];
        $sql = "update produto set nome = :nome, descricao = :descricao, valor = :valor where id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array(
                ':nome' => $nome,
                ':descricao' => $descricao,
				':valor' => $valor,
				':id' => $id
				)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });
	
	$app->get('/produto/delete/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

		$id = $args['id'];
        $sql = "delete from produto where id = :id";
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