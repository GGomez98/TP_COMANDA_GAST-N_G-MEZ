<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/AutentificadorJWTController.php';
require_once './middlewares/DatosMiddleware.php';
require_once './middlewares/RolMiddleware.php';
require_once './middlewares/AuthMiddleware.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno')
          ->add(\DatosMiddleware::class . ":cargarUserMW");
    $group->post('/cargarCSV',\UsuarioController::class . ':CargarUsuariosDesdeCSVController');
    $group->post('/descargarCSV',\UsuarioController::class . ':GuardarUsuariosEnCSV');
  })
    ->add(new RolMiddleware(["Socio"]));

$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{nombre}', \ProductoController::class . ':TraerUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno')
          ->add(\DatosMiddleware::class . ":cargarProductoMW");
    $group->post('/cargarCSV',\ProductoController::class . ':CargarProductosDesdeCSVController');
    $group->post('/descargarCSV',\ProductoController::class . ':GuardarProductosEnCSV');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos')
        ->add(new RolMiddleware(["Socio", "Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->post('[/]', \MesaController::class . ':CargarUno')
        ->add(new RolMiddleware(["Socio"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW")
        ->add(\DatosMiddleware::class . ":cargarMesaMW");
  $group->post('/cargarCSV',\MesaController::class . ':CargarMesasDesdeCSVController');
  $group->post('/descargarCSV',\MesaController::class . ':GuardarMesasEnCSV');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/{codigoPedido}', \PedidoController::class . ':TraerUno');
  $group->post('[/]', \PedidoController::class . ':CargarUno')
        ->add(new RolMiddleware(["Mozo"]))  
        ->add(\AuthMiddleware::class . ":verificarLoginMW")
        ->add(\DatosMiddleware::class . ":cargarPedidoMW");
  $group->post('/agregarProducto', \PedidoController::class . ':AgregarProd')
        ->add(new RolMiddleware(["Mozo"]));
  $group->post('/cambiarEstado', \PedidoController::class . ':CambiarEstadoPedidoController')      
        ->add(\DatosMiddleware::class . ":accionPedidoMW");
  $group->post('/cancelarPedido', \PedidoController::class . ':CancelarPedidoController')
        ->add(new RolMiddleware(["Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW")      
        ->add(\DatosMiddleware::class . ":accionPedidoMW");
  $group->post('/cargarCSV',\PedidoController::class . ':CargarProductosDesdeCSVController');
  $group->post('/descargarCSV',\PedidoController::class . ':GuardarPedidosEnCSV');
});



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->group('/auth', function (RouteCollectorProxy $group) {
      $group->post('[/]',\AutentificadorJWTController::class . ":LoginUsuario" );
});

$app->run();
