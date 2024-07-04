<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    public function verificarLoginMW(Request $request, RequestHandler $handler) {$header = $request->getHeaderLine('Authorization');

        if ($header !== "")
        {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "El usuario no esta loggeado.")));
        }
        return $response;
    }
}