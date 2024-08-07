<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $perfil = $parametros['perfil'];

        // Creamos el usuario
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->perfil = $perfil;
        $usr->crearUsuario();

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['usuario'];
        Usuario::modificarUsuario($nombre);

        $payload = json_encode(array("mensaje" => "Usuario modificado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuarioId = $parametros['usuarioId'];
        Usuario::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function CargarUsuariosDesdeCSVController($request, $response, $args){
      $uploadedFiles = $request->getUploadedFiles();
      $csvFile = $uploadedFiles['csv'];
      
      if ($csvFile->getError() === UPLOAD_ERR_OK) {
        Usuario::cargarUsuariosPorCSV($csvFile);
        $response->getBody()->write('Archivo CSV procesado exitosamente.');
        return $response->withStatus(200);
      }

      $response->getBody()->write('Error al cargar el archivo.');
      return $response->withStatus(400);
    }

    public function GuardarUsuariosEnCSV($request, $response, $args){
      $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'CSVs_Cargados'.DIRECTORY_SEPARATOR.'usuarios.csv';

      Usuario::cargarUsuariosACSV($filePath);

      $payload = json_encode(array("mensaje" => "El archivo se descargo exitosamente"));

        $response->getBody()->write($payload);

      return $response->withHeader('Content-Type', 'application/csv')
                    ->withHeader('Content-Disposition', 'attachment; filename="usuarios.csv"');
    }
}
