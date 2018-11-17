<?php
class Login{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "usuarios";

    //columns
    public $nombre;
    public $clave;
    public $tipo;

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

        $stmt->bindValue(":clave", $this->clave);
        $stmt->bindValue(":nombre", $this->nombre);;
        
        $stmt->execute();
    
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->nombre = $fila['nombre'];
        $this->tipo= $fila['tipo'];
        /*
        $this->apellido = $fila['apellido'];
        $this->documento = $fila['documento'];
        $this->email = $fila['email'];
        $this->sistema_id = $fila['sistema_id'];
        $this->vehiculo_id = $fila['vehiculo_id'];
        $this->created = $fila['created'];
        $this->updated = $fila['updated'];
        $this->patente = $fila['patente'];
        $this->servicio = $fila['servicio'];*/
   
    }

    
}
