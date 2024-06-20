<?php
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class RolMiddleware{
    public $rol = '';

    public function __construct($rol){
        $this->rol = $rol;
    }

    public function __invoke(Request $request, RequestHandler $handler){
        $params = $request->getQueryParams();
        $usr = UsuarioController::obtenerUsuario($params['usuario']);

        if($usr->perfil == $this->rol){
            $response = $handler->handle($request);
        }
        else{
            $response = new Response();
            $response->getBody()->write(json_encode(array("error"=>"No sos ".$this->rol)));
        }

        return $response;
    }

    public function cambiarEstadoPedidoMW(Request $request, RequestHandler $handler){
        $queryParams = $request->getQueryParams();
        $postParams = $request->getParsedBody();

        $usr = UsuarioController::obtenerUsuario($queryParams['usuario']);
        $ped = PedidoController::obtenerPedido($postParams['codigoPedido']);

        if($usr->perfil == 'Mozo' && ($ped->estado == 'realizado' || $ped->estado == 'listo para servir') || ($usr->perfil == 'cocinero'||$usr->perfil == 'bartener'||$usr->perfil == 'cervezero')&&($ped->estado == 'listo para preparar' || $ped->estado == 'en preparacion')){
            $response = $handler->handle($request);
        }
        else{
            $response = new Response();
            $response->getBody()->write(json_encode(array("error"=>"No tenes permisos para cambiar el estado del pedido")));
        }

        return $response;
    }
}