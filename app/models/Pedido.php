<?php

class Pedido{
    public $id;
    public $productos;
    public $mozo;
    public $estado;
    public $codigoMesa;
    public $codigoPedido;
    public $tiempoRestante;

    private function obtenerId($table, $param, $atributte){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $stmt = $objAccesoDatos->prepararConsulta("SELECT id FROM ".$table." WHERE nombre = ".$param);
        $stmt->execute([$param => $atributte]);
        return $stmt->fetchColumn();
    }

    private function obtenerIdMesa($table, $param, $atributte){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $stmt = $objAccesoDatos->prepararConsulta("SELECT id FROM ".$table." WHERE codigoMesa = ".$param);
        $stmt->execute([$param => $atributte]);
        return $stmt->fetchColumn();
    }
    private function obtenerIdMozo(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $stmt = $objAccesoDatos->prepararConsulta("SELECT id FROM usuarios WHERE usuario = :usuario AND idPerfil = 2");
        $stmt->execute([":usuario" => $this->mozo]);
        return $stmt->fetchColumn();
    }
    public function crearPedido()
    {
        $this->estado = "Realizado";
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (idEstado, idMesa, idMozo, codigoPedido) VALUES (:idEstado, :idMesa, :idMozo, :codigoPedido)");
        $consulta->bindValue(':idEstado', $this->obtenerId("estadospedido",":estado",$this->estado), PDO::PARAM_INT);
        $consulta->bindValue(':idMesa', $this->obtenerIdMesa("mesas",":mesa",$this->codigoMesa), PDO::PARAM_INT);
        $consulta->bindValue(':idMozo', $this->obtenerIdMozo(), PDO::PARAM_INT);
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pedidos.id, mesas.codigoMesa, estadospedido.nombre as estado, usuarios.usuario as mozo, pedidos.codigoPedido FROM pedidos JOIN mesas on mesas.id = pedidos.idMesa JOIN estadospedido on estadospedido.id = pedidos.idEstado JOIN usuarios on usuarios.id = pedidos.idMozo");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pedidos.id, mesas.codigoMesa, estadospedido.nombre as estado, usuarios.usuario as mozo, pedidos.codigoPedido FROM pedidos JOIN mesas on mesas.id = pedidos.idMesa JOIN estadospedido on estadospedido.id = pedidos.idEstado JOIN usuarios on usuarios.id = pedidos.idMozo WHERE codigoPedido = :codigoPedido");
        $consulta->bindValue(':codigoPedido', $pedido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public function agregarProducto($producto){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productospedidos (idProducto, idPedido) VALUES (:idProducto, :idPedido)");
        $consulta->bindValue(":idProducto", Producto::obtenerProducto($producto)->id, PDO::PARAM_INT);
        $consulta->bindValue(':idPedido', $this::obtenerPedido($this->codigoPedido)->id, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function obtenerProductosDelPedido(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT menu.id, menu.nombre, menu.precio FROM menu JOIN productospedidos on menu.id = productospedidos.idProducto WHERE productospedidos.idPedido = :idPedido;");
        $consulta->bindValue(':idPedido', $this::obtenerPedido($this->codigoPedido)->id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public function cambiarEstadoPedido(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        switch($this->estado){
            case 'realizado':
                $this->estado = 'Listo para preparar';
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET idEstado = 2 WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
                $consulta->execute();
            break;
            case 'listo para preparar':
                $this->estado = 'En preparacion';
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET idEstado = 3 WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
                $consulta->execute();
            break;
            case 'en preparacion':
                $this->estado = 'Listo para servir';
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET idEstado = 4 WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
                $consulta->execute();
            break;
            case 'listo para servir':
                $this->estado = 'Entregado';
                $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET idEstado = 5 WHERE codigoPedido = :codigoPedido");
                $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
                $consulta->execute();
            break;
            default:
                return false;
        }
    }

    public function cancelarPedido(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $this->estado = 'cancelado';
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET idEstado = 6 WHERE codigoPedido = :codigoPedido");
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function cargarPedidosPorCSV($csv){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $filePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'CSVs_Leidos\\'.$csv->getClientFilename();

        $csv->moveTo($filePath);

        $file = fopen($filePath, 'r');

        $firstLine = true;

        while (($data = fgetcsv($file)) !== FALSE) {
            // Omitir la primera línea si contiene encabezados
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            $codigoPedido = $data[0];
            $codigoMesa = $data[1];
            $mozo = $data[2];

            $usr = new Pedido();
            $usr->codigoPedido = $codigoPedido;
            $usr->codigoMesa = $codigoMesa;
            $usr->mozo = $mozo;

            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (idEstado, idMesa, idMozo, codigoPedido) VALUES (:idEstado, :idMesa, :idMozo, :codigoPedido)");
            $consulta->bindValue(':idEstado', 1, PDO::PARAM_INT);
            $consulta->bindValue(':idMesa', $usr->obtenerIdMesa("mesas",":mesa",$usr->codigoMesa), PDO::PARAM_INT);
            $consulta->bindValue(':idMozo', $usr->obtenerIdMozo(), PDO::PARAM_INT);
            $consulta->bindValue(':codigoPedido', $usr->codigoPedido, PDO::PARAM_STR);
            $consulta->execute();
        }
        
        fclose($file);

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function cargarPedidosACSV($filePath){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $stmt = $objAccesoDatos->prepararConsulta("SELECT pedidos.codigoPedido, mesas.codigoMesa, usuarios.usuario as mozo FROM pedidos JOIN mesas on mesas.id = pedidos.idMesa JOIN estadospedido on estadospedido.id = pedidos.idEstado JOIN usuarios on usuarios.id = pedidos.idMozo");
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $exportDir = dirname($filePath);
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        $file = fopen($filePath, 'w');

        fputcsv($file, ['codigoPedido', 'codigoMesa', 'mozo']);

        foreach ($pedidos as $pedido) {
            fputcsv($file, $pedido);
        }

        fclose($file);
    }
}