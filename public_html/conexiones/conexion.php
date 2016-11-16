<?php
require_once('configure.php');

class Conexion extends PDO {

    private $tipo_de_base = 'mysql';
    private $host = host;
    private $nombre_de_base = database;
    private $usuario = user;
    private $contrasena = password;
    public $estado = '';

    public function __construct() {
        //Sobreescribo el método constructor de la clase PDO.
        try {
            parent::__construct($this->tipo_de_base . ':host=' . $this->host . ';dbname=' . $this->nombre_de_base, $this->usuario, $this->contrasena);
        } catch (PDOException $e) {
            echo json_encode('Ha surgido un error y no se puede conectar al sistema.');
            $estado = False;
            exit;
        }
    }

}

?>
