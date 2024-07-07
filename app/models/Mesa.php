<?php
class Mesa{
    public $id;
    public $estado;
    public $codigoMesa;
    public $cantidadUso;

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

    public static function ObtenerMesa($codigoMesa){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, estadosmesa.nombre as estado, mesas.codigoMesa, mesas.cantidadUso FROM mesas JOIN estadosmesa on estadosmesa.id = mesas.idEstado WHERE mesas.codigoMesa = :codigoMesa;");
        $consulta->bindValue(":codigoMesa", $codigoMesa, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT mesas.id, estadosmesa.nombre as estado, mesas.codigoMesa, mesas.cantidadUso FROM mesas JOIN estadosmesa on estadosmesa.id = mesas.idEstado;");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function cargarMesasPorCSV($csv){
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

            $codigoMesa = $data[0];

            $usr = new Mesa();
            $usr->codigoMesa = $codigoMesa;

            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (idEstado, codigoMesa) VALUES (:idEstado, :codigoMesa)");
            $consulta->bindValue(':codigoMesa', $usr->codigoMesa, PDO::PARAM_STR);
            $consulta->bindValue(':idEstado', 1, PDO::PARAM_INT);
            $consulta->execute();
        }
        
        fclose($file);

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function cargarMesasACSV($filePath){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $stmt = $objAccesoDatos->prepararConsulta("SELECT mesas.codigoMesa FROM mesas;");
        $stmt->execute();
        $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $exportDir = dirname($filePath);
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        $file = fopen($filePath, 'w');

        fputcsv($file, ['codigoMesa']);

        foreach ($mesas as $mesa) {
            fputcsv($file, $mesa);
        }

        fclose($file);
    }

    public static function modificarMesa($codigoMesa, $estado)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET idEstado = :idEstado WHERE codigoMesa = :codigoMesa");

        $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':idEstado', $estado, PDO::PARAM_INT);

        $consulta->execute();
    }

    public static function sumarUsoMesa($codigoMesa){
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET cantidadUso = :cantidadUso WHERE codigoMesa = :codigoMesa");

        $consulta->bindValue(':codigoMesa', $codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':cantidadUso', Mesa::ObtenerMesa($codigoMesa)->cantidadUso + 1, PDO::PARAM_INT);

        $consulta->execute();
    }

    public static function ObtenerMesaMasUsada(){
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("SELECT mesas.id, estadosmesa.nombre as estado, mesas.codigoMesa, mesas.cantidadUso FROM mesas JOIN estadosmesa ON mesas.idEstado = estadosmesa.id ORDER BY mesas.cantidadUso DESC LIMIT 1;");
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }
}