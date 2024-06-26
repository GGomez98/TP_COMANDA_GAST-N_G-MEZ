<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigoMesa = $parametros['codigoMesa'];

        // Creamos el Mesa
        $mesa = new Mesa();
        $mesa->codigoMesa = $codigoMesa;
        $mesa->estado = 'Cerrada';
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesa" => $lista));

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

    public function CargarMesasDesdeCSVController($request, $response, $args){
      $uploadedFiles = $request->getUploadedFiles();
      $csvFile = $uploadedFiles['csv'];
      
      if ($csvFile->getError() === UPLOAD_ERR_OK) {
        Mesa::cargarMesasPorCSV($csvFile);
        $response->getBody()->write('Archivo CSV procesado exitosamente.');
        return $response->withStatus(200);
      }

      $response->getBody()->write('Error al cargar el archivo.');
      return $response->withStatus(400);
    }

    public function GuardarMesasEnCSV($request, $response, $args){
      $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'CSVs_Cargados'.DIRECTORY_SEPARATOR.'mesas.csv';

      Mesa::cargarMesasACSV($filePath);

      $payload = json_encode(array("mensaje" => "El archivo se descargo exitosamente"));

        $response->getBody()->write($payload);

      return $response->withHeader('Content-Type', 'application/csv')
                    ->withHeader('Content-Disposition', 'attachment; filename="mesas.csv"');
    }
}