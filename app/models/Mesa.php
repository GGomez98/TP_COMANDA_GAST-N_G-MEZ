<?php

//require_once "./Pedido.php";
class Mesa{
    public $id;
    public $estado;
    public $pedido;
    public $codigoMesa;
    public $calificaciones;

    private function obtenerId($table, $param, $atributte){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $stmt = $objAccesoDatos->prepararConsulta("SELECT id FROM ".$table." WHERE nombre = ".$param);
        $stmt->execute([$param => $atributte]);
        return $stmt->fetchColumn();
    }
    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (idEstado, codigoMesa) VALUES (:idEstado, :codigoMesa)");
        $consulta->bindValue(':idEstado', $this->obtenerId("estadosmesa", ":estadosMesa", $this->estado), PDO::PARAM_INT);
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, estadosmesa.nombre as estado, mesas.codigoMesa FROM mesas JOIN estadosmesa on estadosmesa.id = mesas.idEstado;");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }
}