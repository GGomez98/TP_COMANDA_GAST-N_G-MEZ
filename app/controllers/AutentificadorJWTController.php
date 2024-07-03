<?php
require_once './models/Usuario.php';
require_once './utils/AutentificadorJWT.php';

class AutentificadorJWTController extends Usuario
{
    public function LoginUsuario($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        $usuario = Usuario::obtenerUsuario($usuario);

        if (password_verify($clave, $usuario->clave)) {
            $datos = array('usuario' => $usuario->usuario, 'rol' => $usuario->perfil);
            $token = AutentificadorJWT::CrearToken($datos);
            $payload = json_encode(array('jwt' => $token));
        } else {
            $payload = json_encode(array('error' => 'Usuario o contraseña incorrectos'));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}