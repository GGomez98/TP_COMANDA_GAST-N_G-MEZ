<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoPedido = $parametros['codigoPedido'];
        $codigoMesa = $parametros['codigoMesa'];
        $mozo = $parametros['mozo'];

        // Creamos el Pedido
        $ped = new Pedido();
        $ped->codigoPedido = $codigoPedido;
        $ped->codigoMesa = $codigoMesa;
        $ped->estado = 'Realizado';
        $ped->mozo = $mozo;
        $ped->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      // Buscamos pedido por codigoPedido
      $ped = $args['codigoPedido'];
      $pedido = Pedido::obtenerPedido($ped);
      $pedido->productos = $pedido->obtenerProductosDelPedido();
      $payload = json_encode($pedido);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        foreach($lista as $pedido){
          $pedido->productos = $pedido->obtenerProductosDelPedido();
        }
        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
    }

    public function BorrarUno($request, $response, $args)
    {
    }

    public function AgregarProd($request, $response, $args){
      $parametros = $request->getParsedBody();

      $producto = $parametros['producto'];
      $codigoPedido = $parametros['codigoPedido'];

      $ped = Pedido::obtenerPedido($codigoPedido);

      $ped->agregarProducto($producto);

      $payload = json_encode(array("mensaje" => "El producto se cargo al pedido"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}