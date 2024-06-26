<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];

        // Creamos el Producto
        $prd = new Producto();
        $prd->nombre = $nombre;
        $prd->precio = $precio;
        $prd->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      // Buscamos producto por nombre
      $prod = $args['nombre'];
      $producto = Producto::obtenerProducto($prod);
      $payload = json_encode($producto);

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("listaProducto" => $lista));

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

    public function CargarProductosDesdeCSVController($request, $response, $args){
      $uploadedFiles = $request->getUploadedFiles();
      $csvFile = $uploadedFiles['csv'];
      
      if ($csvFile->getError() === UPLOAD_ERR_OK) {
        Producto::cargarProductosPorCSV($csvFile);
        $response->getBody()->write('Archivo CSV procesado exitosamente.');
        return $response->withStatus(200);
      }

      $response->getBody()->write('Error al cargar el archivo.');
      return $response->withStatus(400);
    }

    public function GuardarProductosEnCSV($request, $response, $args){
      $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'CSVs_Cargados'.DIRECTORY_SEPARATOR.'productos.csv';

      Producto::cargarProductosACSV($filePath);

      $payload = json_encode(array("mensaje" => "El archivo se descargo exitosamente"));

        $response->getBody()->write($payload);

      return $response->withHeader('Content-Type', 'application/csv')
                    ->withHeader('Content-Disposition', 'attachment; filename="pedidos.csv"');
    }
}