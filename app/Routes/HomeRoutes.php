<?php

namespace Routes;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function homeRoutes(App $app)
{
    $app->get('/', function (Request $request, Response $response) {
        $response = $response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write(file_get_contents(__DIR__ . '/../View/index.html'));
        return $response;
    });
}
