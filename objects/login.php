<?php
class Login{

    private $connection;
    private $table_name = "usuarios";

    public $nom;
    public $cla;
    public $nombre;
    public $apellido;
    public $tipo;
    public $id;  

    public function __construct($connection){
        $this->connection = $connection;
    }


    function check(){

        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 
                WHERE
                    nombre = :nombre AND clave = :clave";
    
        $stmt = $this->connection->prepare( $query );

        $stmt->bindValue(":clave", $this->cla);
        $stmt->bindValue(":nombre", $this->nom);;
        
        $stmt->execute();
    
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nombre = $fila['nombre'];
        $this->apellido= $fila['apellido'];
        $this->tipo= $fila['tipo'];
        $this->id= $fila['usuario_id'];        
    }
    
}
