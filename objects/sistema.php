<?php
class sistema{

    // Connection instance
    private $connection;

    // table name
    private $table_name = "sistema_transporte";

    //columns
    public $sistema_id;
    public $nombre;
    public $pais_procedencia;
    public $created;
    public $updated; 

    public function __construct($connection){
        $this->connection = $connection;
    }

    function read(){
        //hay que arreglar el query este
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " 

                ORDER BY
                    created DESC";
     
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
                    nombre=:nombre, pais_procedencia=:pais_procedencia, created=:created, updated=:updated";
     
        $stmt = $this->connection->prepare($query);

        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->pais_procedencia=htmlspecialchars(strip_tags($this->pais_procedencia));
        
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":updated", $this->updated);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":pais_procedencia", $this->pais_procedencia);
     
        if($stmt->execute()){
            return true;
        }
        return false;
         
    }

    function readOne(){
 
        $query = "SELECT
                    p.sistema_id, p.nombre, p.apellido, p.documento, p.email, p.vehiculo_id, p.sistema_id, p.created, p.updated, st.nombre as servicio, v.patente as patente
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        sistema_transporte st
                            ON p.sistema_id = st.sistema_id
                    LEFT JOIN
                        vehiculo v
                            ON p.vehiculo_id = v.vehiculo_id
                WHERE
                    p.sistema_id = ?
                LIMIT
                    0,1";
    
        $stmt = $this->connection->prepare( $query );

        $stmt->bindParam(1, $this->sistema_id);
    
        $stmt->execute();
    
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nombre = $fila['nombre'];
        $this->apellido = $fila['apellido'];
        $this->documento = $fila['documento'];
        $this->email = $fila['email'];
        $this->sistema_id = $fila['sistema_id'];
        $this->vehiculo_id = $fila['vehiculo_id'];
        $this->created = $fila['created'];
        $this->updated = $fila['updated'];
        $this->patente = $fila['patente'];
        $this->servicio = $fila['servicio'];
    /*creo que no haria falta mandar el id de el tipo de servicio porque ya le mando un campo servicio(que es el tipo de servicio ej Uber)
    asi que habria que ver si necesitas ver el id o con que sepas que es uber ya está bien, lo mismo con el id del auto, como solo puede
    manejar un auto directamente le estaba mandando la patente del auto que es mas comodo, pero tal vez necesite el id qcio.*/
    }

    function update(){
 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                apellido=:apellido,
                nombre=:nombre,
                documento=:documento,
                email=:email, 
                vehiculo_id=:vehiculo_id,
                sistema_id=:sistema_id, 
                updated=:updated
                WHERE
                    sistema_id = :sistema_id";
     
        $stmt = $this->connection->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->nombre=htmlspecialchars(strip_tags($this->nombre));
        //$this->created=htmlspecialchars(strip_tags($this->created));
        $this->updated=htmlspecialchars(strip_tags($this->updated));
        $this->apellido=htmlspecialchars(strip_tags($this->apellido));
        $this->sistema_id=htmlspecialchars(strip_tags($this->sistema_id));
        $this->documento=htmlspecialchars(strip_tags($this->documento));
        $this->sistema_id=htmlspecialchars(strip_tags($this->sistema_id));
        $this->vehiculo_id=htmlspecialchars(strip_tags($this->vehiculo_id));
        
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":updated", $this->updated);
        //$stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":apellido", $this->apellido);
        $stmt->bindParam(":sistema_id", $this->sistema_id);
        $stmt->bindParam(":documento", $this->documento);
        $stmt->bindParam(":sistema_id", $this->sistema_id);
        $stmt->bindParam(":vehiculo_id", $this->vehiculo_id);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    
    //Esta deberia servir para todas las tablas porque sólo pide id, le cambiamos sistema_id por sistema_id etc.
    function delete(){
 
        $query = "DELETE FROM " . $this->table_name . " WHERE sistema_id = ?";

        $stmt = $this->connection->prepare($query);
     
        $this->sistema_id=htmlspecialchars(strip_tags($this->sistema_id));
     
        $stmt->bindParam(1, $this->sistema_id);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }

    //esto tambien es multiuso
    function search($keywords){
 
        $query = "SELECT
                    p.sistema_id, p.nombre, p.apellido, p.documento, p.email, p.vehiculo_id, p.sistema_id, p.created, p.updated, st.nombre as servicio, v.patente as patente
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        sistema_transporte st
                            ON p.sistema_id = st.sistema_id
                    LEFT JOIN
                        vehiculo v
                            ON p.vehiculo_id = v.vehiculo_id
                WHERE
                    p.nombre LIKE ? OR p.apellido LIKE ? OR p.documento LIKE ?
                ORDER BY
                    p.created DESC";
     
        $stmt = $this->connection->prepare($query);
     
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
     
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
     
        $stmt->execute();
     
        return $stmt;
    }
}
