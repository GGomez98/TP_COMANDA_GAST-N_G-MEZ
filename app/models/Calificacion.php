<?php

class Calificacion{
    public $id;
    public $descripcion;
    public $codigoMesa;
    public $codigoPedido;
    public $puntaje;

    public function CrearPedido(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO calificaciones (descripcion, idMesa, idPedido, puntaje) VALUES (:descripcion, :idMesa, :idPedido, :puntaje)");
        $consulta->bindValue(":descripcion",$this->descripcion, PDO::PARAM_STR);
        $consulta->bindValue(":idMesa",$this->codigoMesa, PDO::PARAM_INT);
        $consulta->bindValue(":idPedido",$this->codigoPedido, PDO::PARAM_INT);
        $consulta->bindValue(":puntaje",$this->puntaje, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function ObtenerCalificaciones(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT calificaciones.id, calificaciones.descripcion, mesas.codigoMesa as codigoMesa, pedidos.codigoPedido as codigoPedido, calificaciones.puntaje FROM calificaciones JOIN mesas ON calificaciones.idMesa = mesas.id JOIN pedidos ON calificaciones.idPedido = pedidos.id");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Calificacion');
    }

    public static function ObtenerLosMejoresComentarios(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT calificaciones.id, calificaciones.descripcion, mesas.codigoMesa as codigoMesa, pedidos.codigoPedido as codigoPedido, calificaciones.puntaje FROM calificaciones JOIN mesas ON calificaciones.idMesa = mesas.id JOIN pedidos ON calificaciones.idPedido = pedidos.id ORDER BY calificaciones.puntaje DESC LIMIT 5");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Calificacion');
    }
}