<?php
class Chofer{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "chofer";

    // table columns
    public $chofer_id;
    public $apellido;
    public $nombre;
    public $documento;
    public $email;
    public $vehiculo_id;
    public $sistema_id;
    public $created;
    public $updated; 

    public function __construct($connection){
        $this->connection = $connection;
    }

    function read(){
        //hay que arreglar el query este
        $query = "SELECT
                    st.nombre as servicio, v.patente as patente, p.chofer_id, p.nombre, p.apellido, p.documento, p.email, p.vehiculo_id, p.sistema_id, p.created, p.updated
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        sistema_transporte st
                            ON p.sistema_id = st.sistema_id
                    LEFT JOIN
                        vehiculo v
                            ON p.vehiculo_id = v.vehiculo_id
                ORDER BY
                    p.created DESC";
     
        // prepare query statement
        $stmt = $this->connection->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}
