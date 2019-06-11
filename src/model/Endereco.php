<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function($app, $container){

    $app->post('/endereco/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $bairro = $body['bairro'];
        $cep = $body['cep'];
        $logradouro = $body['logradouro'];
        $numero = $body['numero'];
        $referencia = $body['referencia'];
        
        $stmt = $connection->prepare('INSERT INTO  endereco(bairro, cep, logradouro, numero, referencia) VALUES (:bairro, :cep, :logradouro, :numero, :referencia)');
        $stmt->execute(array(
                ':bairro' => $bairro,
                ':cep' => $cep,
                ':logradouro' => $logradouro,
                ':numero' => $numero,
                ':referencia' => $referencia)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });

    // GET All individual entities from DB
    $app->get('/endereco/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Pessoas App: [GET] pessoas/");

        $connection = $this->db;
        $stmt = $connection->query("SELECT * FROM endereco;");

        $data = $stmt->fetchAll();

        return $response->withJson($data)
            ->withStatus(200);
    });

    $app->get('/', function(Request $request, Response $response, array $args) use ($container){
        return phpinfo();
    });
	
	
	
	$app->post('/endereco/update/', function(Request $request, Response $response, array $args) use ($container){
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

        $bairro = $body['bairro'];
        $cep = $body['cep'];
        $logradouro = $body['logradouro'];
        $numero = $body['numero'];
        $referencia = $body['referencia'];
		$id = $body['id'];
        $sql = "update endereco set bairro = :bairro, cep = :cep, logradouro = :logradouro, numero = :numero, referencia = :referencia where id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(array(
                ':bairro' => $bairro,
                ':cep' => $cep,
                ':logradouro' => $logradouro,
                ':numero' => $numero,
                ':referencia' => $referencia,
				':id' => $id)
        );
        $data = $stmt->rowCount();

        return $response->withJson($data)
                        ->withStatus(200);
    });
	
	
	$app->get('/endereco/delete/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $body = $request->getParsedBody();
        $connection = $this->db;
        $data = null;

		$id = $args['id'];
        $sql = "delete from endereco where id = :id";
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