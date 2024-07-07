<?php

require_once "./models/Calificacion.php";
require_once "./models/Mesa.php";
require_once "./models/Pedido.php";

class CalificacionController extends Calificacion{
    public function CrearUna($request, $response, $args){
        $parametros = $request->getParsedBody();

        $descripcion = $parametros['descripcion'];
        $codigoPedido = $parametros['codigoPedido'];
        $puntaje = $parametros['puntaje'];

        $ped = Pedido::obtenerPedido($codigoPedido);
        $mesa = Mesa::ObtenerMesa($ped->codigoMesa);

        if(strlen($descripcion)<=66 && (int)$puntaje<=10 && (int)$puntaje>=1){
            $calif = new Calificacion();
            $calif->descripcion = $descripcion;
            $calif->codigoMesa = $mesa->id;
            $calif->codigoPedido = $ped->id;
            $calif->puntaje = $puntaje;
            $calif->CrearPedido();

            $payload = json_encode(array("mensaje" => "Comentario cargado con exito"));
        }
        else{
            $payload = json_encode(array("mensaje" => "Error al cargar el comentario"));
        }

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerTodas($request, $response, $args){
        $lista = Calificacion::ObtenerCalificaciones();
        $payload = json_encode(array("calificaciones" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}