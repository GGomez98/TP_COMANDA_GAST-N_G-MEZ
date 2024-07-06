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
        $tipo_archivo = $_FILES['foto']['type'];
        $tamano_archivo = $_FILES['foto']['size'];
        $extension = "";

        if ((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 300000)) {

          $extension = substr($tipo_archivo, strpos($tipo_archivo, '/') + 1);

      } else {
          $payload = json_encode(array("mensaje" => "La imagen no tiene un formato o tamaño que sean admitidos."));
          $response->getBody()->write($payload);
          return $response->withHeader('Content-Type', 'application/json');
      }

        // Creamos el Pedido
        $ped = new Pedido();
        $ped->codigoPedido = $codigoPedido;
        $ped->codigoMesa = $codigoMesa;
        $ped->mozo = $mozo;
        $ped->crearPedido($_FILES['foto'],$extension);

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
      foreach($pedido->productos as $producto){
        if($producto->tiempoPreparacion == 0){
          $producto->tiempoPreparacion = 'No Asignado';
        }
      }
      $payload = json_encode($pedido);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
      $parametros = $request->getQueryParams();

      if(isset($parametros['codigoPedido'])){
        $pedido = Pedido::obtenerPedido($parametros['codigoPedido']);
      $pedido->productos = $pedido->obtenerProductosDelPedido();
      foreach($pedido->productos as $producto){
        if($producto->tiempoPreparacion == 0){
          $producto->tiempoPreparacion = 'No Asignado';
        }
      }
      $payload = json_encode($pedido);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
      }
      else{
        $lista = Pedido::obtenerTodos();
        foreach($lista as $pedido){
          $pedido->productos = $pedido->obtenerProductosDelPedido();
          foreach($pedido->productos as $producto){
            if($producto->tiempoPreparacion == 0){
              $producto->tiempoPreparacion = 'No Asignado';
            }
          }
        }
        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
      }
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
      if($ped->estado == 'realizado'){
        $payload = json_encode(array("mensaje" => "El producto se cargo al pedido"));
      }
      else{
        $payload = json_encode(array("mensaje" => "El pedido no se encuentra en estado realizado, no se pueden cargar productos"));
      }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TomarOrdenController($request, $response, $args){
      $parametros = $request->getParsedBody();

      $codigoPedido = $parametros['codigoPedido'];

      $ped = Pedido::obtenerPedido($codigoPedido);
      if($ped->TomarOrden()){
        $payload = json_encode(array("mensaje" => "Se cambio el estado del pedido"));
      }
      else{
        $payload = json_encode(array("mensaje" => "Esta orden ya se tomo y esta lista para preparar"));
      }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CancelarPedidoController($request, $response, $args){
      $parametros = $request->getParsedBody();

      $codigoPedido = $parametros['codigoPedido'];

      $ped = Pedido::obtenerPedido($codigoPedido);

      if($ped->estado === 'entregado' || $ped->estado === 'cancelado'){
        $payload = json_encode(array("mensaje" => "El pedido ya fue entregado o cancelado y no se puede cancelar"));
      }
      else{
        $ped->cancelarPedido();
        $payload = json_encode(array("mensaje" => "Se cancelo pedido"));
      }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarProductosDesdeCSVController($request, $response, $args){
      $uploadedFiles = $request->getUploadedFiles();
      $csvFile = $uploadedFiles['csv'];
      
      if ($csvFile->getError() === UPLOAD_ERR_OK) {
        Pedido::cargarPedidosPorCSV($csvFile);
        $response->getBody()->write('Archivo CSV procesado exitosamente.');
        return $response->withStatus(200);
      }

      $response->getBody()->write('Error al cargar el archivo.');
      return $response->withStatus(400);
    }

    public function GuardarPedidosEnCSV($request, $response, $args){
      $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'CSVs_Cargados'.DIRECTORY_SEPARATOR.'pedidos.csv';

      Pedido::cargarPedidosACSV($filePath);

      $payload = json_encode(array("mensaje" => "El archivo se descargo exitosamente"));

        $response->getBody()->write($payload);

      return $response->withHeader('Content-Type', 'application/csv')
                    ->withHeader('Content-Disposition', 'attachment; filename="pedidos.csv"');
    }

    public function ListarPedidosSector($request, $response, $args){
      $uri = $request->getUri();
      $path = $uri->getPath();
      $sector = str_replace("/sectores/", "", $path);
      switch ($sector) {
          case "cocina":
              $sectorAListar = 3;
              break;
          case "candybar":
              $sectorAListar = 4;
              break;
          case "patio":
              $sectorAListar = 2;
              break;
          case "barra":
              $sectorAListar = 1;
              break;
          default:
              $sectorAListar = 3;
              break;
      }
      $lista = Pedido::listarPorductosEnPedidoPorSector($sectorAListar);
      $payload = json_encode(array("listaPendientes" => $lista));

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function IniciarPreparacionController($request, $response, $args){
      $parametros = $request->getParsedBody();

      $idProducto = $parametros['producto'];
      $idUsuario = $parametros['usuarioPreparacion'];
      $tiempo = $parametros['tiempoPreparacion'];

      Pedido::IniciarPreparacion($idProducto, $idUsuario, $tiempo);

      $payload = json_encode(array("mensaje" => "La preparacion se inicio con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function FinalizarPreparacionController($request, $response, $args){
      $parametros = $request->getParsedBody();
      
      $idProducto = $parametros['producto'];
      $codigoPedido = $parametros['codigoPedido'];
      $paraServir = true;

      if(Producto::obtenerProductoEnPedido($idProducto)->estado != 3){
        $payload = json_encode(array("mensaje" => "Este producto no esta en preparacion, no se puede finalizar"));
      }
      else{
        Pedido::FinalizarPreparacion($idProducto);

        $payload = json_encode(array("mensaje" => "La preparacion se finalizo con exito"));
      }

      $ped = Pedido::obtenerPedido($codigoPedido);
      $ped->productos = $ped->obtenerProductosDelPedido();

      foreach($ped->productos as $producto){
        if($producto->estado != "listo para servir"){
          $paraServir = false;
        }
      }
      
      if($paraServir){
        Pedido::CambiarEstadoPedido(4,$codigoPedido);
      }

      $response->getBody()->write($payload);
          return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerPedidosListosParaSevir($request, $response, $args){
      $lista = Pedido::ListarPedidosPorEstado(4);
        foreach($lista as $pedido){
          $pedido->productos = $pedido->obtenerProductosDelPedido();
          foreach($pedido->productos as $producto){
            if($producto->tiempoPreparacion == 0){
              $producto->tiempoPreparacion = 'No Asignado';
            }
          }
        }
        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}