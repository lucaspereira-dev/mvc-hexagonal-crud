<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class Controller {
    protected function response(Response $response, array $data, $code = 200): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json')->withStatus($code);
        $response->getBody()->write(json_encode($data));
        return $response;
    }
}
