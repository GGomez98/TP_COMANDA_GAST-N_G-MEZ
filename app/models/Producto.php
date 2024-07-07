<?php

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $estado;
    public $sector;
    public $codigoPedido;
    public $tiempoPreparacion;
    public $usuarioPreparacion;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre, precio, idSector) VALUES (:nombre, :precio, :idSector)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':idSector', $this->sector, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT menu.id, menu.nombre, precio, sectores.nombre as sector FROM menu JOIN sectores on sectores.id = menu.idSector;");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerPedido($pedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT pedido.id, pedido.idMesa, pedido.idEstado, pedido.codigoPedido FROM usuarios WHERE codigoPedido = :codigoPedido");
        $consulta->bindValue(':codigoPedido', $pedido, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function obtenerProducto($idProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT menu.id, menu.nombre, menu.precio FROM menu WHERE id = :id;");
        $consulta->bindValue(':id', $idProducto, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function obtenerProductoEnPedido($idProducto){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT productospedidos.id as id, productospedidos.idProducto as nombre, productospedidos.idEstado as estado, productospedidos.idUsuarioPreparacion as usuarioPreparacion, productospedidos.tiempoPreparacion as tiempoPreparacion FROM productospedidos WHERE id = :id;");
        $consulta->bindValue(':id', $idProducto, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }

    public static function cargarProductosPorCSV($csv){
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

            $nombre = $data[0];
            $precio = $data[1];
            $sector = $data[2];

            $usr = new Producto();
            $usr->nombre = $nombre;
            $usr->precio = $precio;
            $usr->sector = $sector;

            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre, precio, idSector) VALUES (:nombre, :precio, :idSector)");
            $consulta->bindValue(':nombre', $usr->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $usr->precio);
            $consulta->bindValue(':idSector', $usr->sector, PDO::PARAM_INT);
            $consulta->execute();
        }
        
        fclose($file);

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function cargarProductosACSV($filePath){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $stmt = $objAccesoDatos->prepararConsulta("SELECT nombre, precio FROM menu");
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $exportDir = dirname($filePath);
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        $file = fopen($filePath, 'w');

        fputcsv($file, ['nombre', 'precio']);

        foreach ($productos as $producto) {
            fputcsv($file, $producto);
        }

        fclose($file);
    }

    public static function cambiarEstadoProducto($idEstado, $id){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE productospedidos SET idEstado = :idEstado WHERE id = :id");
        $consulta->bindValue(":idEstado", $idEstado, PDO::PARAM_INT);
        $consulta->bindValue(":id", $id, PDO::PARAM_INT);
        $consulta->execute();
    }
}
