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
                    p.chofer_id, p.nombre, p.apellido, p.documento, p.email, p.vehiculo_id, p.sistema_id, p.created, p.updated, st.nombre as servicio, v.patente as patente
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

    function create(){
 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    apellido=:apellido, nombre=:nombre, documento=:documento, email=:email, vehiculo_id=:vehiculo_id, sistema_id=:sistema_id, created=:created, updated=:updated";
     
        $stmt = $this->connection->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->documento=htmlspecialchars(strip_tags($this->documento));
        $this->sistema_id=htmlspecialchars(strip_tags($this->sistema_id));
        $this->vehiculo_id=htmlspecialchars(strip_tags($this->vehiculo_id));
        
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":updated", $this->updated);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":documento", $this->documento);
        $stmt->bindParam(":sistema_id", $this->sistema_id);
        $stmt->bindParam(":vehiculo_id", $this->vehiculo_id);
     
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }
}
