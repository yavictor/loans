<?php

use App\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/loans/all', function (Request $request, Response $response): Response {
    $sql = "SELECT * FROM loans LIMIT 100";

    try {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $loans = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($loans));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->get('/loans/{id}', function (Request $request, Response $response): Response {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM loans WHERE id = $id";

    try {
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $loan = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $response->getBody()->write(json_encode($loan));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->post('/loans/add', function (Request $request, Response $response, array $args): Response {
    $data = $request->getParsedBody();

    $value = $data["value"];
    $term = $data["term"];
    $interest_rate = $data["interest_rate"];

    $sql = "INSERT INTO loans (value, term, interest_rate) VALUES (:value, :term, :interest_rate);";

    try {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':interest_rate', $interest_rate);
        $stmt->execute();
        $newId = $conn->lastInsertId();

        $db = null;
        $response->getBody()->write(json_encode(['id' => $newId]));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->put(
    '/loans/update/{id}',
    function (Request $request, Response $response, array $args)
    {
        $id = $request->getAttribute('id');
        $data = $request->getParsedBody();
        $amount_paid = $data['amount_paid'];

        $sql = "UPDATE loans SET
                    amount_paid = :amount_paid
                WHERE id = $id";

        try {
            $db = new Database();
            $conn = $db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':amount_paid', $amount_paid);
            $result = $stmt->execute();
            $db = null;

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

$app->delete('/loans/delete/{id}', function (Request $request, Response $response, array $args) {
    $id = $args["id"];

    $sql = "DELETE FROM loans WHERE id = $id";

    try {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});
