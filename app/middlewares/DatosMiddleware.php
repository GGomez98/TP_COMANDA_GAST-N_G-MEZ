<?php
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
class DatosMiddleware{
    public function cargarUserMW(Request $request, RequestHandler $handler)
    {
        // SE EJECUTA ANTES
        $params = $request->getParsedBody();

        if (isset($params["usuario"], $params["clave"], $params["perfil"])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
        }

        return $response;
    }

    public function cargarProductoMW(Request $request, RequestHandler $handler)
    {
        // SE EJECUTA ANTES
        $params = $request->getParsedBody();

        if (isset($params["nombre"], $params["precio"])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
            return $response;
        }

        return $response;
    }

    public function cargarMesaMW(Request $request, RequestHandler $handler)
    {
        // SE EJECUTA ANTES
        $params = $request->getParsedBody();

        if (isset($params["codigoMesa"])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
            return $response;
        }

        return $response;
    }

    public function cargarPedidoMW(Request $request, RequestHandler $handler)
    {
        // SE EJECUTA ANTES
        $params = $request->getParsedBody();

        if (isset($params["codigoMesa"], $params["codigoPedido"], $params["mozo"])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
            return $response;
        }

        return $response;
    }

    public function accionPedidoMW(Request $request, RequestHandler $handler){
        $paramsQuery = $request->getQueryParams();
        $paramsBody = $request->getParsedBody();

        if (isset($paramsQuery["usuario"], $paramsQuery["clave"], $paramsBody["codigoPedido"])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
            return $response;
        }

        return $response;
    }

    public function agregarProductoAPedidoMW(Request $request, RequestHandler $handler)
    {
        // SE EJECUTA ANTES
        $params = $request->getParsedBody();
        $paramsQuery = $request->getQueryParams();

        if (isset($params["producto"], $params["codigoPedido"], $paramsQuery['usuario'])) {
            // ENTRO AL VERBO / PROXIMO MW
            $response = $handler->handle($request);
        } else {
            // SI NO ENTRO AL VERBO, QUIERO UNA NUEVA RESPONSE.
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Faltan parametros")));
            return $response;
        }

        return $response;
    }
}