<?php

class Usuario
{
    public $id;
    public $usuario;
    public $clave;
    public $perfil;

    private function obtenerId($table, $param, $atributte){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $stmt = $objAccesoDatos->prepararConsulta("SELECT id FROM ".$table." WHERE nombre = ".$param);
        $stmt->execute([$param => $atributte]);
        return $stmt->fetchColumn();
    }

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, clave, idPerfil) VALUES (:usuario, :clave, :idPerfil)");
        $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash);
        $consulta->bindValue(':idPerfil', $this->obtenerId("perfiles",":nombrePerfil", $this->perfil), PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, usuarios.clave, perfiles.nombre as perfil FROM usuarios JOIN perfiles on perfiles.id = usuarios.idPerfil");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, usuarios.clave, perfiles.nombre as perfil FROM usuarios JOIN perfiles on perfiles.id = usuarios.idPerfil WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function obtenerUsuarioPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, usuarios.clave, perfiles.nombre as perfil FROM usuarios JOIN perfiles on perfiles.id = usuarios.idPerfil WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function modificarUsuario($user)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET usuario = :usuario, clave = :clave WHERE id = :id");
        $consulta->bindValue(':usuario', $user->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $user->clave, PDO::PARAM_STR);
        $consulta->bindValue(':id', $user->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }

    public static function cargarUsuariosPorCSV($csv){
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

            $usuario = $data[0];
            $clave = $data[1];
            $perfil = $data[2];
            
            // Hashear la clave antes de guardarla en la base de datos
            $hashedClave = password_hash($clave, PASSWORD_DEFAULT);

            $usr = new Usuario();
            $usr->usuario = $usuario;
            $usr->clave = $hashedClave;
            $usr->perfil = $perfil;

            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, clave, idPerfil) VALUES (:usuario, :clave, :idPerfil)");
            $consulta->bindValue(':idPerfil', $usr->obtenerId("perfiles",":nombrePerfil", $usr->perfil), PDO::PARAM_INT);
            $consulta->bindValue(':clave', $usr->clave, PDO::PARAM_STR);
            $consulta->bindValue(':usuario', $usr->usuario, PDO::PARAM_STR);
            $consulta->execute();
        }
        
        fclose($file);

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function cargarUsuariosACSV($filePath){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $stmt = $objAccesoDatos->prepararConsulta("SELECT usuarios.id, usuarios.usuario, usuarios.clave, perfiles.nombre as perfil FROM usuarios JOIN perfiles on perfiles.id = usuarios.idPerfil");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $exportDir = dirname($filePath);
        if (!is_dir($exportDir)) {
            mkdir($exportDir, 0777, true);
        }

        $file = fopen($filePath, 'w');

        fputcsv($file, ['usuario', 'clave', 'perfil']);

        foreach ($usuarios as $usuario) {
            fputcsv($file, $usuario);
        }

        fclose($file);
    }
}