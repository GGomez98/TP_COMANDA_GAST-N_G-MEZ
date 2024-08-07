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
require_once './controllers/CalificacionController.php';
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
  $group->get('/mesaMasUsada', \MesaController::class . ':MostrarMesaMasUsada');
  $group->get('[/]', \MesaController::class . ':TraerTodos')
        ->add(new RolMiddleware(["Socio", "Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->post('[/]', \MesaController::class . ':CargarUno')
        ->add(new RolMiddleware(["Socio"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW")
        ->add(\DatosMiddleware::class . ":cargarMesaMW");
  $group->post('/cargarCSV',\MesaController::class . ':CargarMesasDesdeCSVController');
  $group->post('/descargarCSV',\MesaController::class . ':GuardarMesasEnCSV');
  $group->put('/cerrarMesa', \MesaController::class . ':CerrarMesa')
        ->add(new RolMiddleware(["Socio"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('/listosParaServir',\PedidoController::class . ':ObtenerPedidosListosParaSevir')
        ->add(new RolMiddleware(["Mozo"]));
  $group->get('[/]', \PedidoController::class . ':TraerTodos')
        ->add(new RolMiddleware(["Mozo","Socio"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->get('/{codigoPedido}', \PedidoController::class . ':TraerUno');
  $group->post('/entregarPedido',\PedidoController::class . ':EntregarPedido')
        ->add(new RolMiddleware(["Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");  
  $group->post('[/]', \PedidoController::class . ':CargarUno')
        ->add(new RolMiddleware(["Mozo"]))  
        ->add(\AuthMiddleware::class . ":verificarLoginMW")
        ->add(\DatosMiddleware::class . ":cargarPedidoMW");
  $group->post('/agregarProducto', \PedidoController::class . ':AgregarProd')
        ->add(new RolMiddleware(["Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->post('/tomarOrden', \PedidoController::class . ':TomarOrdenController')
        ->add(new RolMiddleware(["Mozo"]));
  $group->post('/cancelarPedido', \PedidoController::class . ':CancelarPedidoController')
        ->add(new RolMiddleware(["Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW")      
        ->add(\DatosMiddleware::class . ":accionPedidoMW");
  $group->post('/cargarCSV',\PedidoController::class . ':CargarProductosDesdeCSVController');
  $group->post('/descargarCSV',\PedidoController::class . ':GuardarPedidosEnCSV');
  $group->put('/iniciarPreparacion',\PedidoController::class . ':IniciarPreparacionController')
        ->add(new RolMiddleware(["cocinero","bartender","cervecero","repostero"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");  
  $group->put('/finalizarPreparacion',\PedidoController::class . ':FinalizarPreparacionController')
        ->add(new RolMiddleware(["cocinero","bartender","cervecero","repostero"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->put('/cobrarCuenta', \PedidoController::class . ':CobrarCuentaController')
        ->add(new RolMiddleware(["Mozo"]))
        ->add(\AuthMiddleware::class . ":verificarLoginMW");
  $group->post('/DescargarPDF', \PedidoController::class . ':DescargarPDFController');
});

$app->group('/sectores', function (RouteCollectorProxy $group) {
  $group->get('/cocina', \PedidoController::class . ':ListarPedidosSector')
        ->add(new RolMiddleware(["Socio", "cocinero"]))
        ->add(\AuthMiddleware::class . ':verificarLoginMW');
  $group->get('/candybar', \PedidoController::class . ':ListarPedidosSector')
        ->add(new RolMiddleware(["Socio", "repostero"]))
        ->add(\AuthMiddleware::class . ':verificarLoginMW');
  $group->get('/patio', \PedidoController::class . ':ListarPedidosSector')
        ->add(new RolMiddleware(["Socio", "cervecero"]))
        ->add(\AuthMiddleware::class . ':verificarLoginMW');
  $group->get('/barra', \PedidoController::class . ':ListarPedidosSector')
        ->add(new RolMiddleware(["Socio", "bartender"]))
        ->add(\AuthMiddleware::class . ':verificarLoginMW');
});

$app->group('/calificaciones', function (RouteCollectorProxy $group){
      $group->post('[/]',\CalificacionController::class . ':CrearUna');
      $group->get('/mejoresComentarios',\CalificacionController::class . ':ObtenerMejores');
      $group->get('[/]',\CalificacionController::class . ':ObtenerTodas');
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
