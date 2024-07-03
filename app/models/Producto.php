<?php

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $estado;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre, precio) VALUES (:nombre, :precio)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, precio FROM menu");
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

    public static function obtenerProducto($producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT menu.id, menu.nombre, menu.precio FROM menu WHERE nombre = :nombre;");
        $consulta->bindValue(':nombre', $producto, PDO::PARAM_STR);
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

            $usr = new Producto();
            $usr->nombre = $nombre;
            $usr->precio = $precio;

            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO menu (nombre, precio) VALUES (:nombre, :precio)");
            $consulta->bindValue(':nombre', $usr->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $usr->precio);
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
}
